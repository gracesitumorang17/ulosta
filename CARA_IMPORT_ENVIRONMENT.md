# 📥 CARA IMPORT ENVIRONMENT KE POSTMAN

## File Environment yang Tersedia:

1. **`Ulosta_Local.postman_environment.json`** 
   - Untuk server: `http://localhost:8000/api/v1`
   - Gunakan ini jika menjalankan: `php artisan serve`

2. **`Ulosta_Laragon.postman_environment.json`**
   - Untuk server: `http://ulosta.test/api/v1`
   - Gunakan ini jika pakai Laragon virtual host

---

## 🎯 Langkah Import (MUDAH!)

### Step 1: Import Environment File

1. **Buka Postman**
2. Klik tombol **"Import"** (pojok kiri atas)
3. Pilih tab **"File"**
4. **Drag & drop** atau **browse** file:
   - `Ulosta_Local.postman_environment.json` (RECOMMENDED)
5. Klik **"Import"**

✅ Environment "Ulosta Local" akan muncul di list!

---

### Step 2: Aktifkan Environment

1. Lihat pojok **kanan atas** Postman
2. Ada dropdown yang tertulis **"No Environment"** atau nama environment lain
3. **Klik dropdown** tersebut
4. Pilih **"Ulosta Local"**

✅ Environment sekarang aktif!

---

### Step 3: Verifikasi

Di request Register:
- URL: `{{base_url}}/register`
- **Hover mouse** ke `{{base_url}}`
- Harus muncul: `http://localhost:8000/api/v1` ✅

---

## 📋 What's Inside?

Environment ini berisi 2 variables:

| Variable | Value | Keterangan |
|----------|-------|------------|
| `base_url` | `http://localhost:8000/api/v1` | Base URL untuk semua API endpoints |
| `token` | (empty) | Akan terisi otomatis setelah login/register |

---

## 🎬 Visual Guide

```
Step 1: Import
┌──────────────────────────────────────┐
│ Postman                              │
│ [Import] ← Click here               │
│                                      │
│ Drop file here or browse:            │
│ Ulosta_Local.postman_environment.json│
│                                      │
│            [Import]                  │
└──────────────────────────────────────┘

Step 2: Activate
┌──────────────────────────────────────┐
│                    [No Environment ▼]│ ← Click dropdown
│                                      │
│  Dropdown menu:                      │
│  ○ No Environment                    │
│  ● Ulosta Local      ← Select this! │
│  ○ Ulosta Laragon                    │
└──────────────────────────────────────┘
```

---

## ✅ Test Environment

Setelah import dan aktifkan environment:

### Test 1: Hover Variable
Di request URL `{{base_url}}/register`:
- Hover ke `{{base_url}}`
- Muncul tooltip: `http://localhost:8000/api/v1` ✅

### Test 2: Send Request
1. Klik request **Register** di collection
2. Pastikan environment **Ulosta Local** aktif (dropdown kanan atas)
3. Klik **Send**
4. ✅ Response: Status 201, success: true

### Test 3: Check Token
Setelah register/login berhasil:
1. Klik icon **👁️ (eye)** di kanan dropdown environment
2. Lihat variable `token`
3. ✅ Value sudah terisi dengan token panjang

---

## 🔄 Switch Between Environments

Jika ingin ganti server:

**Development (local):**
- Environment: **Ulosta Local**
- Server command: `php artisan serve`

**Laragon (virtual host):**
- Environment: **Ulosta Laragon**
- Tidak perlu command, Laragon auto-run

Tinggal ganti environment di dropdown! 🚀

---

## 🚨 Troubleshooting

### Import gagal?
- ✅ Pastikan file `.json` tidak corrupt
- ✅ Download ulang dari project folder
- ✅ Coba drag-drop ke Postman

### Variable tidak muncul?
- ✅ Pastikan environment sudah di-import
- ✅ Cek di Settings (⚙️) → Environments
- ✅ Harus ada "Ulosta Local" di list

### Token tidak auto-save?
- ✅ Pastikan environment aktif (dipilih)
- ✅ Cek tab "Tests" di request Register/Login
- ✅ Script auto-save sudah ada di collection

---

## 📦 Import Collection Juga!

Jangan lupa import collection-nya:
1. File: **`Ulosta_API.postman_collection.json`**
2. Import dengan cara yang sama
3. Collection berisi 27 endpoints siap pakai!

---

## ✨ Setelah Import Selesai

Anda akan punya:
- ✅ Environment "Ulosta Local" (2 variables)
- ✅ Collection "Ulosta API" (27 endpoints)
- ✅ Siap test semua API!

**Flow Testing:**
```
1. Import Environment ✓
2. Import Collection ✓
3. Activate Environment ✓
4. Test Register → Token auto-save ✓
5. Test Products → Works! ✓
6. Test Cart → Works! ✓
7. Test Orders → Works! ✓
```

---

## 🎉 Done!

Sekarang Anda punya environment yang siap pakai!

**Next:** Test request **Register** di Postman → Lihat hasilnya! 🚀
