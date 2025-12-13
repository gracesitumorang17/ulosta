# 🧪 Sample API Requests for Manual Testing

Jika tidak punya Postman, bisa test manual dengan PowerShell/curl:

---

## 1. Test Get Products (Public - No Auth)

### PowerShell:
```powershell
$response = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/products" -Method GET -Headers @{"Accept"="application/json"}
$response | ConvertTo-Json -Depth 5
```

### curl:
```bash
curl -X GET "http://localhost:8000/api/v1/products" \
  -H "Accept: application/json"
```

**Expected Response:**
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

---

## 2. Test Register User

### PowerShell:
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

$response | ConvertTo-Json -Depth 5

# Save token untuk request selanjutnya
$token = $response.data.token
Write-Host "Token: $token"
```

### curl:
```bash
curl -X POST "http://localhost:8000/api/v1/register" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "081234567890"
  }'
```

**Expected Response:**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "Test User",
      "email": "test@example.com",
      "role": "buyer"
    },
    "token": "1|abc123xyz...",
    "token_type": "Bearer"
  }
}
```

---

## 3. Test Login

### PowerShell:
```powershell
$body = @{
    email = "test@example.com"
    password = "password123"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/login" `
    -Method POST `
    -Body $body `
    -ContentType "application/json" `
    -Headers @{"Accept"="application/json"}

$token = $response.data.token
Write-Host "Token: $token"
```

### curl:
```bash
curl -X POST "http://localhost:8000/api/v1/login" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

---

## 4. Test Get Current User (Auth Required)

### PowerShell:
```powershell
# Gunakan token dari login/register
$token = "YOUR_TOKEN_HERE"

$response = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/user" `
    -Method GET `
    -Headers @{
        "Accept" = "application/json"
        "Authorization" = "Bearer $token"
    }

$response | ConvertTo-Json -Depth 5
```

### curl:
```bash
curl -X GET "http://localhost:8000/api/v1/user" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 5. Test Add to Cart (Auth Required)

### PowerShell:
```powershell
$token = "YOUR_TOKEN_HERE"

$body = @{
    product_id = 1
    quantity = 2
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/cart" `
    -Method POST `
    -Body $body `
    -ContentType "application/json" `
    -Headers @{
        "Accept" = "application/json"
        "Authorization" = "Bearer $token"
    }

$response | ConvertTo-Json -Depth 5
```

### curl:
```bash
curl -X POST "http://localhost:8000/api/v1/cart" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "product_id": 1,
    "quantity": 2
  }'
```

---

## 6. Test Get Cart (Auth Required)

### PowerShell:
```powershell
$token = "YOUR_TOKEN_HERE"

$response = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/cart" `
    -Method GET `
    -Headers @{
        "Accept" = "application/json"
        "Authorization" = "Bearer $token"
    }

$response | ConvertTo-Json -Depth 5
```

### curl:
```bash
curl -X GET "http://localhost:8000/api/v1/cart" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 7. Test Create Order (Auth Required)

### PowerShell:
```powershell
$token = "YOUR_TOKEN_HERE"

$body = @{
    shipping_address = "Jl. Contoh No. 123, Jakarta"
    payment_method = "transfer"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/orders" `
    -Method POST `
    -Body $body `
    -ContentType "application/json" `
    -Headers @{
        "Accept" = "application/json"
        "Authorization" = "Bearer $token"
    }

$response | ConvertTo-Json -Depth 5
```

### curl:
```bash
curl -X POST "http://localhost:8000/api/v1/orders" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "shipping_address": "Jl. Contoh No. 123, Jakarta",
    "payment_method": "transfer"
  }'
```

---

## Complete Test Flow (PowerShell)

```powershell
# 1. Register
$registerBody = @{
    name = "Test User"
    email = "test" + (Get-Random) + "@example.com"
    password = "password123"
    password_confirmation = "password123"
    phone = "081234567890"
} | ConvertTo-Json

$registerResponse = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/register" `
    -Method POST `
    -Body $registerBody `
    -ContentType "application/json" `
    -Headers @{"Accept"="application/json"}

$token = $registerResponse.data.token
Write-Host "✓ Registered. Token: $token" -ForegroundColor Green

# 2. Get Products
$products = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/products" `
    -Method GET `
    -Headers @{"Accept"="application/json"}

Write-Host "✓ Found $($products.data.pagination.total) products" -ForegroundColor Green

# 3. Add to Cart
if ($products.data.products.Count -gt 0) {
    $firstProduct = $products.data.products[0]
    
    $cartBody = @{
        product_id = $firstProduct.id
        quantity = 2
    } | ConvertTo-Json
    
    $cartResponse = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/cart" `
        -Method POST `
        -Body $cartBody `
        -ContentType "application/json" `
        -Headers @{
            "Accept" = "application/json"
            "Authorization" = "Bearer $token"
        }
    
    Write-Host "✓ Added to cart: $($firstProduct.name)" -ForegroundColor Green
}

# 4. View Cart
$cart = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/cart" `
    -Method GET `
    -Headers @{
        "Accept" = "application/json"
        "Authorization" = "Bearer $token"
    }

Write-Host "✓ Cart has $($cart.data.item_count) items. Total: Rp $($cart.data.total)" -ForegroundColor Green

# 5. Create Order
$orderBody = @{
    shipping_address = "Jl. Test No. 123, Jakarta"
    payment_method = "transfer"
} | ConvertTo-Json

$order = Invoke-RestMethod -Uri "http://localhost:8000/api/v1/orders" `
    -Method POST `
    -Body $orderBody `
    -ContentType "application/json" `
    -Headers @{
        "Accept" = "application/json"
        "Authorization" = "Bearer $token"
    }

Write-Host "✓ Order created: $($order.data.order_code)" -ForegroundColor Green

Write-Host "`n✅ ALL TESTS PASSED!" -ForegroundColor Green
```

---

## Notes

1. **Server harus running:**
   ```bash
   php artisan serve
   ```

2. **Base URL:**
   - Default: `http://localhost:8000/api/v1`
   - Sesuaikan jika port berbeda

3. **Token:**
   - Simpan token dari response Register/Login
   - Gunakan di header: `Authorization: Bearer {token}`

4. **Headers wajib:**
   - `Accept: application/json`
   - `Content-Type: application/json` (untuk POST/PUT)
   - `Authorization: Bearer {token}` (untuk protected routes)

---

## Quick Test (One-liner)

### Test if API is running:
```powershell
(Invoke-RestMethod -Uri "http://localhost:8000/api/v1/products").success
```
Should return: `True`

### Test auth endpoint:
```powershell
(Invoke-RestMethod -Uri "http://localhost:8000/api/v1/register" -Method POST -Body (@{name="Test";email="test@test.com";password="12345678";password_confirmation="12345678"} | ConvertTo-Json) -ContentType "application/json").success
```
Should return: `True`

---

## But Seriously, Use Postman! 😄

Manual testing dengan PowerShell/curl itu repot. 

**Postman lebih mudah:**
- ✅ GUI yang user-friendly
- ✅ Auto-save token
- ✅ History requests
- ✅ Organized collections
- ✅ Easy to share with team

**Download Postman:** https://www.postman.com/downloads/
**Import collection:** `Ulosta_API.postman_collection.json`

Happy testing! 🚀
