# API DOCUMENTATION

## 🔌 Pawn Broker Application - API Reference

**Version**: 1.0.0  
**Base URL**: `http://localhost:8000`  
**Authentication**: Laravel Sanctum (Session-based)

---

## 📋 Table of Contents

1. [Authentication](#authentication)
2. [Customer Endpoints](#customer-endpoints)
3. [Loan Endpoints](#loan-endpoints)
4. [Payment Endpoints](#payment-endpoints)
5. [Error Handling](#error-handling)
6. [Response Formats](#response-formats)

---

## Authentication

All API endpoints require authentication using Laravel Breeze session-based authentication.

### Login

**POST** `/login`

```json
{
  "email": "user@example.com",
  "password": "password"
}
```

**Response**: 302 Redirect to dashboard

### Register

**POST** `/register`

```json
{
  "name": "John Doe",
  "email": "user@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

**Response**: 302 Redirect to dashboard

### Logout

**POST** `/logout`

**Response**: 302 Redirect to home

---

## Customer Endpoints

### List All Customers

**GET** `/customers`

**Query Parameters**:
- `page` (optional): Page number for pagination
- `search` (optional): Search term for name/mobile

**Response**:
```json
{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "mobile": "9876543210",
      "email": "john@example.com",
      "city": "Chennai",
      "active_loans_count": 2,
      "created_at": "2025-12-21T00:00:00.000000Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

### Create Customer

**POST** `/customers`

**Request Body** (multipart/form-data):
```json
{
  "name": "John Doe",
  "mobile": "9876543210",
  "email": "john@example.com",
  "aadhaar": "123456789012",
  "pan": "ABCDE1234F",
  "id_proof_type": "Aadhaar",
  "id_proof_number": "123456789012",
  "address": "123 Main Street",
  "city": "Chennai",
  "state": "Tamil Nadu",
  "pincode": "600001",
  "photo": "<file>"
}
```

**Validation Rules**:
- `name`: required, string, max:255
- `mobile`: required, digits:10, unique
- `email`: nullable, email, unique
- `aadhaar`: nullable, digits:12, unique
- `pan`: nullable, regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/, unique
- `pincode`: nullable, digits:6
- `photo`: nullable, image, max:2048

**Response**: 302 Redirect to customer details

### View Customer

**GET** `/customers/{id}`

**Response**:
```json
{
  "id": 1,
  "name": "John Doe",
  "mobile": "9876543210",
  "email": "john@example.com",
  "aadhaar": "123456789012",
  "pan": "ABCDE1234F",
  "address": "123 Main Street",
  "city": "Chennai",
  "state": "Tamil Nadu",
  "pincode": "600001",
  "photo_url": "/storage/customers/photo.jpg",
  "loans": [
    {
      "id": 1,
      "loan_number": "LN20251221001",
      "principal_amount": "10000.00",
      "status": "active",
      "due_date": "2025-01-20"
    }
  ],
  "created_at": "2025-12-21T00:00:00.000000Z"
}
```

### Update Customer

**PUT/PATCH** `/customers/{id}`

**Request Body**: Same as Create Customer

**Response**: 302 Redirect to customer details

### Delete Customer

**DELETE** `/customers/{id}`

**Response**: 302 Redirect to customers list

**Note**: Cannot delete customers with active loans

---

## Loan Endpoints

### List All Loans

**GET** `/loans`

**Query Parameters**:
- `page` (optional): Page number
- `status` (optional): Filter by status (active/closed/defaulted)
- `customer_id` (optional): Filter by customer

**Response**:
```json
{
  "data": [
    {
      "id": 1,
      "loan_number": "LN20251221001",
      "customer": {
        "id": 1,
        "name": "John Doe",
        "mobile": "9876543210"
      },
      "principal_amount": "10000.00",
      "interest_rate": "2.00",
      "total_amount": "10600.00",
      "status": "active",
      "loan_date": "2025-12-21",
      "due_date": "2026-01-20",
      "balance": "10600.00"
    }
  ]
}
```

### Create Loan

**POST** `/loans`

**Request Body**:
```json
{
  "customer_id": 1,
  "principal_amount": 10000,
  "interest_rate": 2.0,
  "duration_days": 30,
  "loan_date": "2025-12-21"
}
```

**Validation Rules**:
- `customer_id`: required, exists:customers,id
- `principal_amount`: required, numeric, min:1
- `interest_rate`: required, numeric, min:0
- `duration_days`: required, integer, min:1
- `loan_date`: required, date

**Auto-Generated Fields**:
- `loan_number`: LN{YYYYMMDD}{XXXX}
- `due_date`: loan_date + duration_days
- `total_amount`: principal + (principal × interest_rate × duration_days / 30)

**Response**: 302 Redirect to loan details

### View Loan

**GET** `/loans/{id}`

**Response**:
```json
{
  "id": 1,
  "loan_number": "LN20251221001",
  "customer": {
    "id": 1,
    "name": "John Doe",
    "mobile": "9876543210"
  },
  "principal_amount": "10000.00",
  "interest_rate": "2.00",
  "duration_days": 30,
  "loan_date": "2025-12-21",
  "due_date": "2026-01-20",
  "total_amount": "10600.00",
  "status": "active",
  "items": [
    {
      "id": 1,
      "category": "Gold Jewelry",
      "description": "22K Gold Chain",
      "weight": "50.000",
      "purity": "22K",
      "estimated_value": "150000.00"
    }
  ],
  "payments": [
    {
      "id": 1,
      "receipt_number": "RCP20251221001",
      "amount": "600.00",
      "payment_date": "2025-12-21",
      "payment_type": "interest_only"
    }
  ],
  "balance": "10000.00",
  "total_paid": "600.00"
}
```

### Update Loan

**PUT/PATCH** `/loans/{id}`

**Request Body**: Same as Create Loan

**Response**: 302 Redirect to loan details

**Note**: Cannot update closed or defaulted loans

### Delete Loan

**DELETE** `/loans/{id}`

**Response**: 302 Redirect to loans list

**Note**: Cannot delete loans with payment history

### Generate Pawn Ticket PDF

**GET** `/loans/{id}/pawn-ticket`

**Response**: PDF file download

---

## Payment Endpoints

### List All Payments

**GET** `/payments`

**Query Parameters**:
- `page` (optional): Page number
- `loan_id` (optional): Filter by loan
- `payment_type` (optional): Filter by type

**Response**:
```json
{
  "data": [
    {
      "id": 1,
      "receipt_number": "RCP20251221001",
      "loan": {
        "id": 1,
        "loan_number": "LN20251221001"
      },
      "amount": "600.00",
      "payment_date": "2025-12-21",
      "payment_type": "interest_only",
      "payment_method": "Cash"
    }
  ]
}
```

### Create Payment

**POST** `/payments`

**Request Body**:
```json
{
  "loan_id": 1,
  "amount": 600,
  "payment_date": "2025-12-21",
  "payment_type": "interest_only",
  "payment_method": "Cash",
  "notes": "Monthly interest payment"
}
```

**Validation Rules**:
- `loan_id`: required, exists:loans,id
- `amount`: required, numeric, min:1
- `payment_date`: required, date, before_or_equal:today
- `payment_type`: required, in:interest_only,principal,full_settlement
- `payment_method`: required, string
- `notes`: nullable, string

**Auto-Generated Fields**:
- `receipt_number`: RCP{YYYYMMDD}{XXXX}

**Business Logic**:
- If `payment_type` = 'full_settlement', loan status changes to 'closed'
- Payment amount is validated against loan balance

**Response**: 302 Redirect to payment details

### View Payment

**GET** `/payments/{id}`

**Response**:
```json
{
  "id": 1,
  "receipt_number": "RCP20251221001",
  "loan": {
    "id": 1,
    "loan_number": "LN20251221001",
    "customer": {
      "name": "John Doe"
    }
  },
  "amount": "600.00",
  "payment_date": "2025-12-21",
  "payment_type": "interest_only",
  "payment_method": "Cash",
  "notes": "Monthly interest payment",
  "created_at": "2025-12-21T00:00:00.000000Z"
}
```

### Generate Payment Receipt PDF

**GET** `/payments/{id}/receipt`

**Response**: PDF file download

---

## Error Handling

### Validation Errors

**Status Code**: 422 Unprocessable Entity

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "mobile": [
      "The mobile has already been taken."
    ],
    "email": [
      "The email must be a valid email address."
    ]
  }
}
```

### Not Found

**Status Code**: 404 Not Found

```json
{
  "message": "Resource not found"
}
```

### Unauthorized

**Status Code**: 401 Unauthorized

```json
{
  "message": "Unauthenticated."
}
```

### Server Error

**Status Code**: 500 Internal Server Error

```json
{
  "message": "Server Error",
  "error": "Detailed error message (only in debug mode)"
}
```

---

## Response Formats

### Success Response (List)

```json
{
  "data": [...],
  "links": {
    "first": "http://localhost:8000/customers?page=1",
    "last": "http://localhost:8000/customers?page=5",
    "prev": null,
    "next": "http://localhost:8000/customers?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "per_page": 15,
    "to": 15,
    "total": 75
  }
}
```

### Success Response (Single Resource)

```json
{
  "id": 1,
  "field1": "value1",
  "field2": "value2",
  "created_at": "2025-12-21T00:00:00.000000Z",
  "updated_at": "2025-12-21T00:00:00.000000Z"
}
```

### Success Response (Action)

**Status Code**: 302 Found (Redirect)

With flash message in session:
```php
session()->flash('success', 'Operation completed successfully');
```

---

## Rate Limiting

Currently no rate limiting is implemented. For production, consider:

- 60 requests per minute for authenticated users
- 10 requests per minute for unauthenticated users

---

## CORS

CORS is not configured by default. For API access from external domains, configure in `config/cors.php`.

---

## Testing

### Using cURL

```bash
# Login
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}' \
  -c cookies.txt

# Get customers (authenticated)
curl -X GET http://localhost:8000/customers \
  -b cookies.txt
```

### Using Postman

1. Import the collection (if available)
2. Set base URL to `http://localhost:8000`
3. Use session cookies for authentication

---

## Changelog

### Version 1.0.0 (2025-12-21)
- Initial API documentation
- Customer, Loan, and Payment endpoints
- Authentication endpoints
- Error handling documentation

---

**API Version**: 1.0.0  
**Last Updated**: December 21, 2025  
**Maintained By**: Pawn Broker Development Team
