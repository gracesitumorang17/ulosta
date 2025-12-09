<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sedang Diproses - UlosTa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --red: #AE0808;
            --bg: #f8f9fa;
            --card: #fff;
            --border: #e9ecef;
            --text: #212529;
            --muted: #6c757d;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .header {
            background: var(--card);
            border-bottom: 1px solid var(--border);
            padding: 1rem 0;
        }

        .logo {
            background: var(--red);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            text-decoration: none;
        }

        .verification-container {
            max-width: 600px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .verification-card {
            background: var(--card);
            border-radius: 20px;
            padding: 3rem 2rem;
            box-shadow: 0 4px 20px rgba(174, 8, 8, 0.1);
            text-align: center;
            border: 1px solid var(--border);
        }

        .status-icon {
            width: 80px;
            height: 80px;
            background: #fff3cd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 3px solid #ffeaa7;
        }

        .status-icon i {
            font-size: 2.5rem;
            color: #856404;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .status-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 1rem;
        }

        .status-message {
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .info-cards {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
            border-left: 4px solid var(--red);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--text);
        }

        .info-value {
            color: var(--muted);
            font-weight: 500;
        }

        .status-badge {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .requirements-list {
            background: #e3f2fd;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: left;
        }

        .requirements-list h6 {
            color: #0d47a1;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .requirements-list ul {
            margin: 0;
            padding-left: 1.5rem;
            color: #1565c0;
        }

        .requirements-list li {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .action-buttons {
            margin-top: 2rem;
        }

        .btn-refresh {
            background: var(--card);
            color: var(--text);
            border: 2px solid var(--border);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            margin-right: 1rem;
            transition: all 0.3s;
        }

        .btn-refresh:hover {
            background: var(--bg);
            color: var(--text);
            border-color: var(--red);
        }

        .btn-home {
            background: var(--red);
            color: white;
            border: 2px solid var(--red);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-home:hover {
            background: #8B0000;
            border-color: #8B0000;
            color: white;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--muted);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('welcome') }}" class="logo">U</a>
                    <span class="fw-bold">UlosTa</span>
                </div>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" class="text-decoration-none text-muted ms-2" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="verification-container">
        <div class="verification-card">
            <!-- Status Icon -->
            <div class="status-icon">
                <i class="fas fa-clock"></i>
            </div>

            <!-- Status Title -->
            <h1 class="status-title">Verifikasi Sedang Diproses</h1>
            
            <!-- Status Message -->
            <p class="status-message">
                Terima kasih! Dokumen verifikasi Anda telah berhasil dikirim. Tim kami akan 
                meninjau dokumen dalam <strong>1-3 hari kerja</strong>.
            </p>

            <!-- Info Cards -->
            <div class="info-cards">
                <div class="info-row">
                    <span class="info-label">Status Verifikasi</span>
                    <span class="status-badge">
                        <i class="fas fa-clock me-1"></i>Pending Review
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Submit</span>
                    <span class="info-value">
                        @if(Auth::user()->verification_submitted_at)
                            {{ Auth::user()->verification_submitted_at->format('d/m/Y H:i') }}
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nama Toko</span>
                    <span class="info-value">
                        {{ Auth::user()->store_name ?? 'Daniel Situmorang Store' }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Estimasi Review</span>
                    <span class="info-value">1-3 Hari Kerja</span>
                </div>
            </div>

            <!-- Requirements List -->
            <div class="requirements-list">
                <h6>
                    <i class="fas fa-info-circle"></i>
                    Yang Akan Kami Periksa:
                </h6>
                <ul>
                    <li>Keaslian dokumen KTP</li>
                    <li>Kesesuaian foto selfie dengan KTP</li>
                    <li>Kelengkapan informasi toko dan bank</li>
                    <li>Validitas data yang diberikan</li>
                </ul>
            </div>

            <p class="text-muted small">
                Kami akan mengirimkan email pemberitahuan setelah proses review selesai.
            </p>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="btn-refresh" onclick="refreshStatus()">
                    <i class="fas fa-sync-alt me-1"></i>Refresh Status
                </button>
                <a href="{{ route('welcome') }}" class="btn-home">
                    <i class="fas fa-home me-1"></i>Kembali ke Homepage
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function refreshStatus() {
            // Check verification status via AJAX
            fetch('{{ route("seller.verification.status") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'approved') {
                        alert('Selamat! Verifikasi Anda telah disetujui. Halaman akan dimuat ulang.');
                        window.location.reload();
                    } else if (data.status === 'rejected') {
                        alert('Verifikasi Anda ditolak. Silakan submit ulang dokumen.');
                        window.location.href = '{{ route("seller.verification") }}';
                    } else {
                        alert('Status masih pending. Silakan tunggu proses review selesai.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memeriksa status.');
                });
        }

        // Auto refresh status setiap 30 detik
        setInterval(function() {
            fetch('{{ route("seller.verification.status") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'approved') {
                        alert('Selamat! Verifikasi Anda telah disetujui.');
                        window.location.href = '{{ route("seller.dashboard") }}';
                    } else if (data.status === 'rejected') {
                        window.location.href = '{{ route("seller.verification") }}';
                    }
                })
                .catch(error => console.error('Auto refresh error:', error));
        }, 30000); // 30 seconds
    </script>
</body>
</html>