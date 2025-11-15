<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Dashboard Toko - UlosTa Seller</title>
    <link rel="stylesheet" href="{{ asset('css/seller.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body class="seller-root">
    <header class="seller-header">
        <div class="container">
            <div class="left">
                <div class="brand">
                    <div class="brand-logo">U</div>
                    <div class="brand-name">UlosTa Seller</div>
                </div>
                <nav class="top-nav">
                    <a class="active" href="#">Dashboard</a>
                    <a href="#">Produk</a>
                    <a href="#">Pesanan</a>
                    <a href="#">Laporan</a>
                </nav>
            </div>
            <div class="right">
                <a class="btn-outline" href="#">Kembali ke Toko</a>
                <div class="avatar" title="Akun">👤</div>
            </div>
        </div>
    </header>

    <main class="container page">
        <div class="page-head">
            <div>
                <h1>Dashboard Toko</h1>
                <p class="muted">Kelola produk dan pesanan Ulos Anda</p>
            </div>
            <div class="actions">
                <a class="btn-settings" href="#">Pengaturan Toko</a>
                <a class="btn-primary" href="#">+ Tambah Produk</a>
            </div>
        </div>

        <section class="stats-grid">
            <div class="card stat">
                <div class="stat-icon">📦</div>
                <div class="stat-title">Total Produk</div>
                <div class="stat-value">24</div>
            </div>
            <div class="card stat">
                <div class="stat-icon">🛒</div>
                <div class="stat-title">Total Pesanan</div>
                <div class="stat-value">147</div>
            </div>
            <div class="card stat">
                <div class="stat-icon">💵</div>
                <div class="stat-title">Pendapatan bulan ini</div>
                <div class="stat-value">Rp 12.250.000</div>
            </div>
            <div class="card stat">
                <div class="stat-icon">📈</div>
                <div class="stat-title">Total Pendapatan</div>
                <div class="stat-value">Rp 45.500.000</div>
            </div>
        </section>

        <section class="main-grid">
            <div class="card big card-products">
                <div class="card-head">
                    <h3>Produk terlaris</h3>
                </div>
                <ol class="top-products">
                    <li>
                        <div class="rank">1</div>
                        <div class="thumb" style="background-image:url('/images/ulos1.svg')"></div>
                        <div class="info">
                            <div class="title">Ulos Ragi Hotang</div>
                            <div class="sub muted">45 Terjual</div>
                        </div>
                        <div class="price">Rp 56.250.000</div>
                    </li>
                    <li>
                        <div class="rank">2</div>
                        <div class="thumb" style="background-image:url('/images/ulos2.svg')"></div>
                        <div class="info">
                            <div class="title">Ulos Bintang Maratur</div>
                            <div class="sub muted">38 Terjual</div>
                        </div>
                        <div class="price">Rp 36.100.000</div>
                    </li>
                    <li>
                        <div class="rank">3</div>
                        <div class="thumb" style="background-image:url('/images/ulos3.svg')"></div>
                        <div class="info">
                            <div class="title">Ulos Sibolang</div>
                            <div class="sub muted">32 Terjual</div>
                        </div>
                        <div class="price">Rp 35.200.000</div>
                    </li>
                </ol>
            </div>

            <div class="card card-orders">
                <div class="card-head">
                    <h3>Pesanan Terbaru</h3>
                </div>
                <ul class="recent-orders">
                    <li>
                        <div class="order-id">ORD-2024-001</div>
                        <div class="order-meta">Grace Caldera • 2025-01-25</div>
                        <div class="order-right">
                            <div class="amount">Rp 850.000</div>
                            <div class="badge pending">pending</div>
                        </div>
                    </li>
                    <li>
                        <div class="order-id">ORD-2024-002</div>
                        <div class="order-meta">Daniel S • 2025-01-28</div>
                        <div class="order-right">
                            <div class="amount">Rp 1.500.000</div>
                            <div class="badge success">processing</div>
                        </div>
                    </li>
                </ul>
                <a class="btn-outline w-full" href="#">Lihat Semua Pesanan</a>
            </div>

            <div class="card feature">
                <div class="feature-icon">📦</div>
                <div class="feature-title">Kelola Produk</div>
                <div class="feature-desc muted">Tambah, edit, atau hapus produk ulos</div>
            </div>
            <div class="card feature">
                <div class="feature-icon">🛒</div>
                <div class="feature-title">Kelola Pesanan</div>
                <div class="feature-desc muted">Proses dan pantau pesanan pelanggan</div>
            </div>
            <div class="card feature">
                <div class="feature-icon">📈</div>
                <div class="feature-title">Laporan Penjualan</div>
                <div class="feature-desc muted">Lihat statistik dan analisis toko</div>
            </div>
        </section>
    </main>

    <footer class="seller-footer">
        <div class="container">© {{ date('Y') }} UlosTa — Seller Dashboard</div>
    </footer>

</body>

</html>
