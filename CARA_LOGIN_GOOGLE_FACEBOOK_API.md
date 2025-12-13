# 🔐 CARA LOGIN DENGAN GOOGLE/FACEBOOK DI API

## 📋 Ada 2 Cara Login OAuth via API:

---

## ✅ **CARA 1: TEST MODE (MUDAH - UNTUK TESTING)**

Saya sudah buatkan endpoint khusus untuk testing tanpa perlu OAuth token asli!

### **Endpoint Test Google Login:**
```
POST http://localhost:8000/api/v1/test/login/google
```

**Body (JSON):**
```json
{
    "email": "yourname@gmail.com",
    "name": "Your Name"
}
```

**Headers:**
```
Accept: application/json
Content-Type: application/json
```

**Response:**
```json
{
    "success": true,
    "message": "Login with Google successful (TEST MODE)",
    "data": {
        "user": {
            "id": 1,
            "name": "Your Name",
            "email": "yourname@gmail.com",
            "google_id": "google_abc123...",
            "role": "buyer"
        },
        "token": "1|abc123xyz...",
        "token_type": "Bearer"
    }
}
```

### **Endpoint Test Facebook Login:**
```
POST http://localhost:8000/api/v1/test/login/facebook
```

**Body (JSON):**
```json
{
    "email": "yourname@example.com",
    "name": "Your Name"
}
```

**Keuntungan Test Mode:**
- ✅ Tidak perlu Google OAuth access token
- ✅ Mudah untuk testing
- ✅ Langsung dapat token untuk test endpoint lain
- ✅ Simulasi seperti login Google/FB asli

**⚠️ CATATAN:** Endpoint test ini hanya untuk development/testing!

---

## 🎯 **CARA 2: REAL OAUTH (PRODUCTION MODE)**

Jika ingin test dengan Google OAuth asli:

### **Langkah A: Dapatkan Google Access Token**

#### **Option 1: Dari Web Browser**
1. Buka browser
2. Login ke web Anda: `http://localhost:8000/masuk`
3. Klik "Login dengan Google"
4. Buka **Developer Tools (F12)**
5. Tab **Network** → Lihat request OAuth callback
6. Copy **access_token** dari response

#### **Option 2: Google OAuth Playground**
1. Buka: https://developers.google.com/oauthplayground/
2. Klik **⚙️ Settings**
3. Centang "Use your own OAuth credentials"
4. Masukkan Client ID & Secret dari `.env` Anda:
   ```
   GOOGLE_CLIENT_ID=...
   GOOGLE_CLIENT_SECRET=...
   ```
5. Step 1: Pilih scope:
   - `https://www.googleapis.com/auth/userinfo.email`
   - `https://www.googleapis.com/auth/userinfo.profile`
6. Klik **"Authorize APIs"**
7. Login dengan Google → Allow
8. Step 2: Klik **"Exchange authorization code for tokens"**
9. Copy **"Access token"**

### **Langkah B: Test di Postman**

```
POST http://localhost:8000/api/v1/login/google
```

**Body (JSON):**
```json
{
    "access_token": "ya29.a0AfB_byC8kXyZ..."
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login with Google successful",
    "data": {
        "user": {...},
        "token": "1|...",
        "token_type": "Bearer"
    }
}
```

---

## 📦 **Update Postman Collection**

Tambahkan 2 request baru di folder **Authentication**:

### **1. Test Login Google (Easy Mode)**
- **Method:** POST
- **URL:** `{{base_url}}/test/login/google`
- **Body:**
```json
{
    "email": "test.google@example.com",
    "name": "Test Google User"
}
```

### **2. Test Login Facebook (Easy Mode)**
- **Method:** POST
- **URL:** `{{base_url}}/test/login/facebook`
- **Body:**
```json
{
    "email": "test.facebook@example.com",
    "name": "Test Facebook User"
}
```

**Test Script (sama seperti login biasa):**
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

var jsonData = pm.response.json();
if (jsonData.data && jsonData.data.token) {
    pm.environment.set("token", jsonData.data.token);
}
```

---

## 🧪 **Testing Flow**

### **Flow 1: Test Mode (RECOMMENDED)**
```
1. POST /test/login/google
   Body: { "email": "user@gmail.com", "name": "User" }
   → Dapat token ✓

2. GET /user (dengan token)
   Header: Authorization: Bearer {token}
   → Lihat user info ✓

3. POST /cart (dengan token)
   → Add product to cart ✓
```

### **Flow 2: Real OAuth**
```
1. Dapatkan access token dari Google OAuth Playground
2. POST /login/google
   Body: { "access_token": "ya29..." }
   → Dapat token ✓
3. Test endpoint lain dengan token
```

---

## ❓ **FAQ**

### **Q: Kenapa ada 2 endpoint (test & real)?**
**A:** 
- `/test/login/google` - Untuk testing, tidak perlu OAuth token asli
- `/login/google` - Untuk production, pakai OAuth token asli dari Google

### **Q: Apa bedanya?**
**A:**
- Test mode: Hanya perlu email & name
- Real mode: Perlu access token dari Google OAuth

### **Q: Token yang dihasilkan sama?**
**A:** Ya! Keduanya menghasilkan Laravel Sanctum token yang valid untuk authenticate API request selanjutnya.

### **Q: Aman tidak test mode ini?**
**A:** Test mode hanya untuk development. Di production, hapus route test dan hanya pakai real OAuth.

### **Q: Bagaimana cara dapat Google Client ID?**
**A:** Lihat file `.env` Anda:
```env
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
```

---

## ✅ **Quick Test di Postman**

Copy-paste ini ke Postman:

**Request: Test Login Google**
```
POST {{base_url}}/test/login/google
```

**Headers:**
```
Accept: application/json
Content-Type: application/json
```

**Body:**
```json
{
    "email": "test@gmail.com",
    "name": "Test User"
}
```

**Send** → Token tersimpan otomatis! ✅

---

## 🎉 **Selesai!**

Sekarang Anda bisa test login Google/Facebook dengan mudah di Postman tanpa ribet dengan OAuth flow!

Token yang didapat bisa langsung dipakai untuk test endpoint lain yang perlu authentication. 🚀
