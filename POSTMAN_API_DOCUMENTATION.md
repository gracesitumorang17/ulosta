# ULOSTA API - Dokumentasi Postman

Base URL: `http://localhost/api/v1`

## Setup di Postman

### 1. Buat Environment Baru
- Name: `Ulosta Local`
- Variables:
  - `base_url` = `http://localhost/api/v1`
  - `token` = (akan diisi otomatis setelah login)

### 2. Header Global (untuk authenticated requests)
```
Authorization: Bearer {{token}}
Accept: application/json
Content-Type: application/json
```

---

## 📌 AUTHENTICATION ENDPOINTS

### 1. Register User
**POST** `{{base_url}}/register`

**Body (JSON):**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "081234567890"
}
```

**Response Success (201):**
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "081234567890",
            "role": "buyer"
        },
        "token": "1|abcdefghijklmnopqrstuvwxyz...",
        "token_type": "Bearer"
    }
}
```

**Test Script (untuk save token otomatis):**
```javascript
pm.test("Status code is 201", function () {
    pm.response.to.have.status(201);
});

var jsonData = pm.response.json();
if (jsonData.data && jsonData.data.token) {
    pm.environment.set("token", jsonData.data.token);
}
```

---

### 2. Login User
**POST** `{{base_url}}/login`

