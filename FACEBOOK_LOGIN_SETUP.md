# Quick Start: Facebook Login API

## 1. Setup Facebook App

### Buat Facebook App:
1. Buka https://developers.facebook.com/
2. Klik **My Apps** → **Create App**
3. Pilih **Consumer** type
4. Isi nama app dan email

### Konfigurasi OAuth:
1. Pilih **Facebook Login** → **Settings**
2. Tambahkan di **Valid OAuth Redirect URIs**:
   ```
   http://127.0.0.1:8000/auth/facebook/callback
   http://127.0.0.1:8000/api/auth/facebook/callback
   ```
3. Save

## 2. Update .env

Buka `.env` dan ganti:
```env
FACEBOOK_CLIENT_ID=your_app_id_here
FACEBOOK_CLIENT_SECRET=your_app_secret_here
FACEBOOK_REDIRECT_URI=http://127.0.0.1:8000/auth/facebook/callback
```

## 3. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
```

## 4. Test

### Web (Browser):
```
http://127.0.0.1:8000/auth/facebook
```

### API (Get Redirect URL):
```
GET http://127.0.0.1:8000/api/auth/facebook/redirect
```

## Endpoints

| Type | Endpoint | Description |
|------|----------|-------------|
| WEB | `/auth/facebook` | Redirect ke Facebook login |
| WEB | `/auth/facebook/callback` | Callback dari Facebook |
| API | `/api/auth/facebook/redirect` | Get redirect URL (JSON) |
| API | `/api/auth/facebook/callback` | Get token (JSON) |

## Response API

```json
{
    "success": true,
    "message": "Login dengan Facebook berhasil",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "buyer",
        "avatar": "https://graph.facebook.com/..."
    },
    "token": "1|abc123..."
}
```

## Documentation

Lihat dokumentasi lengkap di: `docs/FACEBOOK_AUTH_API.md`

## Features

✅ Login dengan Facebook  
✅ Register otomatis jika user baru  
✅ Link Facebook ke akun existing  
✅ Email auto-verified  
✅ API token untuk mobile/SPA  
✅ Foto profil dari Facebook  

## Support

- Laravel Socialite: https://laravel.com/docs/socialite
- Facebook Login: https://developers.facebook.com/docs/facebook-login
