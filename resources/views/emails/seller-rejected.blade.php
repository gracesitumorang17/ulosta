<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Verifikasi Seller</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .email-container {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #AE0808;
        }
        .logo {
            background: #AE0808;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .warning-icon {
            background: #f8d7da;
            color: #721c24;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 20px 0;
        }
        h1 {
            color: #AE0808;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #666;
        }
        .message {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #AE0808;
        }
        .reason-box {
            background: #f8d7da;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #dc3545;
        }
        .reason-box h3 {
            color: #721c24;
            margin-top: 0;
        }
        .requirements {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .requirements h3 {
            color: #0d47a1;
            margin-top: 0;
        }
        .btn {
            display: inline-block;
            background: #AE0808;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #888;
            font-size: 14px;
        }
        .divider {
            height: 1px;
            background: #eee;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">U</div>
            <h2 style="margin: 0; color: #AE0808;">UlosTa</h2>
        </div>

        <!-- Warning Icon -->
        <div style="text-align: center;">
            <div class="warning-icon">
                !
            </div>
        </div>

        <!-- Main Content -->
        <h1>Pemberitahuan Verifikasi Seller</h1>
        
        <p class="greeting">Halo <strong>{{ $user->name }}</strong>,</p>
        
        <div class="message">
            <p>Terima kasih telah mengajukan verifikasi seller di UlosTa. Setelah meninjau dokumen yang Anda kirimkan, 
            kami perlu memberikan pemberitahuan terkait status verifikasi Anda.</p>
        </div>

        @if($reason)
        <!-- Rejection Reason -->
        <div class="reason-box">
            <h3>Alasan Penolakan:</h3>
            <p style="margin: 0; color: #721c24;">{{ $reason }}</p>
        </div>
        @endif

        <!-- Requirements -->
        <div class="requirements">
            <h3>Persyaratan Dokumen Verifikasi:</h3>
            <ul style="color: #0d47a1; margin: 0;">
                <li><strong>Foto KTP:</strong> Harus jelas, tidak buram, dan dapat dibaca dengan mudah</li>
                <li><strong>Foto Selfie dengan KTP:</strong> Wajah terlihat jelas dan sesuai dengan KTP</li>
                <li><strong>Informasi Toko:</strong> Nama toko dan alamat harus lengkap dan valid</li>
                <li><strong>Informasi Bank:</strong> Data rekening harus akurat dan sesuai dengan nama pemilik</li>
                <li><strong>Validitas Data:</strong> Semua informasi harus benar dan dapat diverifikasi</li>
            </ul>
        </div>

        <!-- Store Information -->
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0;">Informasi Akun Anda:</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 5px 0; font-weight: 600;">Nama:</td>
                    <td style="padding: 5px 0;">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0; font-weight: 600;">Email:</td>
                    <td style="padding: 5px 0;">{{ $user->email }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0; font-weight: 600;">Status:</td>
                    <td style="padding: 5px 0; color: #dc3545; font-weight: 600;">Memerlukan Review Ulang</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0; font-weight: 600;">Tanggal Review:</td>
                    <td style="padding: 5px 0;">{{ now()->format('d F Y, H:i') }} WIB</td>
                </tr>
            </table>
        </div>

        <!-- Action Button -->
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/seller/verification') }}" class="btn">
                Submit Ulang Dokumen
            </a>
        </div>

        <!-- Next Steps -->
        <div class="message" style="background: #fff3cd; border-color: #ffc107;">
            <h3 style="color: #856404; margin-top: 0;">Langkah Selanjutnya:</h3>
            <ul style="color: #856404; margin: 0;">
                <li>Periksa kembali semua dokumen sesuai persyaratan di atas</li>
                <li>Pastikan foto KTP dan selfie berkualitas baik dan jelas</li>
                <li>Lengkapi semua informasi dengan data yang valid</li>
                <li>Submit ulang dokumen melalui halaman verifikasi</li>
            </ul>
        </div>

        <div class="divider"></div>

        <p style="color: #666;">
            Jika Anda memiliki pertanyaan atau memerlukan bantuan lebih lanjut, silakan hubungi tim support kami. 
            Kami siap membantu Anda menyelesaikan proses verifikasi.
        </p>

        <p style="color: #666;">
            Terima kasih atas pengertian Anda.<br>
            <strong>Tim UlosTa</strong>
        </p>

        <!-- Footer -->
        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon jangan membalas email ini.</p>
            <p>&copy; {{ date('Y') }} UlosTa. Semua hak cipta dilindungi.</p>
            <p>Platform jual beli ulos terpercaya</p>
        </div>
    </div>
</body>
</html>