# 🎯 API Testing - Quick Reference

## 📦 Files Created

```
✅ routes/api.php                          - API Routes
✅ app/Http/Controllers/Api/               - 6 API Controllers
✅ app/Traits/ApiResponse.php              - Response Helper
✅ app/Models/User.php                     - Updated with HasApiTokens
✅ Ulosta_API.postman_collection.json      - Import ini ke Postman
✅ POSTMAN_API_DOCUMENTATION.md            - Dokumentasi Lengkap
✅ TESTING_QUICKSTART.md                   - Panduan Testing
✅ PENJELASAN_API_UNTUK_DOSEN.md           - Penjelasan untuk Dosen
```

---

## ⚡ Quick Start (3 Steps)

### 1. Import ke Postman
- Buka Postman
- Klik Import
- Pilih: `Ulosta_API.postman_collection.json`

### 2. Setup Environment
- Create environment: "Ulosta Local"
- Variable: `base_url` = `http://localhost:8000/api/v1`
- Variable: `token` = (kosongkan)

### 3. Test!
1. **POST** `/register` - Register user
2. **GET** `/products` - Lihat products
3. **POST** `/cart` - Add to cart
4. **POST** `/orders` - Checkout

---

## 🌐 Base URL

**PENTING:** Pastikan base_url di Postman Environment sudah benar!

```
http://localhost:8000/api/v1
```

Atau jika pakai Laragon virtual host:
```
http://ulosta.test/api/v1
```

**❌ SALAH:** `http://localhost/api/v1` (tanpa port 8000)
**✅ BENAR:** `http://localhost:8000/api/v1` (dengan port 8000)

---

## 🔑 Authentication

1. **Register/Login** → Dapat token
2. Gunakan token di header:
   ```
   Authorization: Bearer {token}
   ```

Token akan **auto-save** di Postman environment setelah login!

---

## 📋 Endpoints Overview

| Endpoint | Method | Auth | Deskripsi |
|----------|--------|------|-----------|
| `/register` | POST | ❌ | Register user baru |
| `/login` | POST | ❌ | Login user |
| `/login/google` | POST | ❌ | Login dengan Google |
| `/login/facebook` | POST | ❌ | Login dengan Facebook |
| `/products` | GET | ❌ | List semua products |
| `/products/{id}` | GET | ❌ | Detail product |
| `/cart` | GET | ✅ | Lihat cart |
| `/cart` | POST | ✅ | Add to cart |
| `/cart/{id}` | DELETE | ✅ | Remove from cart |
| `/orders` | POST | ✅ | Create order |
| `/orders` | GET | ✅ | List orders |
| `/wishlist` | GET/POST/DELETE | ✅ | Manage wishlist |
| `/profile` | GET/PUT | ✅ | Manage profile |

---

## 📖 Dokumentasi Lengkap

- **POSTMAN_API_DOCUMENTATION.md** - Detail semua endpoint
- **TESTING_QUICKSTART.md** - Step-by-step testing guide
- **PENJELASAN_API_UNTUK_DOSEN.md** - Penjelasan konsep

---

## 🎯 Testing Scenarios

### Scenario 1: Basic Flow
```
1. Register → Token tersimpan
2. Get Products → Browse products
3. Add to Cart → product_id: 1, quantity: 2
4. View Cart → See cart items
5. Create Order → Checkout
6. View Orders → Order history
```

### Scenario 2: Wishlist Flow
```
1. Login
2. Add to Wishlist → product_id: 1
3. View Wishlist
4. Remove from Wishlist
```

### Scenario 3: Profile Management
```
1. Login
2. View Profile
3. Update Profile → name, phone, address
4. Update Password
```

---

## 🚨 Common Issues

### ❌ 404 Not Found
- ✅ Pastikan server running: `php artisan serve`
- ✅ Cek base_url di Postman

### ❌ 401 Unauthorized
- ✅ Login dulu untuk dapat token
- ✅ Pastikan token tersimpan di environment
- ✅ Gunakan Bearer Token authorization

### ❌ 500 Server Error
- ✅ Cek terminal Laravel untuk error detail
- ✅ Pastikan database sudah migrate
- ✅ Cek `.env` configuration

---

## 💡 Tips

✨ **Auto-save Token**: Request Login & Register sudah include script untuk auto-save token ke environment

✨ **Sample Data**: Semua request body sudah diisi contoh data, tinggal edit

✨ **Organized**: Request dikelompokkan berdasarkan category di sidebar Postman

✨ **Query Params**: Products endpoint support filter, search, sort, pagination

---

## 🎓 Untuk Dosen

API ini **terpisah** dari web interface:
- Routes terpisah: `routes/api.php` vs `routes/web.php`
- Controllers terpisah: `Api/*Controller` vs `*Controller`
- Authentication terpisah: Token-based vs Session-based
- Response terpisah: JSON vs HTML Views

Bisa di-test independent menggunakan Postman tanpa perlu akses web browser.

---

## ✅ Ready to Test!

1. Start server: `php artisan serve`
2. Open Postman
3. Import collection
4. Start testing!

**Happy Testing! 🚀**
