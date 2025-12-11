<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class CleanupDummyImages extends Command
{
    protected $signature = 'ulosta:cleanup-dummy-images {--dry-run : Tampilkan saja tanpa menghapus}';
    protected $description = 'Hapus produk dan galeri dummy yang memakai path public/image atau filename tanpa folder.';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');

        $this->info('Mencari produk dummy (image menunjuk ke public/image atau hanya filename)...');

        $candidates = Product::whereNotNull('image')
            ->where(function ($q) {
                $q->where('image', 'like', 'image/%')
                    ->orWhere('image', 'like', '%public/image%')
                    ->orWhere('image', 'not like', '%/%');
            })
            ->select(['id', 'name', 'image'])
            ->get();

        $this->line('Kandidat produk: ' . $candidates->count());
        foreach ($candidates as $p) {
            $this->line(" - #{$p->id} {$p->name} ({$p->image})");
        }

        $galleryCandidates = DB::table('product_images')
            ->where(function ($q) {
                $q->where('path', 'like', 'image/%')
                    ->orWhere('path', 'like', '%public/image%');
            })
            ->select(['id', 'product_id', 'path'])
            ->get();

        $this->line('Kandidat galeri: ' . $galleryCandidates->count());
        foreach ($galleryCandidates as $g) {
            $this->line(" - gallery #{$g->id} product_id={$g->product_id} ({$g->path})");
        }

        if ($dry) {
            $this->warn('Dry run: tidak ada data yang dihapus.');
            return Command::SUCCESS;
        }

        DB::transaction(function () use ($candidates, $galleryCandidates) {
            // Hapus galeri dummy terlebih dahulu
            $galleryIds = $galleryCandidates->pluck('id');
            if ($galleryIds->count() > 0) {
                DB::table('product_images')->whereIn('id', $galleryIds)->delete();
            }

            // Hapus produk dummy
            $productIds = $candidates->pluck('id');
            if ($productIds->count() > 0) {
                Product::whereIn('id', $productIds)->delete();
            }
        });

        $this->info('Pembersihan selesai.');
        $this->info('Dihapus produk: ' . $candidates->count());
        $this->info('Dihapus galeri: ' . $galleryCandidates->count());

        return Command::SUCCESS;
    }
}