**Body (JSON):**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": { ... },
        "token": "2|xyz...",
        "token_type": "Bearer"
    }
}
```

**Test Script:**
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

### 3. Login with Google
**POST** `{{base_url}}/login/google`

**Body (JSON):**
```json
{
    "access_token": "google_access_token_dari_frontend"
}
```

**Cara Dapat Access Token:**
1. Login via web browser dengan Google OAuth
2. Ambil access token dari response callback
3. Gunakan token tersebut untuk hit API ini

---

### 4. Login with Facebook
**POST** `{{base_url}}/login/facebook`

**Body (JSON):**
```json
{
    "access_token": "facebook_access_token_dari_frontend"
}
```

---

### 5. Get Current User (Protected)
**GET** `{{base_url}}/user`

**Headers:**
```
Authorization: Bearer {{token}}
```

**Response:**
```json
{
    "success": true,
    "message": "User retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "buyer"
    }
}
```

---

### 6. Logout (Protected)
**POST** `{{base_url}}/logout`

**Headers:**
```
Authorization: Bearer {{token}}
```

---

## 📦 PRODUCTS ENDPOINTS

### 1. Get All Products
**GET** `{{base_url}}/products`

**Query Parameters (Optional):**
- `category` - Filter by category
- `tag` - Filter by tag
- `search` - Search by name
- `sort_by` - Sort field (default: created_at)
- `sort_order` - asc/desc (default: desc)
- `per_page` - Items per page (default: 12)
- `page` - Page number

**Example:**
```
GET {{base_url}}/products?category=Elektronik&per_page=10&page=1
```

**Response:**
```json
{
    "success": true,
    "message": "Products retrieved successfully",
    "data": {
        "products": [...],
        "pagination": {
            "current_page": 1,
            "last_page": 5,
            "per_page": 12,
            "total": 50
        }
    }
}
```

---

### 2. Get Product Detail
**GET** `{{base_url}}/products/{id}`

**Example:**
```
GET {{base_url}}/products/1
```

---

### 3. Get Products by Category
**GET** `{{base_url}}/products/category/{category}`

**Example:**
```
GET {{base_url}}/products/category/Elektronik
```

---

### 4. Search Products
**GET** `{{base_url}}/products/search?q=laptop`

---

## 🛒 CART ENDPOINTS (Protected)

### 1. Get Cart
**GET** `{{base_url}}/cart`

**Headers:**
```
Authorization: Bearer {{token}}
```

**Response:**
```json
{
    "success": true,
    "message": "Cart retrieved successfully",
    "data": {
        "items": [...],
        "total": 500000,
        "item_count": 3
    }
}
```

---

### 2. Add to Cart
**POST** `{{base_url}}/cart`

**Headers:**
```
Authorization: Bearer {{token}}
```

**Body:**
```json
{
    "product_id": 1,
    "quantity": 2
}
```

---

### 3. Update Cart Item
**PUT** `{{base_url}}/cart/{id}`

**Body:**
```json
{
    "quantity": 5
}
```

---

### 4. Remove from Cart
**DELETE** `{{base_url}}/cart/{id}`

---

### 5. Clear Cart
**DELETE** `{{base_url}}/cart`

---

### 6. Get Cart Count
**GET** `{{base_url}}/cart/count`

**Response:**
```json
{
    "success": true,
    "message": "Cart count retrieved successfully",
    "data": {
        "count": 3
    }
}
```

---

## ❤️ WISHLIST ENDPOINTS (Protected)

### 1. Get Wishlist
**GET** `{{base_url}}/wishlist`

---

### 2. Add to Wishlist
**POST** `{{base_url}}/wishlist`

**Body:**
```json
{
    "product_id": 1
}
```

---

### 3. Remove from Wishlist
**DELETE** `{{base_url}}/wishlist/{id}`

---

### 4. Get Wishlist Count
**GET** `{{base_url}}/wishlist/count`

---

## 📋 ORDER ENDPOINTS (Protected)

### 1. Get All Orders
**GET** `{{base_url}}/orders`

---

### 2. Create Order
**POST** `{{base_url}}/orders`

**Body:**
```json
{
    "shipping_address": "Jl. Contoh No. 123, Jakarta",
    "payment_method": "transfer"
}
```

**Note:** Order akan dibuat dari cart items yang ada

---

### 3. Get Order Detail
**GET** `{{base_url}}/orders/{id}`

---

### 4. Cancel Order
**PUT** `{{base_url}}/orders/{id}/cancel`

**Note:** Hanya bisa cancel order dengan status "Menunggu"

---

## 👤 PROFILE ENDPOINTS (Protected)

### 1. Get Profile
**GET** `{{base_url}}/profile`

---

### 2. Update Profile
**PUT** `{{base_url}}/profile`

**Body:**
```json
{
    "name": "John Doe Updated",
    "phone": "081234567890",
    "address": "New Address"
}
```

---

### 3. Update Password
**POST** `{{base_url}}/profile/password`

**Body:**
```json
{
    "current_password": "oldpassword123",
    "new_password": "newpassword123",
    "new_password_confirmation": "newpassword123"
}
```

---

## 🔧 TESTING FLOW di Postman

### Flow 1: Register & Browse Products
1. **POST /register** - Register user baru
2. **GET /products** - Lihat semua products
3. **GET /products/1** - Lihat detail product

### Flow 2: Complete Shopping
1. **POST /login** - Login
2. **POST /cart** - Add product ke cart (product_id: 1, quantity: 2)
3. **POST /cart** - Add product lagi (product_id: 2, quantity: 1)
4. **GET /cart** - Lihat isi cart
5. **POST /orders** - Checkout (buat order)
6. **GET /orders** - Lihat order history

### Flow 3: Wishlist Management
1. **POST /login** - Login
2. **POST /wishlist** - Add to wishlist (product_id: 3)
3. **GET /wishlist** - Lihat wishlist
4. **DELETE /wishlist/1** - Remove from wishlist

---

## ⚠️ Error Responses

**Validation Error (422):**
```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "email": ["The email field is required."]
    }
}
```

**Unauthorized (401):**
```json
{
    "success": false,
    "message": "Unauthorized"
}
```

**Not Found (404):**
```json
{
    "success": false,
    "message": "Resource not found"
}
```

**Server Error (500):**
```json
{
    "success": false,
    "message": "Failed to process request: [error details]"
}
```

---

## 📝 Notes Penting

1. **Token Management**: 
   - Save token dari response login/register
   - Gunakan token di header `Authorization: Bearer {token}`
   
2. **Base URL**: 
   - Sesuaikan dengan URL Laravel Anda
   - Jika pakai Laragon: `http://ulosta.test/api/v1`
   - Jika pakai php artisan serve: `http://localhost:8000/api/v1`

3. **Content-Type**: 
   - Selalu gunakan `application/json` untuk request body

4. **CORS**: 
   - Jika ada error CORS, tambahkan di `config/cors.php`
