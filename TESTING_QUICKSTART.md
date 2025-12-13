# 🚀 QUICK START - Testing API di Postman

## ✅ Setup Selesai!

API Laravel Anda sudah siap ditest dengan struktur:
```
✓ Laravel Sanctum installed
✓ API Routes configured (routes/api.php)
✓ 6 API Controllers created
✓ Response helper trait added
✓ Postman collection ready
```

---

## 📋 Langkah-langkah Testing

### 1️⃣ Import Collection ke Postman

1. Buka **Postman**
2. Klik **Import** (pojok kiri atas)
3. Pilih file: `Ulosta_API.postman_collection.json`
4. Collection "Ulosta API" akan muncul di sidebar

### 2️⃣ Setup Environment

1. Klik icon **Environment** (⚙️) di pojok kanan atas
2. Klik **+ Create Environment**
3. Nama: `Ulosta Local`
4. Tambahkan variables:
   ```
   base_url = http://localhost:8000/api/v1
   token = (kosongkan dulu, akan terisi otomatis)
   ```
5. Save & pilih environment "Ulosta Local"

### 3️⃣ Test Flow Pertama - Register & Login

**A. Register User Baru**
1. Expand folder **Authentication**
2. Klik **Register**
3. Klik **Send**
4. ✅ Token akan tersimpan otomatis ke environment

**B. Login** (jika sudah punya akun)
1. Klik **Login**
2. Edit email/password sesuai akun Anda
3. Klik **Send**
4. ✅ Token akan update otomatis

**C. Cek User Info**
1. Klik **Get Current User**
2. Klik **Send**
3. ✅ Akan tampil data user yang login

### 4️⃣ Test Flow Kedua - Browse & Add to Cart

**A. Lihat Products**
1. Expand folder **Products**
2. Klik **Get All Products**
3. Klik **Send**
4. 📝 Copy salah satu `product_id` dari response

**B. Add to Cart**
1. Expand folder **Cart**
2. Klik **Add to Cart**
3. Edit body JSON:
   ```json
   {
       "product_id": 1,  ← ganti dengan ID product
       "quantity": 2
   }
   ```
4. Klik **Send**

**C. Lihat Cart**
1. Klik **Get Cart**
2. Klik **Send**
3. ✅ Product yang tadi ditambah akan muncul

### 5️⃣ Test Flow Ketiga - Checkout

**A. Create Order**
1. Expand folder **Orders**
2. Klik **Create Order**
3. Edit shipping address jika perlu
4. Klik **Send**
5. ✅ Order berhasil dibuat, cart otomatis clear

**B. Lihat Order History**
1. Klik **Get All Orders**
2. Klik **Send**
3. ✅ Order tadi akan muncul

---

## 🔑 Testing Login Google/Facebook

### Untuk test login social media:

1. **Dapatkan Access Token:**
   - Buka web browser
   - Login via Google/Facebook di website Anda yang sudah ada
   - Buka Developer Tools (F12) → Network tab
   - Lihat response callback, copy `access_token`

2. **Test di Postman:**
   - Klik **Login with Google** atau **Login with Facebook**
   - Paste access token ke body:
     ```json
     {
         "access_token": "PASTE_TOKEN_HERE"
     }
     ```
   - Send

**ATAU** skip step ini jika hanya testing CRUD biasa.

---

## 🌐 URL yang Bisa Digunakan

Tergantung setup Laravel Anda:

### Option 1: php artisan serve (DEFAULT)
```
http://localhost:8000/api/v1
```

### Option 2: Laragon Virtual Host
```
http://ulosta.test/api/v1
```

### Option 3: Custom Port
```
http://localhost:PORT/api/v1
```

**Update `base_url` di Postman Environment sesuai dengan URL Anda!**

---

## 📊 Endpoints Summary

| Category | Endpoint | Method | Auth Required |
|----------|----------|--------|---------------|
| Register | `/register` | POST | ❌ |
| Login | `/login` | POST | ❌ |
| Get Products | `/products` | GET | ❌ |
| Get Cart | `/cart` | GET | ✅ |
| Add to Cart | `/cart` | POST | ✅ |
| Create Order | `/orders` | POST | ✅ |
| Wishlist | `/wishlist` | GET/POST/DELETE | ✅ |
| Profile | `/profile` | GET/PUT | ✅ |

---

## ⚠️ Troubleshooting

### Error: 404 Not Found
- ✅ Pastikan server Laravel running (`php artisan serve`)
- ✅ Cek `base_url` di environment Postman sudah benar
- ✅ Pastikan ada `/api/v1` di URL

### Error: 401 Unauthorized
- ✅ Pastikan sudah login dulu
- ✅ Cek token tersimpan di environment (`{{token}}`)
- ✅ Pastikan request menggunakan Bearer Token auth

### Error: 500 Internal Server Error
- ✅ Cek terminal Laravel untuk error detail
- ✅ Pastikan database sudah di-migrate
- ✅ Cek file `.env` sudah benar

### Token tidak tersimpan otomatis
- ✅ Pastikan environment "Ulosta Local" aktif/terpilih
- ✅ Cek tab **Tests** di request Register/Login
- ✅ Manual: copy token dari response → paste ke environment

---

## 🎯 Testing Checklist

- [ ] Import collection ke Postman
- [ ] Setup environment dengan base_url
- [ ] Register user baru
- [ ] Login dan dapat token
- [ ] Get all products
- [ ] Add product to cart
- [ ] View cart
- [ ] Create order
- [ ] View order history
- [ ] Update profile
- [ ] Test wishlist
- [ ] Test logout

---

## 📞 Next Steps

Setelah semua test berhasil:

1. **Share API dengan Team:**
   - Export collection & environment dari Postman
   - Share file JSON ke team

2. **Deploy ke Production:**
   - Update `base_url` ke domain production
   - Setup CORS untuk domain frontend
   - Gunakan HTTPS untuk security

3. **Dokumentasi Lengkap:**
   - Lihat file `POSTMAN_API_DOCUMENTATION.md`
   - Berisi detail semua endpoint & response format

---

## 💡 Tips

- **Token Management:** Token otomatis tersimpan di environment setelah login/register
- **Test Script:** Semua request Register & Login punya auto-save token script
- **Folders:** Request sudah dikelompokkan berdasarkan category
- **Sample Data:** Body request sudah diisi contoh data, tinggal edit

**Happy Testing! 🎉**
