<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $product['title'] ?? 'Detail Produk - UlosTa' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff;
            color: #333;
            line-height: 1.6;
        }

        .header {
            background: #fff;
            border-bottom: 1px solid #e5e5e5;
            padding: 15px 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: #b91c1c;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }

        .logo-text {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .search-box {
            flex: 1;
            max-width: 500px;
            margin: 0 40px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px 12px 50px;
            border: 1px solid #ddd;
            border-radius: 25px;
            background: #f8f8f8;
            font-size: 14px;
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #b91c1c;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .breadcrumb {
            padding: 15px 0;
            font-size: 14px;
            color: #666;
        }

        .product-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            padding: 20px 0;
        }

        .product-images {
            position: relative;
        }

        .main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e5e5e5;
            margin-bottom: 15px;
        }

        .image-thumbnails {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .thumbnail {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: #b91c1c;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #dc2626;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }

        .wishlist-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s;
        }

        .wishlist-btn:hover {
            background: white;
        }

        .product-info {
            padding-top: 10px;
        }

        .product-tags {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .tag {
            background: #f3f4f6;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            color: #666;
            border: 1px solid #e5e5e5;
        }

        .product-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #111;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .stars {
            color: #fbbf24;
        }

        .review-count {
            color: #666;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .current-price {
            font-size: 32px;
            font-weight: bold;
            color: #dc2626;
        }

        .original-price {
            font-size: 18px;
            color: #999;
            text-decoration: line-through;
        }

        .discount-badge {
            background: #fef2f2;
            color: #dc2626;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #fecaca;
        }

        .product-description {
            color: #555;
            line-height: 1.7;
            margin-bottom: 25px;
            padding-top: 15px;
            border-top: 1px solid #e5e5e5;
        }

        .specifications {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
            padding: 20px;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            background: #fafafa;
        }

        .spec-item {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            padding: 8px 0;
        }

        .spec-label {
            color: #666;
        }

        .spec-value {
            font-weight: 600;
            color: #333;
        }

        .quantity-section {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .quantity-label {
            font-weight: 600;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: #f8f8f8;
            cursor: pointer;
            font-weight: bold;
            font-size: 18px;
        }

        .qty-input {
            width: 60px;
            height: 40px;
            border: none;
            text-align: center;
            font-weight: 600;
            outline: none;
        }

        .stock-info {
            color: #666;
            font-size: 14px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .btn-cart {
            flex: 1;
            padding: 15px 20px;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-cart:hover {
            background: #b91c1c;
        }

        .btn-buy {
            padding: 15px 30px;
            background: #111;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-buy:hover {
            background: #333;
        }

        .product-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .feature {
            text-align: center;
            padding: 15px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            background: #fafafa;
        }

        .feature-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .feature-desc {
            font-size: 12px;
            color: #666;
        }

        .recommendations {
            margin-top: 60px;
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
            color: #111;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .product-card {
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            background: white;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
        }

        .card-tag {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }

        .card-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .card-price {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .card-current-price {
            font-weight: bold;
            color: #dc2626;
        }

        .card-original-price {
            font-size: 14px;
            color: #999;
            text-decoration: line-through;
        }

        .card-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-link {
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .card-btn {
            background: #111;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }

        .card-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #dc2626;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .card-wishlist {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .footer {
            background: #111;
            color: white;
            margin-top: 80px;
            padding: 60px 0 30px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .footer-logo {
            width: 40px;
            height: 40px;
            background: #dc2626;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }

        .footer-brand-text {
            font-size: 24px;
            font-weight: bold;
        }

        .footer-desc {
            color: #ccc;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .footer-section h3 {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-contact {
            color: #ccc;
            line-height: 1.8;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 25px;
            text-align: center;
            color: #999;
            font-size: 14px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #ccc;
            transition: background 0.3s;
        }

        .social-link:hover {
            background: #dc2626;
            color: white;
        }

        @media (max-width: 768px) {
            .product-section {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .nav-links {
                gap: 15px;
            }

            .nav-link span {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <div class="logo-icon">U</div>
                <div class="logo-text">UlosTa</div>
            </div>

            <div class="search-box">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <circle cx="11" cy="11" r="8" stroke="#666" stroke-width="2" />
                    <path d="m21 21-4.35-4.35" stroke="#666" stroke-width="2" />
                </svg>
                <input type="text" class="search-input" placeholder="Cari ulos tradisional ...">
            </div>

            <nav class="nav-links">
                <a href="/" class="nav-link">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M3 9l9-7 9 7v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor"
                            stroke-width="2" />
                        <polyline points="9,22 9,12 15,12 15,22" stroke="currentColor" stroke-width="2" />
                    </svg>
                    <span>Home</span>
                </a>
                <a href="#" class="nav-link">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                            stroke="currentColor" stroke-width="2" />
                    </svg>
                    <span>Wishlist</span>
                </a>
                <a href="{{ route('tambah.ke.keranjang') }}" class="nav-link">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
                        <circle cx="9" cy="21" r="1" stroke="currentColor" stroke-width="2" />
                        <circle cx="20" cy="21" r="1" stroke="currentColor" stroke-width="2" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" stroke="currentColor"
                            stroke-width="2" />
                    </svg>
                    <span>Keranjang</span>
                </a>
                <a href="{{ route('masuk') }}" class="nav-link">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" />
                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" />
                    </svg>
                    <span>Profil</span>
                </a>
            </nav>
        </div>
    </header>

    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            Beranda / Produk / {{ $product['title'] ?? 'Ulos Ragihotang Premium' }}
        </div>

        <!-- Product Section -->
        <div class="product-section">
            <!-- Product Images -->
            <div class="product-images">
                <div class="product-badge">Premium Quality</div>
                <button class="wishlist-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                            stroke="currentColor" stroke-width="2" />
                    </svg>
                </button>
                @php
                    // Mendukung $product sebagai array atau objek Eloquent
                    $prodImageUrl = null;
                    $prodImage = null;
                    $prodName = null;
                    if (is_array($product)) {
                        $prodImageUrl = $product['image_url'] ?? null;
                        $prodImage = $product['image'] ?? null;
                        $prodName = $product['name'] ?? ($product['title'] ?? 'Produk');
                    } else {
                        try {
                            $prodImageUrl = $product->image_url ?? null;
                        } catch (\Throwable $e) {
                            $prodImageUrl = null;
                        }
                        $prodImage = $product->image ?? null;
                        $prodName = $product->name ?? ($product->title ?? 'Produk');
                    }
                    if (!$prodImageUrl) {
                        $prodImageUrl = $prodImage
                            ? asset('storage/' . ltrim($prodImage, '/'))
                            : asset('image/placeholder.png');
                    }
                @endphp
                <img id="mainImage" class="main-image" src="{{ $prodImageUrl }}" alt="{{ $prodName }}">

                <div class="image-thumbnails">
                    @foreach ($product['images'] ?? [asset('image/ulos1.jpeg'), asset('image/ulos2.jpg'), asset('image/ulos3.jpg'), asset('image/ulos4.jpg')] as $index => $img)
                        <img src="{{ $img }}" alt="Thumbnail {{ $index + 1 }}"
                            class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                            onclick="changeMainImage('{{ $img }}', this)">
                    @endforeach
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <div class="product-tags">
                    @foreach ($product['tags'] ?? ['Ragi Hotang', 'Pernikahan'] as $tag)
                        <span class="tag">{{ $tag }}</span>
                    @endforeach
                </div>

                <h1 class="product-title">{{ $product['title'] ?? 'Ulos Ragihotang Premium' }}</h1>

                <div class="product-rating">
                    <div class="stars">★★★★★</div>
                    <span class="review-count">({{ $product['reviews'] ?? 28 }} ulasan)</span>
                </div>

                <div class="product-price">
                    <span class="current-price">Rp
                        {{ number_format($product['price'] ?? 1250000, 0, ',', '.') }}</span>
                    <span class="original-price">Rp
                        {{ number_format($product['original_price'] ?? 1500000, 0, ',', '.') }}</span>
                    <span class="discount-badge">Hemat 17%</span>
                </div>

                <div class="product-description">
                    <h3>Deskripsi Produk</h3>
                    {{ $product['description'] ?? 'Ulos Ragihotang Premium adalah kain tenun tradisional Batak yang dibuat dengan teknik tenun ikat berkualitas tinggi. Motif Ragi Hotang melambangkan keharmonisan dan kekuatan, cocok untuk upacara pernikahan adat Batak. Terbuat dari benang berkualitas tinggi dengan pewarnaan alami yang tahan lama.' }}
                </div>

                <div class="specifications">
                    <h3 style="grid-column: 1/-1; margin-bottom: 10px; font-size: 16px; color: #333;">Spesifikasi</h3>
                    <div class="spec-item">
                        <span class="spec-label">Jenis Ulos</span>
                        <span class="spec-value">{{ $product['jenis'] ?? 'Ragihotang' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Fungsi</span>
                        <span class="spec-value">{{ $product['fungsi'] ?? 'Pernikahan' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Ukuran</span>
                        <span class="spec-value">{{ $product['ukuran'] ?? '200 x 150 cm' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Berat</span>
                        <span class="spec-value">{{ $product['berat'] ?? '800 gram' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Material</span>
                        <span class="spec-value">{{ $product['material'] ?? 'Katun Premium' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Material</span>
                        <span class="spec-value">{{ $product['asal'] ?? 'Sumatera Utara' }}</span>
                    </div>
                </div>

                <div class="quantity-section">
                    <span class="quantity-label">Jumlah</span>
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="decreaseQuantity()">-</button>
                        <input type="number" id="quantity" class="qty-input" value="1" min="1"
                            max="15">
                        <button class="qty-btn" onclick="increaseQuantity()">+</button>
                    </div>
                    <span class="stock-info">Stok: {{ $product['stock'] ?? 15 }} pcs</span>
                </div>

                <div class="action-buttons">
                    <button class="btn-cart" onclick="addToCart()">Tambah ke Keranjang</button>
                    <button class="btn-buy" onclick="buyNow()">Buy Now</button>
                </div>

                <div class="product-features">
                    <div class="feature">
                        <div class="feature-title">Gratis Ongkir</div>
                        <div class="feature-desc">Min. Belanja</div>
                    </div>
                    <div class="feature">
                        <div class="feature-title">100% Original</div>
                        <div class="feature-desc">Garansi asli</div>
                    </div>
                    <div class="feature">
                        <div class="feature-title">14 hari retur</div>
                        <div class="feature-desc">Syarat dan ketentuan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <section class="recommendations">
            <h2 class="section-title">Rekomendasi Ulos</h2>
            <p style="color: #666; margin-bottom: 25px;">Produk lain yang mungkin anda sukai</p>

            <div class="product-grid">
                @foreach ($recommendations ?? [['title' => 'Ulos Bintang Maratur', 'price' => 750000, 'old' => 900000, 'img' => asset('image/ulos4.jpg'), 'tag' => 'Kelahiran'], ['title' => 'Ulos Ragi Idup', 'price' => 860000, 'old' => 990000, 'img' => asset('image/ulos5.webp'), 'tag' => 'Pernikahan'], ['title' => 'Ulos Bintang Maratur', 'price' => 750000, 'old' => 900000, 'img' => asset('image/ulos2.jpg'), 'tag' => 'Kelahiran']] as $rec)
                    <div class="product-card">
                        <span class="card-badge">Terjual</span>
                        <button class="card-wishlist">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                                    stroke="currentColor" stroke-width="2" />
                            </svg>
                        </button>
                        <img src="{{ $rec['img'] }}" alt="{{ $rec['title'] }}" class="card-image">
                        <div class="card-content">
                            <div class="card-tag">{{ $rec['tag'] }}</div>
                            <h3 class="card-title">{{ $rec['title'] }}</h3>
                            <div class="card-price">
                                <span class="card-current-price">Rp
                                    {{ number_format($rec['price'], 0, ',', '.') }}</span>
                                <span class="card-original-price">Rp
                                    {{ number_format($rec['old'], 0, ',', '.') }}</span>
                            </div>
                            <div class="card-actions">
                                <a href="#" class="card-link">Tambah ke Keranjang</a>
                                <button class="card-btn">Beli</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div>
                <div class="footer-brand">
                    <div class="footer-logo">U</div>
                    <div class="footer-brand-text">UlosTa</div>
                </div>
                <p class="footer-desc">
                    Platform jual beli Ulos terpercaya untuk melestarikan tradisi Batak
                </p>
                <div class="social-links">
                    <a href="#" class="social-link">f</a>
                    <a href="#" class="social-link">ig</a>
                    <a href="#" class="social-link">tw</a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Tautan Cepat</h3>
                <ul class="footer-links">
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Cara Berbelanja</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat dan Ketentuan</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Kategori</h3>
                <ul class="footer-links">
                    <li><a href="#">Ragihotang</a></li>
                    <li><a href="#">Bintang Maratur</a></li>
                    <li><a href="#">Sibolang</a></li>
                    <li><a href="#">Semua Produk</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Hubungi Kami</h3>
                <div class="footer-contact">
                    Jl. Sisinga mangaraja<br>
                    No 93 Medan, Sumatera Utara<br><br>
                    +62 812 3456 7890<br><br>
                    ppw@gmail.com
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            © 2024 UlosTa - Ulos Marketplace
        </div>
    </footer>

    <script>
        function changeMainImage(src, thumbnail) {
            document.getElementById('mainImage').src = src;

            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });

            // Add active class to clicked thumbnail
            thumbnail.classList.add('active');
        }

        function increaseQuantity() {
            const qty = document.getElementById('quantity');
            const max = parseInt(qty.getAttribute('max'));
            if (parseInt(qty.value) < max) {
                qty.value = parseInt(qty.value) + 1;
            }
        }

        function decreaseQuantity() {
            const qty = document.getElementById('quantity');
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
            }
        }

        function addToCart() {
            const quantity = document.getElementById('quantity').value;
            // Add your cart logic here
            alert('Produk ditambahkan ke keranjang dengan jumlah: ' + quantity);
        }

        function buyNow() {
            const quantity = document.getElementById('quantity').value;
            // Add your buy now logic here  
            alert('Beli sekarang dengan jumlah: ' + quantity);
        }
    </script>
</body>

</html>
