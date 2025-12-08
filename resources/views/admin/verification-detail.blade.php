<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Verifikasi - {{ $user->name }}</title>
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
        
        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
        }
        
        .main-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .card {
            background: var(--card);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(174, 8, 8, 0.1);
            overflow: hidden;
        }
        
        .card-header {
            background: var(--red);
            color: white;
            padding: 1.5rem;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .status-card {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .status-badge {
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 2px solid #ffeaa7;
        }
        
        .status-verified {
            background: #d1edff;
            color: #0c5460;
            border: 2px solid #bee5eb;
        }
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
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
            text-align: right;
            max-width: 60%;
        }
        
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .document-card {
            background: var(--card);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(174, 8, 8, 0.1);
            text-align: center;
        }
        
        .document-preview {
            width: 100%;
            max-width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .document-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text);
        }
        
        .btn-view-doc {
            background: var(--muted);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .action-buttons {
            position: sticky;
            bottom: 0;
            background: var(--card);
            padding: 2rem;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 -4px 20px rgba(174, 8, 8, 0.1);
            margin-top: 2rem;
        }
        
        .buttons-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1rem;
            align-items: end;
        }
        
        .reject-form {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1rem;
            align-items: end;
        }
        
        .form-group {
            margin: 0;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text);
        }
        
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border);
            border-radius: 8px;
            resize: vertical;
            font-family: inherit;
        }
        
        .btn-reject {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            height: fit-content;
        }
        
        .btn-approve {
            background: #28a745;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 1.1rem;
            width: 100%;
            justify-self: end;
        }
        
        .btn-approve:hover {
            background: #218838;
        }
        
        .btn-reject:hover {
            background: #c82333;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
        }
        
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 800px;
            max-height: 80%;
            border-radius: 10px;
        }
        
        .modal-close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            
            .buttons-grid {
                grid-template-columns: 1fr;
            }
            
            .reject-form {
                grid-template-columns: 1fr;
            }
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
                    <h2><i class="fas fa-user-check me-2"></i>Review Verifikasi Seller</h2>
                    <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">{{ $user->name }} - {{ $user->email }}</p>
                </div>
                <a href="{{ route('admin.verification.list') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="main-content">
            <!-- Status & Info -->
            <div>
                <!-- Status Card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-2"></i>Status Verifikasi
                    </div>
                    <div class="card-body">
                        <div class="status-card">
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
                        </div>

                        <div class="info-row">
                            <span class="info-label">Submit:</span>
                            <span class="info-value">
                                @if($user->verification_submitted_at)
                                    {{ $user->verification_submitted_at->format('d/m/Y H:i') }}<br>
                                    <small>{{ $user->verification_submitted_at->diffForHumans() }}</small>
                                @else
                                    -
                                @endif
                            </span>
                        </div>

                        @if($user->verification_approved_at)
                        <div class="info-row">
                            <span class="info-label">Disetujui:</span>
                            <span class="info-value" style="color: #28a745;">
                                {{ $user->verification_approved_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        @endif

                        @if($user->verification_rejected_at)
                        <div class="info-row">
                            <span class="info-label">Ditolak:</span>
                            <span class="info-value" style="color: #dc3545;">
                                {{ $user->verification_rejected_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        @endif

                        @if($user->rejection_reason)
                        <div class="info-row">
                            <span class="info-label">Alasan Penolakan:</span>
                            <span class="info-value" style="color: #dc3545;">
                                {{ $user->rejection_reason }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Data Detail -->
            <div>
                <!-- Data Pribadi -->
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <i class="fas fa-user me-2"></i>Data Pribadi
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-label">Nama Lengkap</span>
                            <span class="info-value">{{ $user->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $user->email }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Nomor KTP</span>
                            <span class="info-value">{{ $user->ktp_number ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Nomor Telepon</span>
                            <span class="info-value">{{ $user->phone_number ?? $user->phone ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Data Toko & Bank -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-store me-2"></i>Data Toko & Bank
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-label">Nama Toko</span>
                            <span class="info-value">{{ $user->store_name ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Alamat Toko</span>
                            <span class="info-value">{{ $user->store_address ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Bank</span>
                            <span class="info-value">{{ $user->bank_name ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">No. Rekening</span>
                            <span class="info-value">{{ $user->bank_account_number ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Nama Pemilik</span>
                            <span class="info-value">{{ $user->bank_account_name ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-images me-2"></i>Dokumen Verifikasi
            </div>
            <div class="card-body">
                <div class="documents-grid">
                    @if($user->ktp_photo_path)
                    <div class="document-card">
                        <h6 class="document-title"><i class="fas fa-id-card me-1"></i>Foto KTP</h6>
                        <img src="{{ route('admin.verification.document', ['user' => $user->id, 'type' => 'ktp']) }}" 
                             alt="Foto KTP" class="document-preview" onclick="openModal(this.src, 'Foto KTP')">
                        <div>
                            <a href="{{ route('admin.verification.document', ['user' => $user->id, 'type' => 'ktp']) }}" 
                               target="_blank" class="btn-view-doc">
                                <i class="fas fa-external-link-alt me-1"></i>Buka
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($user->selfie_with_ktp_path)
                    <div class="document-card">
                        <h6 class="document-title"><i class="fas fa-camera me-1"></i>Selfie dengan KTP</h6>
                        <img src="{{ route('admin.verification.document', ['user' => $user->id, 'type' => 'selfie']) }}" 
                             alt="Selfie KTP" class="document-preview" onclick="openModal(this.src, 'Selfie dengan KTP')">
                        <div>
                            <a href="{{ route('admin.verification.document', ['user' => $user->id, 'type' => 'selfie']) }}" 
                               target="_blank" class="btn-view-doc">
                                <i class="fas fa-external-link-alt me-1"></i>Buka
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($user->store_photo_path)
                    <div class="document-card">
                        <h6 class="document-title"><i class="fas fa-store me-1"></i>Foto Toko</h6>
                        <img src="{{ route('admin.verification.document', ['user' => $user->id, 'type' => 'store']) }}" 
                             alt="Foto Toko" class="document-preview" onclick="openModal(this.src, 'Foto Toko')">
                        <div>
                            <a href="{{ route('admin.verification.document', ['user' => $user->id, 'type' => 'store']) }}" 
                               target="_blank" class="btn-view-doc">
                                <i class="fas fa-external-link-alt me-1"></i>Buka
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if($user->verification_status === 'pending')
    <div class="action-buttons">
        <div class="container">
            <div class="buttons-grid">
                <!-- Reject Form -->
                <form action="{{ route('admin.verification.reject', $user->id) }}" method="POST" class="reject-form">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Alasan Penolakan (Opsional)</label>
                        <textarea name="rejection_reason" rows="3" 
                                  placeholder="Berikan alasan jika verifikasi ditolak..."></textarea>
                    </div>
                    <button type="submit" class="btn-reject" 
                            onclick="return confirm('Yakin tolak verifikasi seller ini?')">
                        <i class="fas fa-times-circle me-1"></i>Tolak
                    </button>
                </form>

                <!-- Approve Button -->
                <form action="{{ route('admin.verification.approve', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-approve" 
                            onclick="return confirm('Yakin setujui verifikasi seller ini?')">
                        <i class="fas fa-check-circle me-1"></i>Setujui Verifikasi
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Image Modal -->
    <div id="imageModal" class="modal">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        function openModal(src, title) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.style.display = 'block';
            modalImg.src = src;
            modalImg.alt = title;
        }

        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('imageModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>