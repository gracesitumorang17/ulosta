# Facebook Authentication API Documentation

## Overview
API untuk login dan register menggunakan Facebook OAuth.

## Base URL
```
http://127.0.0.1:8000
```

## Setup Facebook App

### 1. Buat Facebook App
1. Buka [Facebook Developers](https://developers.facebook.com/)
2. Klik "My Apps" → "Create App"
3. Pilih "Consumer" sebagai app type
4. Isi nama aplikasi dan email kontak
5. Setelah app dibuat, pergi ke "Settings" → "Basic"
6. Copy **App ID** dan **App Secret**

### 2. Konfigurasi OAuth Settings
1. Di dashboard Facebook App, pilih "Facebook Login" → "Settings"
2. Di **Valid OAuth Redirect URIs**, tambahkan:
   - `http://127.0.0.1:8000/auth/facebook/callback`
   - `http://127.0.0.1:8000/api/auth/facebook/callback`
3. Klik "Save Changes"

### 3. Update Environment Variables
Buka file `.env` dan update:
```env
FACEBOOK_CLIENT_ID=your_facebook_app_id
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret
FACEBOOK_REDIRECT_URI=http://127.0.0.1:8000/auth/facebook/callback
```

### 4. Clear Config Cache
```bash
php artisan config:clear
php artisan cache:clear
```

---

## Web Routes (For Browser)

### 1. Redirect to Facebook Login
**Endpoint:** `GET /auth/facebook`

**Description:** Redirect user ke halaman login Facebook

**Example:**
```html
<a href="{{ route('auth.facebook') }}" class="btn btn-facebook">
    Login dengan Facebook
</a>
```

### 2. Facebook Callback
**Endpoint:** `GET /auth/facebook/callback`

**Description:** Handle callback dari Facebook setelah user login

**Response:** Redirect ke halaman home dengan user sudah login

---

## API Routes (For Mobile/SPA)

### 1. Get Facebook Redirect URL
**Endpoint:** `GET /api/auth/facebook/redirect`

**Description:** Mendapatkan URL redirect Facebook untuk digunakan di aplikasi mobile/SPA

**Response:**
```json
{
    "success": true,
    "redirect_url": "https://www.facebook.com/v18.0/dialog/oauth?client_id=..."
}
```

**Example Usage:**
```javascript
// Step 1: Get redirect URL
fetch('/api/auth/facebook/redirect')
    .then(res => res.json())
    .then(data => {
        // Step 2: Open URL in browser/webview
        window.location.href = data.redirect_url;
    });
```

### 2. Facebook Callback (API)
**Endpoint:** `GET /api/auth/facebook/callback`

**Description:** Handle callback dari Facebook dan return authentication token

**Query Parameters:**
- `code`: Authorization code dari Facebook (otomatis dari Facebook)
- `state`: State parameter untuk CSRF protection (otomatis dari Facebook)

**Response Success:**
```json
{
    "success": true,
    "message": "Login dengan Facebook berhasil",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "buyer",
        "avatar": "https://graph.facebook.com/123456789/picture"
    },
    "token": "1|abc123xyz..."
}
```

**Response Error:**
```json
{
    "success": false,
    "message": "Gagal login dengan Facebook",
    "error": "Error details here"
}
```

**Example Usage:**
```javascript
// After Facebook redirects back to your app
const urlParams = new URLSearchParams(window.location.search);
const code = urlParams.get('code');

if (code) {
    fetch(`/api/auth/facebook/callback?code=${code}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Save token
                localStorage.setItem('auth_token', data.token);
                localStorage.setItem('user', JSON.stringify(data.user));
                
                // Redirect to dashboard
                window.location.href = '/dashboard';
            }
        });
}
```

---

## Integration Examples

### Laravel Blade (Web)
```html
<!-- resources/views/masuk.blade.php -->
<div class="social-login">
    <a href="{{ route('auth.google') }}" class="btn btn-google">
        <img src="/icons/google.svg" alt="Google">
        Login dengan Google
    </a>
    
    <a href="{{ route('auth.facebook') }}" class="btn btn-facebook">
        <img src="/icons/facebook.svg" alt="Facebook">
        Login dengan Facebook
    </a>
</div>
```

### React/Vue (SPA)
```javascript
// Facebook Login Button Component
const FacebookLoginButton = () => {
    const handleFacebookLogin = async () => {
        try {
            // Get redirect URL
            const response = await fetch('/api/auth/facebook/redirect');
            const data = await response.json();
            
            // Redirect to Facebook
            window.location.href = data.redirect_url;
        } catch (error) {
            console.error('Facebook login failed:', error);
        }
    };

    return (
        <button onClick={handleFacebookLogin}>
            Login dengan Facebook
        </button>
    );
};

