<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Seller Disetujui</title>
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
        .success-icon {
            background: #d4edda;
            color: #155724;
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
        .store-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .store-info h3 {
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

        <!-- Success Icon -->
        <div style="text-align: center;">
            <div class="success-icon">
                ✓
            </div>
        </div>

        <!-- Main Content -->
        <h1>Selamat! Verifikasi Seller Anda Telah Disetujui</h1>
        
        <p class="greeting">Halo <strong>{{ $user->name }}</strong>,</p>
        
        <div class="message">
            <p>Kabar gembira! Tim UlosTa telah meninjau dan <strong>menyetujui</strong> verifikasi seller Anda. 
            Akun Anda kini sudah aktif dan Anda dapat mulai berjualan di platform UlosTa.</p>
        </div>

        <!-- Store Information -->
        <div class="store-info">
            <h3>Informasi Toko Anda:</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 5px 0; font-weight: 600;">Nama Toko:</td>
                    <td style="padding: 5px 0;">{{ $user->store_name }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0; font-weight: 600;">Email:</td>
                    <td style="padding: 5px 0;">{{ $user->email }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0; font-weight: 600;">Status:</td>
                    <td style="padding: 5px 0; color: #28a745; font-weight: 600;">✓ TERVERIFIKASI</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0; font-weight: 600;">Tanggal Approve:</td>
                    <td style="padding: 5px 0;">{{ now()->format('d F Y, H:i') }} WIB</td>
                </tr>
            </table>
        </div>

        <!-- Action Button -->
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/seller/dashboard') }}" class="btn">
                Masuk ke Dashboard Seller
            </a>
        </div>

        <!-- Next Steps -->
        <div class="message" style="background: #fff3cd; border-color: #ffc107;">
            <h3 style="color: #856404; margin-top: 0;">Langkah Selanjutnya:</h3>
            <ul style="color: #856404; margin: 0;">
                <li>Login ke dashboard seller Anda</li>
                <li>Lengkapi profil toko dan upload foto produk ulos</li>
                <li>Atur metode pengiriman dan pembayaran</li>
                <li>Mulai menjual produk ulos terbaik Anda!</li>
            </ul>
        </div>

        <div class="divider"></div>

        <p style="color: #666;">
            Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi tim support kami.
        </p>

        <p style="color: #666;">
            Terima kasih telah bergabung dengan UlosTa!<br>
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