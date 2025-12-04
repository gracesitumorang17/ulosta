<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UlosTa Admin - Laporan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--red:#AE0808;--bg:#f8f9fa;--muted:#6c757d;--card:#fff;--border:#e9ecef;--text:#212529;--green:#28a745;--yellow:#ffc107;--red-light:#dc3545}
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
        .stat-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:20px;text-align:center}
        .stat-value{font-size:32px;font-weight:700;margin-bottom:4px}
        .stat-title{font-size:14px;color:var(--muted);text-transform:uppercase;letter-spacing:0.5px}

        /* charts */
        .chart-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:32px}
        .chart-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:24px}
        .chart-title{font-size:18px;font-weight:600;margin-bottom:16px}
        .chart-item{display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid var(--border)}
        .chart-item:last-child{border-bottom:none}
        .chart-label{display:flex;align-items:center;gap:8px}
        .chart-dot{width:12px;height:12px;border-radius:50%}
        .chart-value{font-weight:600}
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
                
                <hr style="margin: 20px 0; border: none; border-top: 1px solid var(--border);">
                
                <div class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link" style="background: none; border: none; color: #dc3545; width: 100%; text-align: left; cursor: pointer;">
                            <div class="nav-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                                </svg>
                            </div>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <main class="main">
            <div class="header">
                <h1>Laporan Admin</h1>
                <div class="header-right">
                    <div class="search-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        <input type="text" placeholder="Cari...">
                    </div>
                    <div class="user-info">
                        <div class="user-details">
                            <div class="user-name">{{ Auth::user()->name ?? 'Admin User' }}</div>
                            <div class="user-email">{{ Auth::user()->email ?? 'admin@ulosta.com' }}</div>
                        </div>
                        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'AU', 0, 2)) }}</div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="page-header">
                    <h1 class="page-title">Laporan dan Statistik</h1>
                    <p class="page-desc">Monitor data dan statistik platform UlosTa</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value" style="color: var(--green);">2</div>
                        <div class="stat-title">Total Penjual Aktif</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" style="color: #7c3aed;">413</div>
                        <div class="stat-title">Total Produk</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" style="color: var(--green);">671</div>
                        <div class="stat-title">Total Transaksi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" style="color: var(--yellow);">25%</div>
                        <div class="stat-title">Tingkat Verifikasi</div>
                    </div>
                </div>

                <div class="chart-grid">
                    <div class="chart-card">
                        <h3 class="chart-title">Distribusi Status Penjual</h3>
                        <div class="chart-item">
                            <div class="chart-label">
                                <div class="chart-dot" style="background: var(--green);"></div>
                                <span>Terverifikasi</span>
                            </div>
                            <span class="chart-value" style="color: var(--green);">75%</span>
                        </div>
                        <div class="chart-item">
                            <div class="chart-label">
                                <div class="chart-dot" style="background: var(--yellow);"></div>
                                <span>Pending</span>
                            </div>
                            <span class="chart-value" style="color: var(--yellow);">50%</span>
                        </div>
                        <div class="chart-item">
                            <div class="chart-label">
                                <div class="chart-dot" style="background: var(--muted);"></div>
                                <span>Tidak Aktif</span>
                            </div>
                            <span class="chart-value" style="color: var(--muted);">25%</span>
                        </div>
                        <div class="chart-item">
                            <div class="chart-label">
                                <div class="chart-dot" style="background: var(--red-light);"></div>
                                <span>Suspended</span>
                            </div>
                            <span class="chart-value" style="color: var(--red-light);">15%</span>
                        </div>
                    </div>

                    <div class="chart-card">
                        <h3 class="chart-title">Aktivitas Terbaru</h3>
                        <div class="chart-item">
                            <div>
                                <div style="font-weight: 500;">Penjual baru terverifikasi</div>
                                <div style="font-size: 13px; color: var(--muted);">Nabil Azmi berhasil diverifikasi</div>
                                <div style="font-size: 12px; color: var(--muted);">2 jam yang lalu</div>
                            </div>
                            <span style="font-size: 12px; padding: 4px 8px; background: #d4edda; color: #155724; border-radius: 12px;">Berhasil</span>
                        </div>
                        <div class="chart-item">
                            <div>
                                <div style="font-weight: 500;">Produk baru ditambahkan</div>
                                <div style="font-size: 13px; color: var(--muted);">Sarah Ahmad menambahkan 3 produk</div>
                                <div style="font-size: 12px; color: var(--muted);">4 jam yang lalu</div>
                            </div>
                            <span style="font-size: 12px; padding: 4px 8px; background: #cce7ff; color: #004085; border-radius: 12px;">Produk</span>
                        </div>
                        <div class="chart-item">
                            <div>
                                <div style="font-weight: 500;">Permintaan verifikasi</div>
                                <div style="font-size: 13px; color: var(--muted);">Andi Putra mengajukan verifikasi</div>
                                <div style="font-size: 12px; color: var(--muted);">6 jam yang lalu</div>
                            </div>
                            <span style="font-size: 12px; padding: 4px 8px; background: #fff3cd; color: #856404; border-radius: 12px;">Pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