// Handle callback in your app
useEffect(() => {
    const urlParams = new URLSearchParams(window.location.search);
    const code = urlParams.get('code');
    
    if (code) {
        handleFacebookCallback(code);
    }
}, []);

const handleFacebookCallback = async (code) => {
    try {
        const response = await fetch(`/api/auth/facebook/callback${window.location.search}`);
        const data = await response.json();
        
        if (data.success) {
            // Store token
            localStorage.setItem('token', data.token);
            setUser(data.user);
            navigate('/dashboard');
        }
    } catch (error) {
        console.error('Callback failed:', error);
    }
};
```

### React Native
```javascript
import { Linking } from 'react-native';
import * as WebBrowser from 'expo-web-browser';

const facebookLogin = async () => {
    try {
        // Get redirect URL
        const response = await fetch('http://127.0.0.1:8000/api/auth/facebook/redirect');
        const data = await response.json();
        
        // Open browser
        const result = await WebBrowser.openAuthSessionAsync(
            data.redirect_url,
            'http://127.0.0.1:8000/api/auth/facebook/callback'
        );
        
        if (result.type === 'success') {
            // Extract code from URL
            const url = new URL(result.url);
            const code = url.searchParams.get('code');
            
            // Get token
            const tokenResponse = await fetch(`http://127.0.0.1:8000/api/auth/facebook/callback?code=${code}`);
            const tokenData = await tokenResponse.json();
            
            if (tokenData.success) {
                // Save token
                await AsyncStorage.setItem('token', tokenData.token);
                setUser(tokenData.user);
            }
        }
    } catch (error) {
        console.error('Facebook login error:', error);
    }
};
```

---

## Database Schema

Tabel `users` memiliki kolom berikut untuk Facebook authentication:

```sql
- facebook_id (string, nullable, unique): Facebook User ID
- facebook_token (text, nullable): Facebook access token
- avatar (string, nullable): URL foto profil dari Facebook
- provider (string, nullable): OAuth provider name ('facebook')
- provider_id (string, nullable): Generic provider ID
- email_verified_at (timestamp, nullable): Otomatis diset saat login via Facebook
```

---

## Security Features

1. **Auto Email Verification**: Email otomatis terverifikasi saat login via Facebook
2. **Account Linking**: Jika email sudah terdaftar, akun Facebook akan di-link ke akun existing
3. **Random Password**: User yang register via Facebook mendapat random password
4. **Token-based Auth**: API menggunakan Laravel Sanctum untuk token authentication
5. **CSRF Protection**: State parameter untuk mencegah CSRF attacks

---

## Error Handling

### Common Errors:

1. **Invalid Credentials**
   - Pastikan FACEBOOK_CLIENT_ID dan FACEBOOK_CLIENT_SECRET benar
   - Cek di Facebook Developer Console

2. **Invalid Redirect URI**
   - Pastikan redirect URI di .env sama dengan yang di Facebook App Settings
   - Format: `http://127.0.0.1:8000/auth/facebook/callback`

3. **App Not in Development Mode**
   - App Facebook harus dalam mode Development untuk testing
   - Atau tambahkan test users di Facebook App Settings

4. **Email Not Provided**
   - Facebook tidak selalu mengirim email
   - Pastikan scope email sudah di-request

---

## Testing

### Test Flow (Browser):
1. Buka `http://127.0.0.1:8000/auth/facebook`
2. Login dengan akun Facebook
3. Izinkan aplikasi mengakses data
4. Redirect ke home page dengan status logged in

### Test Flow (API):
1. Request `GET /api/auth/facebook/redirect`
2. Dapatkan redirect URL
3. Buka URL di browser
4. Setelah authorize, Facebook redirect ke callback URL
5. Parse token dari response
6. Gunakan token untuk authenticated requests

---

## Additional Notes

- User yang login via Facebook akan memiliki role 'buyer' secara default
- Foto profil disimpan sebagai URL (tidak di-download ke server)
- Token Facebook disimpan untuk future API calls jika diperlukan
- Jika user sudah pernah login dengan cara lain, akun Facebook akan di-link ke akun existing

---

## Support

Untuk bantuan lebih lanjut:
- Facebook OAuth Docs: https://developers.facebook.com/docs/facebook-login
- Laravel Socialite Docs: https://laravel.com/docs/socialite
