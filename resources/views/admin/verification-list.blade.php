<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Verifikasi Seller - Admin</title>
    <style>
        :root {
            --red: #AE0808;
            --bg: #f8f9fa;
            --muted: #6c757d;
            --card: #fff;
            --border: #e9ecef;
            --text: #212529;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
        }
        
        .header {
            background: linear-gradient(135deg, var(--red) 0%, #8B0000 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h2 {
            margin: 0;
            font-size: 1.8rem;
        }
        
        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--card);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(174, 8, 8, 0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--red);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--muted);
            font-size: 0.9rem;
        }
        
        .verification-table {
            background: var(--card);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(174, 8, 8, 0.1);
            overflow: hidden;
        }
        
        .table-header {
            background: var(--red);
            color: white;
            padding: 1.5rem;
        }
        
        .table-header h3 {
            margin: 0;
            font-size: 1.3rem;
        }
        
        .table-content {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: var(--text);
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .status-verified {
            background: #d1edff;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--red);
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 0.75rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .btn-review {
            background: var(--red);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-review:hover {
            background: #8B0000;
            color: white;
        }
        
        .btn-view {
            background: var(--muted);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--muted);
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div>
                    <h2><i class="fas fa-users-cog me-2"></i>Verifikasi Seller</h2>
                    <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Kelola verifikasi akun penjual</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $users->where('verification_status', 'pending')->count() }}</div>
                <div class="stat-label">Pending Review</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $users->where('verification_status', 'approved')->count() }}</div>
                <div class="stat-label">Terverifikasi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $users->where('verification_status', 'rejected')->count() }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $users->count() }}</div>
                <div class="stat-label">Total Seller</div>
            </div>
        </div>

        <!-- Verification Table -->
        <div class="verification-table">
            <div class="table-header">
                <h3><i class="fas fa-clipboard-list me-2"></i>Daftar Verifikasi Seller</h3>
            </div>
            <div class="table-content">
                @if($users->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Seller</th>
                            <th>Nama Toko</th>
                            <th>Tanggal Submit</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $user->name }}</strong><br>
                                        <small style="color: var(--muted);">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->store_name)
                                    <strong>{{ $user->store_name }}</strong>
                                    @if($user->store_address)
                                        <br><small style="color: var(--muted);">{{ Str::limit($user->store_address, 50) }}</small>
                                    @endif
                                @else
                                    <span style="color: var(--muted);">Belum diset</span>
                                @endif
                            </td>
                            <td>
                                @if($user->verification_submitted_at)
                                    {{ $user->verification_submitted_at->format('d/m/Y H:i') }}<br>
                                    <small style="color: var(--muted);">{{ $user->verification_submitted_at->diffForHumans() }}</small>
                                @else
                                    <span style="color: var(--muted);">-</span>
                                @endif
                            </td>
                            <td>
                                @switch($user->verification_status)
                                    @case('pending')
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock"></i>Pending Review
                                        </span>
                                        @break
                                    @case('approved')
                                        <span class="status-badge status-verified">
                                            <i class="fas fa-check-circle"></i>Terverifikasi
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="status-badge status-rejected">
                                            <i class="fas fa-times-circle"></i>Ditolak
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if($user->verification_status === 'pending')
                                    <a href="{{ route('admin.verification.detail', $user->id) }}" class="btn-review">
                                        <i class="fas fa-eye me-1"></i>Review
                                    </a>
                                @else
                                    <a href="{{ route('admin.verification.detail', $user->id) }}" class="btn-view">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h4>Belum Ada Verifikasi Seller</h4>
                    <p>Belum ada seller yang mengajukan verifikasi.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>