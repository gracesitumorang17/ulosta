<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UlosTa Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--red:#AE0808;--bg:#f8f9fa;--muted:#6c757d;--card:#fff;--border:#e9ecef;--text:#212529}
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
        
        /* stats grid */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px;margin-bottom:32px}
        .stat-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:24px}
        .stat-title{font-size:14px;color:var(--muted);margin-bottom:8px}
        .stat-number{font-size:28px;font-weight:700;color:var(--text)}

        /* action cards */
        .action-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:32px}
        .action-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:24px}
        .action-title{font-size:16px;font-weight:600;margin-bottom:8px}
        .action-desc{font-size:14px;color:var(--muted);margin-bottom:16px}
        .action-link{color:var(--red);text-decoration:none;font-weight:500;font-size:14px}
        .action-link:hover{text-decoration:underline}

        /* activity section */
        .activity-section{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:24px}
        .section-title{font-size:18px;font-weight:600;margin-bottom:16px}
        .activity-list{space-y:16px}
        .activity-item{display:flex;align-items:center;gap:16px;padding:16px 0;border-bottom:1px solid var(--border)}
        .activity-item:last-child{border-bottom:none}
        .activity-avatar{width:40px;height:40px;border-radius:50%;background:#f8f9fa;display:flex;align-items:center;justify-content:center;color:var(--muted);font-weight:600}
        .activity-info{flex:1}
        .activity-name{font-weight:500;margin-bottom:2px}
        .activity-email{font-size:13px;color:var(--muted);margin-bottom:2px}
        .activity-desc{font-size:12px;color:var(--muted)}

        /* responsive */
        @media (max-width:1200px){
            .stats-grid{grid-template-columns:repeat(2,1fr)}
            .action-grid{grid-template-columns:1fr}
        }
        @media (max-width:768px){
            .sidebar{display:none}
            .content{padding:16px}
            .stats-grid{grid-template-columns:1fr}
            .header{padding:16px}
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
                    <a href="#" class="nav-link active">
                        <div class="nav-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13z"/>
                            </svg>
                        </div>
                        Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('admin.verification.list') }}" class="nav-link">
                        <div class="nav-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"/>
                            </svg>
                        </div>
                        Verifikasi Penjual
                    </a>
                </div>
                
                <hr style="margin: 20px 0; border: none; border-top: 1px solid var(--border);">
                
                <div class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link" style="background: none; border: none; color: var(--red); width: 100%; text-align: left; cursor: pointer;">
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
                <h1>Dashboard Overview</h1>
                <div class="header-right">
                    <div class="search-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.5"/>
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
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-title">Total Penjual</div>
                        <div class="stat-number">{{ $totalSellers ?? 0 }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Menunggu Verifikasi</div>
                        <div class="stat-number">{{ isset($pendingVerifications) ? $pendingVerifications->count() : 0 }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Terverifikasi</div>
                        <div class="stat-number">{{ isset($approvedVerifications) ? $approvedVerifications->count() : 0 }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Ditolak</div>
                        <div class="stat-number">{{ isset($rejectedVerifications) ? $rejectedVerifications->count() : 0 }}</div>
                    </div>
                </div>

                <!-- Action Cards -->
                <div class="action-grid" style="grid-template-columns: 1fr;">
                    <div class="action-card">
                        <div class="action-title">Verifikasi Pending</div>
                        <div class="action-desc">Beberapa akun menunggu verifikasi Anda</div>
                        <a href="{{ route('admin.verification.list') }}" class="action-link">Lihat Detail →</a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="activity-section">
                    <div class="section-title">Aktivitas Verifikasi Terbaru</div>
                    <div class="activity-list">
                        @forelse($recentVerifications ?? [] as $verification)
                            <div class="activity-item">
                                <div class="activity-avatar">
                                    {{ strtoupper(substr($verification->name ?? 'N', 0, 1)) }}
                                </div>
                                <div class="activity-info">
                                    <div class="activity-name">{{ $verification->name ?? 'Unknown' }}</div>
                                    <div class="activity-email">{{ $verification->email ?? 'No email' }}</div>
                                    <div class="activity-desc">
                                        @if($verification->verification_status === 'pending')
                                            Menunggu verifikasi - disubmit {{ $verification->verification_submitted_at ? $verification->verification_submitted_at->diffForHumans() : 'baru-baru ini' }}
                                        @elseif($verification->verification_status === 'approved')
                                            Verifikasi disetujui {{ $verification->verification_approved_at ? $verification->verification_approved_at->diffForHumans() : 'baru-baru ini' }}
                                        @elseif($verification->verification_status === 'rejected')
                                            Verifikasi ditolak {{ $verification->verification_rejected_at ? $verification->verification_rejected_at->diffForHumans() : 'baru-baru ini' }}
                                        @else
                                            Status verifikasi: {{ $verification->verification_status }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 40px; color: var(--muted);">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="margin-bottom: 16px; opacity: 0.5;">
                                    <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"/>
                                </svg>
                                <div>Belum ada aktivitas verifikasi terbaru</div>
                                <div style="font-size: 14px; margin-top: 8px;">Aktivitas akan muncul ketika ada seller yang mengajukan verifikasi</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>