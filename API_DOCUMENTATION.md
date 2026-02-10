# Restaurant API Documentation

## Base URL
```
http://localhost:8000/api
```

## Authentication

### Login
- **POST** `/login`
- **Body:**
  ```json
  {
    "email": "pelayan@restaurant.com",
    "password": "password"
  }
  ```
- **Response:**
  ```json
  {
    "success": true,
    "message": "Login successful",
    "data": {
      "user": {
        "id": 1,
        "name": "Ahmad Pelayan",
        "email": "pelayan@restaurant.com",
        "role": "pelayan"
      },
      "token": "generated_token"
    }
  }
  ```

### Register
- **POST** `/register`
- **Body:**
  ```json
  {
    "name": "New User",
    "email": "user@restaurant.com",
    "password": "password",
    "password_confirmation": "password",
    "role": "pelayan"
  }
  ```

### Logout
- **POST** `/logout` (Protected)
- **Headers:** `Authorization: Bearer {token}`

### Get Profile
- **GET** `/me` (Protected)
- **Headers:** `Authorization: Bearer {token}`

## Tables

### Get All Tables
- **GET** `/tables` (Public)
- **Query Params:** `status` (available/occupied)

### Get Available Tables
- **GET** `/tables/available` (Public)

### Get Table Details
- **GET** `/tables/{id}` (Public)

### Create Table
- **POST** `/tables` (Protected)
- **Body:**
  ```json
  {
    "number": "MEJA-11",
    "capacity": 4,
    "status": "available"
  }
  ```

## Foods

### Get All Foods
- **GET** `/foods` (Public)
- **Query Params:** `category` (makanan/minuman), `available` (true/false)

### Get Food Details
- **GET** `/foods/{id}` (Public)

### Create Food
- **POST** `/foods` (Protected)
- **Body:**
  ```json
  {
    "name": "New Food",
    "description": "Description",
    "category": "makanan",
    "price": 25000,
    "available": true
  }
  ```

### Update Food
- **PUT** `/foods/{id}` (Protected)

### Delete Food
- **DELETE** `/foods/{id}` (Protected)

## Orders

### Get All Orders
- **GET** `/orders` (Protected)
- **Query Params:** `status` (open/closed/paid), `table_id`

### Create Order
- **POST** `/orders` (Protected)
- **Body:**
  ```json
  {
    "table_id": 1
  }
  ```

### Get Order Details
- **GET** `/orders/{id}` (Protected)

### Add Item to Order
- **POST** `/orders/{id}/items` (Protected)
- **Body:**
  ```json
  {
    "food_id": 1,
    "quantity": 2,
    "notes": "Extra spicy"
  }
  ```

### Remove Item from Order
- **DELETE** `/orders/{id}/items/{itemId}` (Protected)

### Close Order
- **POST** `/orders/{id}/close` (Protected)

### Mark Order as Paid
- **POST** `/orders/{id}/paid` (Protected)

### Get Receipt (HTML)
- **GET** `/orders/{id}/receipt` (Protected)

### Download Receipt (PDF)
- **GET** `/orders/{id}/receipt/pdf` (Protected)

## Sample Users

### Pelayan (Waiter)
- **Email:** `pelayan@restaurant.com`
- **Password:** `password`

### Kasir (Cashier)
- **Email:** `kasir@restaurant.com`
- **Password:** `password`

## Error Responses

All endpoints return consistent error responses:

```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field": ["Validation error"]
  }
}
```

## Status Codes

- `200` - Success
- `201` - Created
- `401` - Unauthorized
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

## Features Implemented

✅ User Authentication (Login, Register, Logout)
✅ Role-based Access (Pelayan, Kasir)
✅ Table Management
✅ Food CRUD Operations
✅ Order Management
✅ Order Item Management
✅ Receipt Generation (HTML & PDF)
✅ Database Seeders with Sample Data
✅ API Validation & Error Handling
✅ RESTful API Design
