<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UlosTa Admin - Laporan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--red:#AE0808;--bg:#f8f9fa;--muted:#6c757d;--card:#fff;--border:#e9ecef;--text:#212529;--green:#28a745;--orange:#ff9800;--yellow:#ffc107;--blue:#2196f3;--purple:#9c27b0;--gray:#6c757d}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);line-height:1.5}
        .layout{display:flex;min-height:100vh}

        /* sidebar */
        .sidebar{width:280px;background:var(--card);border-right:1px solid var(--border);padding:24px 0}
        .brand{display:flex;align-items:center;gap:12px;margin-bottom:32px;padding:0 24px}
        .brand .logo{width:48px;height:48px;border-radius:12px;background:var(--red);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:24px}
        .brand-info .brand-text{font-size:24px;font-weight:700;color:var(--text)}
        .brand-info .brand-sub{font-size:14px;color:var(--muted)}
        
        .nav{padding:0 24px}
        .nav-item{margin-bottom:8px}
        .nav-link{display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:8px;color:var(--text);text-decoration:none;font-weight:500;transition:all 0.2s}
        .nav-link:hover{background:#f8f9fa}
        .nav-link.active{background:var(--red);color:#fff}
        .nav-icon{width:20px;height:20px;display:flex;align-items:center;justify-content:center}

        /* main */
        .main{flex:1;background:var(--bg)}
        .header{background:var(--card);border-bottom:1px solid var(--border);padding:16px 32px;display:flex;justify-content:space-between;align-items:center}
        .header h1{font-size:24px;font-weight:600}
        .header-right{display:flex;align-items:center;gap:16px}
        .search-box{display:flex;align-items:center;gap:8px;background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:8px 12px;min-width:200px}
        .search-box input{border:0;outline:none;background:transparent;font-size:14px;flex:1}
        .user-info{display:flex;align-items:center;gap:8px}
        .user-avatar{width:32px;height:32px;border-radius:50%;background:var(--red);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:12px}
        .user-details{text-align:right}
        .user-name{font-size:13px;font-weight:500}
        .user-email{font-size:11px;color:var(--muted)}

        .content{padding:32px}
        
        /* page content */
        .page-header{margin-bottom:32px}
        .page-title{font-size:28px;font-weight:700;margin-bottom:8px}
        .page-desc{color:var(--muted);font-size:16px}

        /* stats cards */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px;margin-bottom:32px}
        .stat-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:24px;position:relative;overflow:hidden}
        .stat-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px}
        .stat-title{font-size:14px;color:var(--muted);margin-bottom:8px;font-weight:500}
        .stat-number{font-size:28px;font-weight:700;color:var(--text)}

        .stat-card.active .stat-icon{background:#e3f2fd;color:var(--blue)}
        .stat-card.products .stat-icon{background:#f3e5f5;color:var(--purple)}
        .stat-card.transactions .stat-icon{background:#e8f5e8;color:var(--green)}
        .stat-card.verification .stat-icon{background:#fff3e0;color:var(--orange)}

        /* charts section */
        .charts-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:32px}
        .chart-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:24px}
        .chart-title{font-size:18px;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:8px}
        .chart-icon{color:var(--red)}

        /* date filter */
        .filter-section{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:20px;margin-bottom:32px;display:flex;justify-content:space-between;align-items:center}
        .filter-group{display:flex;gap:16px;align-items:center}
        .filter-label{font-weight:500;font-size:14px}
        .filter-select{padding:8px 12px;border:1px solid var(--border);border-radius:6px;font-size:14px;background:var(--card)}
        .export-btn{background:var(--green);color:#fff;border:none;padding:8px 16px;border-radius:6px;font-weight:500;cursor:pointer;display:flex;align-items:center;gap:8px}
        .export-btn:hover{background:#218838}

        /* additional metrics */
        .metrics-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:32px}
        .metric-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:20px}
        .metric-title{font-size:16px;font-weight:600;margin-bottom:16px;color:var(--text)}
        .metric-item{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding:8px 0;border-bottom:1px solid #f5f5f5}
        .metric-item:last-child{margin-bottom:0;border-bottom:none}
        .metric-label{font-size:14px;color:var(--muted)}
        .metric-value{font-weight:600;color:var(--text)}
        .metric-trend{font-size:12px;padding:2px 6px;border-radius:4px}
        .trend-up{background:#e8f5e8;color:var(--green)}
        .trend-down{background:#ffebee;color:var(--red-light)}

        /* performance chart */
        .performance-chart{height:250px;display:flex;align-items:end;justify-content:space-between;gap:4px;padding:20px 0}
        .chart-bar{background:linear-gradient(to top,var(--blue),#64b5f6);border-radius:3px 3px 0 0;min-height:20px;flex:1;position:relative;transition:all 0.3s ease}
        .chart-bar:hover{background:linear-gradient(to top,var(--red),#e57373)}
        .chart-bar.high{height:90%}
        .chart-bar.medium{height:65%}
        .chart-bar.low{height:40%}
        .chart-label{font-size:11px;color:var(--muted);text-align:center;margin-top:8px}

        /* distribution chart */
        .distribution-item{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px}
        .distribution-item:last-child{margin-bottom:0}
        .distribution-label{display:flex;align-items:center;gap:12px;font-weight:500}
        .distribution-dot{width:12px;height:12px;border-radius:50%}
        .distribution-bar{flex:1;height:8px;background:#f5f5f5;border-radius:4px;margin:0 16px;position:relative;overflow:hidden}
        .distribution-fill{height:100%;border-radius:4px;transition:width 0.3s ease}

        .dot-terverifikasi{background:var(--green)}
        .fill-terverifikasi{background:var(--green);width:70%}
        
        .dot-pending{background:var(--orange)}
        .fill-pending{background:var(--orange);width:50%}
        
        .dot-tidak-aktif{background:var(--gray)}
        .fill-tidak-aktif{background:var(--gray);width:25%}
        
        .dot-suspended{background:var(--yellow)}
        .fill-suspended{background:var(--yellow);width:15%}

        /* empty chart placeholder */
        .empty-chart{height:200px;display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:14px;border:2px dashed var(--border);border-radius:8px}

        /* responsive */
        @media (max-width:1200px){
            .stats-grid{grid-template-columns:repeat(2,1fr)}
            .charts-grid{grid-template-columns:1fr}
        }
        @media (max-width:768px){
            .sidebar{display:none}
            .content{padding:16px}
            .header{padding:16px}
            .stats-grid{grid-template-columns:1fr}
        }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">
                <div class="logo">U</div>
                <div class="brand-info">
                    <div class="brand-text">UlosTa</div>
                    <div class="brand-sub">Admin Panel</div>
                </div>
            </div>

            <nav class="nav">
                <div class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                            </svg>
                        </div>
                        Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.verifikasi-penjual') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"/>
                            </svg>
                        </div>
                        Verifikasi Penjual
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.semua-penjual') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-1c0-2.66 5.33-4 8-4s8 1.34 8 4v1H4zM12 12c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z"/>
                                <path d="M8 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/>
                                <path d="M12.51 4.05C13.43 5.11 14 6.49 14 8c0 1.51-.57 2.89-1.49 3.95C14.47 11.7 16 10.04 16 8s-1.53-3.7-3.49-3.95z"/>
                            </svg>
                        </div>
                        Semua Penjual
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.penjual-tidak-aktif') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11H7v-2h10v2z"/>
                                <path d="M15 7c0-1.66-1.34-3-3-3S9 5.34 9 7s1.34 3 3 3 3-1.34 3-3zm-3 1c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/>
                                <path d="M18 17v1c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-1c0-1.1 1.79-2 6-2s6 .9 6 2z"/>
                            </svg>
                        </div>
                        Penjual Tidak Aktif
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.laporan') }}" class="nav-link active">
                        <div class="nav-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 3v18h18V3H3zm16 16H5V5h14v14z"/>
                                <path d="M7 7h10v2H7zm0 4h10v2H7zm0 4h7v2H7z"/>
                            </svg>
                        </div>
                        Laporan
                    </a>
                </div>
            </nav>
        </aside>

        <main class="main">
            <div class="header">
                <h1>Dashboard Overview</h1>
                <div class="header-right">
                    <div class="search-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        <input type="text" placeholder="nabil">
                    </div>
                    
                    <div class="user-info">
                        <div class="user-details">
                            <div class="user-name">Admin User</div>
                            <div class="user-email">admin@ulosta.com</div>
                        </div>
                        <div class="user-avatar">AU</div>
                    </div>
                </div>
            </div>

            <div class="content">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">Laporan dan Statistik</h1>
                    <p class="page-desc">Analisis performa bisnis dan data pengguna</p>
                </div>

                <!-- Date Filter Section -->
                <div class="filter-section">
                    <div class="filter-group">
                        <div class="filter-label">Periode:</div>
                        <select class="filter-select">
                            <option>30 Hari Terakhir</option>
                            <option>7 Hari Terakhir</option>
                            <option>3 Bulan Terakhir</option>
                            <option>1 Tahun Terakhir</option>
                        </select>
                        <select class="filter-select">
                            <option>Semua Kategori</option>
                            <option>Ulos Tradisional</option>
                            <option>Ulos Modern</option>
                            <option>Aksesoris</option>
                        </select>
                    </div>
                    <button class="export-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                        </svg>
                        Export PDF
                    </button>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card active">
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"/>
                            </svg>
                        </div>
                        <div class="stat-title">Total Penjual Aktif</div>
                        <div class="stat-number">2</div>
                    </div>
                    <div class="stat-card products">
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7 4V2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v2h3a1 1 0 0 1 0 2h-1v14a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V6H4a1 1 0 0 1 0-2h3zM9 3v1h6V3H9zm0 5v10h6V8H9z"/>
                            </svg>
                        </div>
                        <div class="stat-title">Total Produk</div>
                        <div class="stat-number">413</div>
                    </div>
                    <div class="stat-card transactions">
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"/>
                                <path d="M13 7h-2v6l5.25 3.15.75-1.23L13 12.4z"/>
                            </svg>
                        </div>
                        <div class="stat-title">Total Transaksi</div>
                        <div class="stat-number">671</div>
                    </div>
                    <div class="stat-card verification">
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div class="stat-title">Tingkat Verifikasi</div>
                        <div class="stat-number">25%</div>
                    </div>
                </div>

                <!-- Metrics Grid -->
                <div class="metrics-grid">
                    <!-- Revenue Metrics -->
                    <div class="metric-card">
                        <div class="metric-title">💰 Pendapatan</div>
                        <div class="metric-item">
                            <span class="metric-label">Pendapatan Bulan Ini</span>
                            <div>
                                <span class="metric-value">Rp 45.2 Juta</span>
                                <span class="metric-trend trend-up">+12%</span>
                            </div>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Rata-rata Transaksi</span>
                            <span class="metric-value">Rp 267,000</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Komisi Platform</span>
                            <span class="metric-value">Rp 2.8 Juta</span>
                        </div>
                    </div>

                    <!-- Product Metrics -->
                    <div class="metric-card">
                        <div class="metric-title">📦 Produk</div>
                        <div class="metric-item">
                            <span class="metric-label">Produk Terlaris</span>
                            <span class="metric-value">Ulos Batak Tradisional</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Stok Menipis</span>
                            <div>
                                <span class="metric-value">12 Produk</span>
                                <span class="metric-trend trend-down">Perlu Perhatian</span>
                            </div>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Rating Rata-rata</span>
                            <span class="metric-value">4.7/5.0</span>
                        </div>
                    </div>

                    <!-- User Metrics -->
                    <div class="metric-card">
                        <div class="metric-title">👥 Pengguna</div>
                        <div class="metric-item">
                            <span class="metric-label">Pengguna Baru</span>
                            <div>
                                <span class="metric-value">24 Orang</span>
                                <span class="metric-trend trend-up">+8%</span>
                            </div>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Pengguna Aktif</span>
                            <span class="metric-value">156 Orang</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Tingkat Retensi</span>
                            <span class="metric-value">68%</span>
                        </div>
                    </div>
                </div>

                <!-- Summary Performance -->
                <div class="summary-performance">
                    <div class="summary-header">
                        <h3>Ringkasan Performa Bulanan</h3>
                        <span class="summary-period">Januari - Juni 2025</span>
                    </div>
                    <div class="summary-content">
                        <div class="summary-item">
                            <div class="summary-title">📈 Tren Pendapatan</div>
                            <div class="summary-desc">Mengalami peningkatan konsisten dengan rata-rata growth 8% per bulan</div>
                            <div class="summary-highlight">Tertinggi: Juni (Rp 52.3 Juta)</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-title">📦 Performa Pesanan</div>
                            <div class="summary-desc">Volume pesanan stabil dengan peak di bulan Mei (195 pesanan)</div>
                            <div class="summary-highlight">Rata-rata: 168 pesanan/bulan</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-title">👥 Akuisisi Pengguna</div>
                            <div class="summary-desc">Pertumbuhan pengguna baru mencapai 85% dibanding Januari</div>
                            <div class="summary-highlight">Total baru: 385 pengguna</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Table -->
                <div class="activity-table">
                    <div class="table-header">
                        <h3>Aktivitas Terkini</h3>
                        <button class="view-all-btn">Lihat Semua</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                                <th>Pengguna</th>
                                <th>Status</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>10:30 WIB</td>
                                <td>Transaksi baru</td>
                                <td>Maria Simanjuntak</td>
                                <td><span class="status-badge success">Berhasil</span></td>
                                <td>Rp 450,000</td>
                            </tr>
                            <tr>
                                <td>09:45 WIB</td>
                                <td>Verifikasi penjual</td>
                                <td>Toba Craft Store</td>
                                <td><span class="status-badge pending">Menunggu</span></td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>08:20 WIB</td>
                                <td>Produk baru</td>
                                <td>Ulos Heritage</td>
                                <td><span class="status-badge success">Aktif</span></td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Yesterday</td>
                                <td>Laporan penjualan</td>
                                <td>System</td>
                                <td><span class="status-badge info">Generated</span></td>
                                <td>Rp 2.8 Juta</td>
                            </tr>
                            <tr>
                                <td>Yesterday</td>
                                <td>Pembayaran komisi</td>
                                <td>Batak Traditional</td>
                                <td><span class="status-badge success">Berhasil</span></td>
                                <td>Rp 125,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .filter-label {
            font-weight: 600;
            color: #2d3748;
        }

        .filter-select {
            padding: 8px 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: #2d3748;
            cursor: pointer;
            min-width: 150px;
        }

        .filter-select:focus {
            outline: none;
            border-color: #AE0808;
        }

        .export-btn {
            background: #AE0808;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .export-btn:hover {
            background: #8b0000;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }

        .metric-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .metric-title {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f7fafc;
        }

        .metric-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f7fafc;
        }

        .metric-item:last-child {
            border-bottom: none;
        }

        .metric-label {
            color: #718096;
            font-size: 14px;
        }

        .metric-value {
            font-weight: 600;
            color: #2d3748;
        }

        .metric-trend {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 12px;
            margin-left: 8px;
        }

        .trend-up {
            background: #c6f6d5;
            color: #22543d;
        }

        .trend-down {
            background: #fed7d7;
            color: #742a2a;
        }

        .summary-performance {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }

        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f7fafc;
        }

        .summary-header h3 {
            color: #2d3748;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .summary-period {
            background: #f7fafc;
            color: #718096;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 14px;
            font-weight: 500;
        }

        .summary-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .summary-item {
            padding: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: #fafafa;
        }

        .summary-title {
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .summary-desc {
            color: #718096;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .summary-highlight {
            background: #AE0808;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
        }

        .activity-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 2px solid #f7fafc;
        }

        .table-header h3 {
            color: #2d3748;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .view-all-btn {
            background: none;
            border: 2px solid #AE0808;
            color: #AE0808;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .view-all-btn:hover {
            background: #AE0808;
            color: white;
        }

        .activity-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .activity-table th,
        .activity-table td {
            padding: 16px 24px;
            text-align: left;
            border-bottom: 1px solid #f7fafc;
        }

        .activity-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
        }

        .activity-table td {
            color: #4a5568;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.success {
            background: #c6f6d5;
            color: #22543d;
        }

        .status-badge.pending {
            background: #fefcbf;
            color: #744210;
        }

        .status-badge.info {
            background: #bee3f8;
            color: #2a4365;
        }
    </style>
</body>
</html>