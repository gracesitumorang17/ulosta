# 🔧 TROUBLESHOOTING - 404 Not Found

## ❌ Error yang Anda Alami

```
404 Not Found
nginx/1.22.0
```

---

## ✅ SOLUSI LENGKAP

### **Masalah: Base URL Salah**

Anda menggunakan URL yang salah di Postman. Mari kita perbaiki:

---

## 🎯 Langkah Perbaikan

### **Langkah 1: Cek Server Laravel**

Buka terminal dan pastikan server Laravel running:

```powershell
php artisan serve
```

**Output yang benar:**
```
Server running on [http://127.0.0.1:8000]
```

**CATAT PORT-nya: 8000** ← Ini penting!

---

### **Langkah 2: Update Environment di Postman**

1. **Klik icon Environment** (⚙️) di pojok kanan atas Postman
2. **Pilih environment "Ulosta Local"** (atau yang sedang aktif)
3. **Edit variable `base_url`:**

   **❌ SALAH (yang mungkin Anda pakai):**
   ```
   http://localhost/api/v1
   ```

   **✅ BENAR (gunakan ini):**
   ```
   http://localhost:8000/api/v1
   ```

4. **Save** environment

---

### **Langkah 3: Test URL Langsung**

Sebelum test di Postman, pastikan URL bisa diakses:

**Buka browser dan akses:**
```
http://localhost:8000/api/v1/products
```

**Seharusnya muncul JSON response seperti ini:**
```json
{
  "success": true,
  "message": "Products retrieved successfully",
  "data": {
    "products": [...],
    "pagination": {...}
  }
}
```

Jika muncul JSON ✅ berarti API berjalan!
Jika muncul 404 ❌ berarti server belum jalan atau port salah.

---

### **Langkah 4: Test Register di Postman**

1. **Pastikan environment "Ulosta Local" aktif** (dropdown di kanan atas)

2. **Buka request "Register"**

3. **Cek URL harus seperti ini:**
   ```
   POST http://localhost:8000/api/v1/register
   ```
   
   Atau kalau pakai variable:
   ```
   POST {{base_url}}/register
   ```
   
   Yang akan resolve ke: `http://localhost:8000/api/v1/register`

4. **Pastikan Headers:**
   ```
   Accept: application/json
   Content-Type: application/json
   ```

5. **Body (JSON):**
   ```json
   {
       "name": "Test User",
       "email": "rantypakpahan@gmail.com",
       "password": "password123",
       "password_confirmation": "password123",
       "phone": "081234567890"
   }
   ```

6. **Klik Send**

---

## 🔍 Cara Cek Masalahnya

### **Test 1: Cek Server Running**

```powershell
# Di PowerShell
$response = Invoke-WebRequest -Uri "http://localhost:8000/api/v1/products" -UseBasicParsing
$response.StatusCode
```

**Expected:** `200` ✅
**Jika error:** Server belum jalan atau port salah

---

### **Test 2: Cek Route Terdaftar**

```powershell
php artisan route:list --path=api/v1/register
```

**Expected:** Muncul route `POST api/v1/register` ✅

---

### **Test 3: Test Register Langsung via PowerShell**

```powershell
$body = @{
    name = "Test User"
    email = "test@example.com"
    password = "password123"
    password_confirmation = "password123"
    phone = "081234567890"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/register" `
    -Method POST `
    -Body $body `
    -ContentType "application/json" `
    -Headers @{"Accept"="application/json"}

$response
```

**Expected:** JSON dengan `"success": true` ✅

---

## 🚨 Common Problems & Solutions

### **Problem 1: nginx/1.22.0 error**

**Cause:** Anda mengakses nginx server (port 80), bukan Laravel server (port 8000)

**Solution:** 
- ✅ Gunakan: `http://localhost:8000/api/v1/register`
- ❌ Jangan: `http://localhost/api/v1/register`

---

### **Problem 2: Server running tapi tetap 404**

**Cause:** Route API belum terdaftar

**Solution:** 
Cek file `bootstrap/app.php` apakah sudah include api routes:

```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',  // ← Ini harus ada!
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
```

Jika belum ada, tambahkan baris `api: ...`

---

### **Problem 3: Environment variable tidak work**

**Cause:** Environment tidak aktif atau variable salah

**Solution:**
1. Pastikan environment "Ulosta Local" dipilih (dropdown kanan atas)
2. Cek variable `{{base_url}}` resolve ke URL yang benar
3. Hover mouse di `{{base_url}}` di URL bar, akan muncul nilai aslinya

---

### **Problem 4: Cannot POST /api/v1/register**

**Cause:** Method HTTP salah

**Solution:** Pastikan method adalah **POST**, bukan GET

---

## ✅ Checklist Sebelum Test

- [ ] Server Laravel running (`php artisan serve`)
- [ ] Browser bisa akses `http://localhost:8000/api/v1/products`
- [ ] Postman environment "Ulosta Local" aktif
- [ ] Variable `base_url` = `http://localhost:8000/api/v1`
- [ ] Request method = POST
- [ ] Headers include `Accept: application/json`
- [ ] Body type = raw JSON

---

## 🎯 Quick Fix (Copy-Paste)

**Di Postman:**

1. **Environment Settings:**
   ```
   Variable: base_url
   Value: http://localhost:8000/api/v1
   ```

2. **Request URL:**
   ```
   POST {{base_url}}/register
   ```

3. **Headers:**
   ```
   Accept: application/json
   Content-Type: application/json
   ```

4. **Body (raw JSON):**
   ```json
   {
       "name": "Test User",
       "email": "test@example.com",
       "password": "password123",
       "password_confirmation": "password123",
       "phone": "081234567890"
   }
   ```

5. **Klik Send**

---

## 💡 Alternative: Gunakan Laragon Virtual Host

Jika Anda pakai Laragon dan sudah setup virtual host:

**Base URL:** `http://ulosta.test/api/v1`

**Cara cek virtual host:**
1. Buka `C:\Windows\System32\drivers\etc\hosts`
2. Cari baris: `127.0.0.1 ulosta.test`
3. Jika ada, bisa pakai: `http://ulosta.test/api/v1/register`

---

## 📞 Still Getting 404?

**Debug steps:**

1. **Restart server:**
   ```powershell
   # Tekan Ctrl+C di terminal server
   # Jalankan lagi:
   php artisan serve
   ```

2. **Clear cache:**
   ```powershell
   php artisan route:clear
   php artisan cache:clear
   php artisan config:clear
   ```

3. **Check routes again:**
   ```powershell
   php artisan route:list --path=api/v1
   ```

4. **Test with curl:**
   ```powershell
   curl http://localhost:8000/api/v1/products
   ```

---

## ✅ Expected Success Response

Setelah fix, response seharusnya seperti ini:

```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "Test User",
            "email": "test@example.com",
            "role": "buyer",
            "updated_at": "2025-12-10T...",
            "created_at": "2025-12-10T..."
        },
        "token": "1|abc123xyz...",
        "token_type": "Bearer"
    }
}
```

**Status Code:** 201 Created ✅

---

## 🎉 Setelah Berhasil

Token akan **otomatis tersimpan** ke environment variable `token` karena ada test script di request Register.

Lanjut test endpoints lain:
1. **GET** `/products` - Browse products
2. **POST** `/cart` - Add to cart
3. **GET** `/cart` - View cart
4. **POST** `/orders` - Create order

**Happy Testing! 🚀**
