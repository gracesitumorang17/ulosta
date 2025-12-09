<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;

class SellerProductController extends Controller
{
    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string', // fungsi
            'jenis' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'material' => 'nullable|string',
            'size' => 'nullable|string',
            'weight' => 'nullable|integer',
            'origin' => 'nullable|string',
            'status' => 'nullable|boolean',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Slug unik per produk
        $slug = Str::slug($data['name']) . '-' . Str::random(6);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

                // ✅ Simpan di storage/app/public/products/{slug}/{filename}
                Storage::disk('public')->putFileAs('products/' . $slug, $file, $filename);

                // ✅ Simpan hanya path relatif (bukan URL penuh)
                $images[] = 'products/' . $slug . '/' . $filename;
            }
        }

        // Simpan ke database
        $product = Product::create([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? '',
            'price' => (int) round($data['price']),
            'original_price' => null,
            // Simpan jenis ke kolom tag, fungsi ke category
            'tag' => $data['jenis'] ?? ($data['category'] ?? ''),
            'category' => $data['category'],
            'image' => $images[0] ?? null, // Path relatif
            'stock' => (int) $data['stock'],
            'is_active' => (bool) ($data['status'] ?? true),
        ]);

        // Simpan ke session agar langsung muncul di daftar seller
        $custom = session()->get('custom_products', []);
        $custom[$slug] = [
            'title' => $data['name'],
            'slug' => $slug,
            'category' => $data['category'],
            'price' => (int) $data['price'],
            'stock' => (int) $data['stock'],
            'sold' => 0,
            'status' => ($data['status'] ?? true) ? 'Aktif' : 'Nonaktif',
            // ✅ Tampilkan gambar dengan URL publik (hanya untuk tampilan)
            'img' => isset($images[0]) ? asset('storage/' . $images[0]) : asset('image/ulos1.jpeg'),
            'images' => array_map(fn($i) => asset('storage/' . $i), $images),
            'description' => $data['description'] ?? '',
            'material' => $data['material'] ?? '',
            'size' => $data['size'] ?? '',
            'weight' => $data['weight'] ?? 0,
            'origin' => $data['origin'] ?? '',
        ];
        session()->put('custom_products', $custom);

        return redirect()->route('seller.products.edit', $slug)
            ->with('success', 'Produk berhasil disimpan.');
    }

    /**
     * Edit produk
     */
    public function edit(string $slug)
    {
        // Cek data dari session
        $custom = session()->get('custom_products', []);
        if (isset($custom[$slug])) {
            $c = $custom[$slug];
            $product = [
                'name' => $c['title'] ?? 'Produk',
                'category' => $c['category'] ?? 'Serbaguna',
                'price' => $c['price'] ?? 0,
                'stock' => $c['stock'] ?? 0,
                'description' => $c['description'] ?? '',
                'material' => $c['material'] ?? '',
                'size' => $c['size'] ?? '',
                'weight' => $c['weight'] ?? 0,
                'origin' => $c['origin'] ?? '',
                'status' => ($c['status'] ?? 'Aktif') === 'Aktif',
                'images' => $c['images'] ?? [],
            ];

            // Ambil daftar gambar yang sudah di-upload dari storage publik
            // Hanya tampilkan satu gambar saat ini (current)
            $uploaded = [];
            if (!empty($product['images'])) {
                // Ambil gambar utama pertama sebagai current
                $uploaded = [$product['images'][0]];
            }

            $slugValue = $slug;
            return view('seller.products.edit', compact('product', 'slugValue', 'uploaded'));
        }

        // Jika tidak ada di session, ambil dari database
        // Jika kolom 'slug' belum ada (sebelum migrasi dijalankan), fallback ke pencarian nama
        try {
            $productModel = Product::where('slug', $slug)
                ->orWhere('name', 'like', str_replace('-', ' ', $slug) . '%')
                ->first();
        } catch (\Illuminate\Database\QueryException $e) {
            // Unknown column 'slug' in where clause
            $productModel = Product::where('name', 'like', str_replace('-', ' ', $slug) . '%')->first();
        }

        if ($productModel) {
            $product = [
                'name' => $productModel->name,
                'category' => $productModel->category ?? $productModel->tag,
                'price' => $productModel->price,
                'stock' => $productModel->stock,
                'description' => $productModel->description,
                'material' => '',
                'size' => '',
                'weight' => 0,
                'origin' => '',
                'status' => (bool) $productModel->is_active,
                // ✅ Gunakan asset('storage/...') jika path relatif
                'images' => [
                    $productModel->image
                        ? (str_starts_with($productModel->image, 'http')
                            ? $productModel->image
                            : asset('storage/' . ltrim($productModel->image, '/')))
                        : asset('image/ulos1.jpeg')
                ],
            ];

            // Kumpulkan dari storage + gambar utama, lalu dedup
            // Tampilkan hanya satu gambar saat ini (current)
            $uploaded = [];
            if (!empty($product['images'])) {
                $uploaded = [$product['images'][0]];
            }
            $slugValue = $slug;

            return view('seller.products.edit', compact('product', 'slugValue', 'uploaded'));
        }

        return redirect()->route('seller.products.index')
            ->with('error', 'Produk tidak ditemukan untuk slug tersebut.');
    }

    /**
     * Upload gambar tambahan
     */
    public function uploadImages(Request $request, string $slug)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'images.required' => 'Minimal satu gambar harus dipilih.',
        ]);

        // Pastikan produk/slug valid sebelum upload
        try {
            $product = Product::where('slug', $slug)
                ->orWhere('name', 'like', str_replace('-', ' ', $slug) . '%')
                ->first();
        } catch (\Illuminate\Database\QueryException $e) {
            $product = Product::where('name', 'like', str_replace('-', ' ', $slug) . '%')->first();
        }

        if (!$product) {
            return redirect()->route('seller.products.index')
                ->with('error', 'Produk tidak ditemukan. Tidak dapat mengunggah gambar.');
        }

        foreach ($request->file('images') as $file) {
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('products/' . $slug, $file, $filename);
        }

        return redirect()->route('seller.products.edit', $slug)
            ->with('success', 'Gambar berhasil diupload.');
    }

    /**
     * Update produk (informasi dasar)
     */
    public function update(Request $request, string $slug)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'material' => 'nullable|string',
            'size' => 'nullable|string',
            'weight' => 'nullable|integer',
            'origin' => 'nullable|string',
            'status' => 'nullable',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Temukan produk berdasarkan slug atau fallback by name
        try {
            $product = Product::where('slug', $slug)
                ->orWhere('name', 'like', str_replace('-', ' ', $slug) . '%')
                ->firstOrFail();
        } catch (\Illuminate\Database\QueryException $e) {
            $product = Product::where('name', 'like', str_replace('-', ' ', $slug) . '%')->firstOrFail();
        }

        // Update kolom utama
        $product->name = $data['name'];
        $product->category = $data['category'];
        // Persist Jenis from input to tag; fallback to existing tag
        $product->tag = $request->input('jenis', $product->tag);
        $product->price = (int) round($data['price']);
        $product->stock = (int) $data['stock'];
        $product->description = $data['description'] ?? $product->description;
        $product->is_active = $request->boolean('status');

        // Jika ada file gambar baru, simpan dan jadikan gambar utama
        if ($request->hasFile('images')) {
            $savedPaths = [];
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('products/' . $slug, $file, $filename);
                $savedPaths[] = 'products/' . $slug . '/' . $filename; // path relatif
            }
            if (!empty($savedPaths)) {
                // Set gambar utama ke file pertama yang diunggah
                $product->image = $savedPaths[0];
            }
        }
        $product->save();

        // Perbarui session custom agar konsisten jika ada
        $custom = session()->get('custom_products', []);
        if (isset($custom[$slug])) {
            $custom[$slug] = array_merge($custom[$slug], [
                'title' => $product->name,
                'category' => $product->category,
                'price' => (int) $product->price,
                'stock' => (int) $product->stock,
                'status' => $product->is_active ? 'Aktif' : 'Nonaktif',
                'description' => $product->description,
                'material' => $data['material'] ?? ($custom[$slug]['material'] ?? ''),
                'size' => $data['size'] ?? ($custom[$slug]['size'] ?? ''),
                'weight' => $data['weight'] ?? ($custom[$slug]['weight'] ?? 0),
                'origin' => $data['origin'] ?? ($custom[$slug]['origin'] ?? ''),
            ]);
            session()->put('custom_products', $custom);
        }

        return redirect()->route('seller.products.edit', $slug)
            ->with('success', 'Perubahan produk berhasil disimpan.');
    }
}
