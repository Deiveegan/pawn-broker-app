# DATABASE SCHEMA DOCUMENTATION

## 📊 Pawn Broker Application - Complete Database Schema

**Version**: 1.0.0  
**Last Updated**: December 21, 2025  
**Database Type**: MySQL / MariaDB  
**Character Set**: utf8mb4_unicode_ci

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Tables](#tables)
3. [Relationships](#relationships)
4. [Indexes](#indexes)
5. [Constraints](#constraints)
6. [Sample Queries](#sample-queries)

---

## Overview

The Pawn Broker application uses **10 tables** to manage the complete business operations:

### Core Business Tables
- **customers** - Customer information and identity documents
- **loans** - Loan agreements with interest calculation
- **pawn_items** - Pawned items (collateral) with photos
- **payments** - Payment transactions with receipts

### System Tables
- **users** - System users (admin, staff, auditor)
- **roles** - User roles and permissions
- **role_user** - User-role assignments (pivot table)

### Audit & Tracking Tables
- **audit_logs** - Complete audit trail of all changes
- **interest_logs** - Interest calculation history

### Cache Tables
- **cache** - Application cache storage
- **cache_locks** - Cache lock management

### Entity Relationship Diagram

```
┌─────────────┐
│  customers  │
└──────┬──────┘
       │
       │ 1:N
       │
┌──────▼──────┐
│    loans    │
└──────┬──────┘
       │
       ├─────────┐
       │ 1:N     │ 1:N
       │         │
┌──────▼──────┐ │
│    items    │ │
└─────────────┘ │
                │
         ┌──────▼──────┐
         │  payments   │
         └─────────────┘
```

---

## Tables

### 1. customers

Stores customer personal information, identity documents, and contact details.

#### Schema

| Column            | Type            | Nullable | Default        | Description                |
| ----------------- | --------------- | -------- | -------------- | -------------------------- |
| `id`              | BIGINT UNSIGNED | NO       | AUTO_INCREMENT | Primary key                |
| `name`            | VARCHAR(255)    | NO       | -              | Full name of customer      |
| `mobile`          | VARCHAR(15)     | NO       | -              | Mobile number (10 digits)  |
| `email`           | VARCHAR(255)    | YES      | NULL           | Email address (optional)   |
| `aadhaar`         | VARCHAR(12)     | YES      | NULL           | Aadhaar number (12 digits) |
| `pan`             | VARCHAR(10)     | YES      | NULL           | PAN card number            |
| `id_proof_type`   | VARCHAR(50)     | YES      | NULL           | Type of ID proof           |
| `id_proof_number` | VARCHAR(100)    | YES      | NULL           | ID proof number            |
| `address`         | TEXT            | YES      | NULL           | Complete address           |
| `city`            | VARCHAR(100)    | YES      | NULL           | City name                  |
| `state`           | VARCHAR(100)    | YES      | NULL           | State name                 |
| `pincode`         | VARCHAR(6)      | YES      | NULL           | PIN code (6 digits)        |
| `photo`           | VARCHAR(255)    | YES      | NULL           | Customer photo path        |
| `created_at`      | TIMESTAMP       | YES      | NULL           | Record creation timestamp  |
| `updated_at`      | TIMESTAMP       | YES      | NULL           | Record update timestamp    |

#### Indexes

- **PRIMARY KEY**: `id`
- **INDEX**: `customers_mobile_index` on `mobile`
- **INDEX**: `customers_aadhaar_index` on `aadhaar`
- **INDEX**: `customers_pan_index` on `pan`

#### Constraints

- `mobile` must be exactly 10 digits
- `aadhaar` must be exactly 12 digits (if provided)
- `pan` must match pattern: 5 letters + 4 digits + 1 letter (if provided)
- `pincode` must be exactly 6 digits (if provided)

---

### 2. loans

Stores loan agreements with interest calculation and status tracking.

#### Schema

| Column             | Type            | Nullable | Default        | Description                           |
| ------------------ | --------------- | -------- | -------------- | ------------------------------------- |
| `id`               | BIGINT UNSIGNED | NO       | AUTO_INCREMENT | Primary key                           |
| `customer_id`      | BIGINT UNSIGNED | NO       | -              | Foreign key to customers              |
| `loan_number`      | VARCHAR(50)     | NO       | -              | Unique loan number (LN20251221XXXX)   |
| `principal_amount` | DECIMAL(10,2)   | NO       | -              | Loan principal amount                 |
| `interest_rate`    | DECIMAL(5,2)    | NO       | -              | Interest rate (% per month)           |
| `duration_days`    | INTEGER         | NO       | -              | Loan duration in days                 |
| `loan_date`        | DATE            | NO       | -              | Loan start date                       |
| `due_date`         | DATE            | NO       | -              | Loan due date                         |
| `total_amount`     | DECIMAL(10,2)   | NO       | -              | Principal + Interest                  |
| `status`           | ENUM            | NO       | 'active'       | Loan status (active/closed/defaulted) |
| `created_at`       | TIMESTAMP       | YES      | NULL           | Record creation timestamp             |
| `updated_at`       | TIMESTAMP       | YES      | NULL           | Record update timestamp               |

#### Indexes

- **PRIMARY KEY**: `id`
- **UNIQUE KEY**: `loans_loan_number_unique` on `loan_number`
- **FOREIGN KEY**: `loans_customer_id_foreign` on `customer_id` → `customers(id)`
- **INDEX**: `loans_status_index` on `status`
- **INDEX**: `loans_due_date_index` on `due_date`

#### Constraints

- `customer_id` references `customers(id)` ON DELETE CASCADE
- `principal_amount` must be > 0
- `interest_rate` must be >= 0
- `duration_days` must be > 0
- `total_amount` = `principal_amount` + calculated interest

#### Status Values

- **active**: Loan is currently active
- **closed**: Loan fully settled
- **defaulted**: Loan overdue and not settled

---

### 3. items

Stores details of pawned items (collateral) linked to loans.

#### Schema

| Column            | Type            | Nullable | Default        | Description                                  |
| ----------------- | --------------- | -------- | -------------- | -------------------------------------------- |
| `id`              | BIGINT UNSIGNED | NO       | AUTO_INCREMENT | Primary key                                  |
| `loan_id`         | BIGINT UNSIGNED | NO       | -              | Foreign key to loans                         |
| `category`        | VARCHAR(100)    | NO       | -              | Item category (Gold/Silver/Electronics/etc.) |
| `description`     | TEXT            | NO       | -              | Item description                             |
| `weight`          | DECIMAL(8,3)    | YES      | NULL           | Weight in grams (for jewelry)                |
| `purity`          | VARCHAR(20)     | YES      | NULL           | Purity (22K, 18K, etc.)                      |
| `estimated_value` | DECIMAL(10,2)   | NO       | -              | Estimated market value                       |
| `photo`           | VARCHAR(255)    | YES      | NULL           | Item photo path                              |
| `created_at`      | TIMESTAMP       | YES      | NULL           | Record creation timestamp                    |
| `updated_at`      | TIMESTAMP       | YES      | NULL           | Record update timestamp                      |

#### Indexes

- **PRIMARY KEY**: `id`
- **FOREIGN KEY**: `items_loan_id_foreign` on `loan_id` → `loans(id)`
- **INDEX**: `items_category_index` on `category`

#### Constraints

- `loan_id` references `loans(id)` ON DELETE CASCADE
- `estimated_value` must be > 0
- `weight` must be > 0 (if provided)

#### Common Categories

- Gold Jewelry
- Silver Jewelry
- Electronics (TV, Laptop, Mobile)
- Vehicles (Two-wheeler, Car)
- Household Items
- Others

---

### 4. payments

Stores payment transactions against loans.

#### Schema

| Column           | Type            | Nullable | Default        | Description                             |
| ---------------- | --------------- | -------- | -------------- | --------------------------------------- |
| `id`             | BIGINT UNSIGNED | NO       | AUTO_INCREMENT | Primary key                             |
| `loan_id`        | BIGINT UNSIGNED | NO       | -              | Foreign key to loans                    |
| `receipt_number` | VARCHAR(50)     | NO       | -              | Unique receipt number (RCP20251221XXXX) |
| `amount`         | DECIMAL(10,2)   | NO       | -              | Payment amount                          |
| `payment_date`   | DATE            | NO       | -              | Payment date                            |
| `payment_type`   | ENUM            | NO       | -              | Type of payment                         |
| `payment_method` | VARCHAR(50)     | NO       | -              | Payment method (Cash/UPI/etc.)          |
| `notes`          | TEXT            | YES      | NULL           | Additional notes                        |
| `created_at`     | TIMESTAMP       | YES      | NULL           | Record creation timestamp               |
| `updated_at`     | TIMESTAMP       | YES      | NULL           | Record update timestamp                 |

#### Indexes

- **PRIMARY KEY**: `id`
- **UNIQUE KEY**: `payments_receipt_number_unique` on `receipt_number`
- **FOREIGN KEY**: `payments_loan_id_foreign` on `loan_id` → `loans(id)`
- **INDEX**: `payments_payment_date_index` on `payment_date`

#### Constraints

- `loan_id` references `loans(id)` ON DELETE CASCADE
- `amount` must be > 0

#### Payment Types

- **interest_only**: Only interest payment
- **principal**: Principal payment (partial settlement)
- **full_settlement**: Complete loan closure

#### Payment Methods

- Cash
- UPI
- Bank Transfer
- Cheque
- Card

---

## Relationships

### Customer → Loans (One-to-Many)

```php
// Customer Model
public function loans()
{
    return $this->hasMany(Loan::class);
}

// Loan Model
public function customer()
{
    return $this->belongsTo(Customer::class);
}
```

### Loan → Items (One-to-Many)

```php
// Loan Model
public function items()
{
    return $this->hasMany(Item::class);
}

// Item Model
public function loan()
{
    return $this->belongsTo(Loan::class);
}
```

### Loan → Payments (One-to-Many)

```php
// Loan Model
public function payments()
{
    return $this->hasMany(Payment::class);
}

// Payment Model
public function loan()
{
    return $this->belongsTo(Loan::class);
}
```

---

## Indexes

### Performance Optimization

All tables include strategic indexes for optimal query performance:

1. **Primary Keys**: Auto-indexed on all `id` columns
2. **Foreign Keys**: Indexed for join performance
3. **Unique Constraints**: Indexed for uniqueness checks
4. **Search Fields**: Indexed on commonly searched columns
5. **Status Fields**: Indexed for filtering

### Index Usage Examples

```sql
-- Fast customer lookup by mobile
SELECT * FROM customers WHERE mobile = '9876543210';

-- Fast loan lookup by status
SELECT * FROM loans WHERE status = 'active';

-- Fast payment lookup by date
SELECT * FROM payments WHERE payment_date >= '2025-01-01';
```

---

## Constraints

### Foreign Key Constraints

All foreign keys use **CASCADE DELETE** to maintain referential integrity:

- Deleting a customer deletes all their loans
- Deleting a loan deletes all its items and payments

### Data Integrity Rules

1. **Customer Validation**:
   - Mobile number must be unique
   - Aadhaar must be unique (if provided)
   - PAN must be unique (if provided)

2. **Loan Validation**:
   - Loan number must be unique
   - Principal amount must be positive
   - Interest rate must be non-negative
   - Duration must be positive

3. **Payment Validation**:
   - Receipt number must be unique
   - Payment amount must be positive
   - Payment date cannot be future date

---

## Sample Queries

### Get Customer with Active Loans

```sql
SELECT c.*, COUNT(l.id) as active_loans
FROM customers c
LEFT JOIN loans l ON c.id = l.customer_id AND l.status = 'active'
GROUP BY c.id;
```

### Get Loan with Items and Payments

```sql
SELECT 
    l.*,
    c.name as customer_name,
    COUNT(DISTINCT i.id) as item_count,
    COUNT(DISTINCT p.id) as payment_count,
    COALESCE(SUM(p.amount), 0) as total_paid
FROM loans l
INNER JOIN customers c ON l.customer_id = c.id
LEFT JOIN items i ON l.id = i.loan_id
LEFT JOIN payments p ON l.id = p.loan_id
WHERE l.id = ?
GROUP BY l.id;
```

### Get Overdue Loans

```sql
SELECT l.*, c.name as customer_name, c.mobile
FROM loans l
INNER JOIN customers c ON l.customer_id = c.id
WHERE l.status = 'active' 
  AND l.due_date < CURRENT_DATE
ORDER BY l.due_date ASC;
```

### Calculate Loan Balance

```sql
SELECT 
    l.loan_number,
    l.total_amount,
    COALESCE(SUM(p.amount), 0) as paid_amount,
    (l.total_amount - COALESCE(SUM(p.amount), 0)) as balance
FROM loans l
LEFT JOIN payments p ON l.id = p.loan_id
WHERE l.id = ?
GROUP BY l.id;
```

---

## Migration Files

All tables are created using Laravel migrations located in:
`database/migrations/`

1. `2025_12_20_202625_create_customers_table.php`
2. `2025_12_20_202633_create_loans_table.php`
3. `2025_12_20_202640_create_items_table.php`
4. `2025_12_20_202647_create_payments_table.php`

### Running Migrations

```bash
# Run all migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset and re-run all migrations
php artisan migrate:fresh
```

---

## Database Seeding

For testing purposes, you can seed the database with sample data:

```bash
php artisan db:seed
```

---

## Backup and Restore

### SQLite Backup

```bash
# Backup
copy database\database.sqlite database\backup_YYYYMMDD.sqlite

# Restore
copy database\backup_YYYYMMDD.sqlite database\database.sqlite
```

### MySQL Backup

```bash
# Backup
mysqldump -u username -p pawn_broker > backup_YYYYMMDD.sql

# Restore
mysql -u username -p pawn_broker < backup_YYYYMMDD.sql
```

---

## Performance Considerations

1. **Indexes**: All foreign keys and frequently queried columns are indexed
2. **Cascade Deletes**: Automatic cleanup of related records
3. **Timestamps**: Automatic tracking of record creation and updates
4. **Soft Deletes**: Can be implemented for audit trail (currently not enabled)

---

## Future Enhancements

Potential schema improvements for future versions:

1. **Audit Trail**: Add audit logs table for tracking all changes
2. **Soft Deletes**: Implement soft deletes for data recovery
3. **User Tracking**: Add `created_by` and `updated_by` columns
4. **Interest Logs**: Separate table for interest calculation history
5. **Document Storage**: Table for storing multiple documents per customer
6. **SMS/Email Logs**: Track all communications with customers

---

**Schema Version**: 1.0.0  
**Compatible With**: Laravel 12.x  
**Last Reviewed**: December 21, 2025
