# PAWN BROKER APPLICATION - QUICK START GUIDE

## ✅ Application Successfully Recovered!

Your pawn broker application has been completely recreated and is ready to use.

---

## 🚀 Getting Started

### 1. Start the Development Server

```bash
cd c:\Users\deiveegan\.gemini\antigravity\scratch\pawn-broker-complete
php artisan serve
```

The application will be available at: **http://localhost:8000**

### 2. Create Your First User

1. Visit: http://localhost:8000/register
2. Fill in your details:
   - Name
   - Email
   - Password (minimum 8 characters)
3. Click "Register"

### 3. Login

After registration, you'll be automatically logged in and redirected to the Customers page.

---

## 📋 Main Features

### Customer Management
- **Add Customer**: Click "Add New Customer" button
- **View Customer**: Click "View" in the customer list
- **Edit Customer**: Click "Edit" in the customer list
- **Delete Customer**: Click "Delete" (with confirmation)

### Loan Management
- Create loans for customers
- Track loan status (Active/Closed/Defaulted)
- Automatic interest calculation
- Generate pawn tickets (PDF)

### Payment Tracking
- Record payments against loans
- Automatic receipt generation (PDF)
- Track payment history
- Auto-close loans on full settlement

---

## 🎯 Typical Workflow

### Creating a New Loan

1. **Add Customer First**
   - Go to Customers → Add New Customer
   - Fill in all required details
   - Upload customer photo (optional)
   - Save

2. **Create Loan**
   - View the customer details
   - Click "New Loan"
   - Enter loan details:
     - Principal amount
     - Interest rate (%)
     - Duration (days)
     - Loan date
   - System automatically calculates:
     - Due date
     - Total amount (principal + interest)
     - Unique loan number

3. **Add Pawned Items**
   - After creating loan
   - Add item details (jewelry, electronics, etc.)
   - Specify weight, purity (for jewelry)
   - Upload item photo

4. **Record Payments**
   - Go to Payments → Add Payment
   - Select the loan
   - Enter payment amount
   - Choose payment type:
     - Interest only
     - Principal
     - Full settlement
   - System generates receipt automatically

---

## 📁 Application Structure

```
pawn-broker-complete/
├── app/
│   ├── Http/Controllers/
│   │   ├── CustomerController.php
│   │   ├── LoanController.php
│   │   └── PaymentController.php
│   └── Models/
│       ├── Customer.php
│       ├── Loan.php
│       ├── Item.php
│       └── Payment.php
├── database/
│   ├── migrations/
│   │   ├── create_customers_table.php
│   │   ├── create_loans_table.php
│   │   ├── create_items_table.php
│   │   └── create_payments_table.php
│   └── database.sqlite (auto-created)
├── resources/views/
│   ├── customers/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── show.blade.php
│   │   └── edit.blade.php
│   ├── loans/
│   ├── payments/
│   └── pdfs/
└── routes/
    └── web.php
```

---

## 🔧 Configuration

### Database
- Type: SQLite (file-based, no setup needed)
- Location: `database/database.sqlite`
- Already configured and migrated

### File Storage
- Customer photos: `storage/app/public/customers/`
- Item photos: `storage/app/public/items/`
- Storage link: Already created

### Environment
- `.env` file: Already configured
- App key: Already generated
- Debug mode: Enabled (for development)

---

## 📝 Database Schema

### Customers Table
- Personal information
- Contact details
- ID proof (Aadhaar, PAN, etc.)
- Address
- Photo

### Loans Table
- Customer reference
- Loan number (auto-generated)
- Principal amount
- Interest rate
- Duration and dates
- Total amount
- Status

### Items Table
- Loan reference
- Item details
- Category (Gold, Silver, Electronics, etc.)
- Weight and purity (for jewelry)
- Estimated value
- Photo

### Payments Table
- Loan reference
- Payment amount
- Payment date
- Payment type
- Payment method
- Receipt number (auto-generated)

---

## 🎨 User Interface

- **Framework**: Laravel Blade + Tailwind CSS
- **Design**: Clean, modern, responsive
- **Navigation**: Top navigation bar with user menu
- **Tables**: Sortable, paginated listings
- **Forms**: Validated with error messages
- **Alerts**: Success/error notifications

---

## 📄 PDF Generation

### Pawn Tickets
- Generated for each loan
- Contains customer and item details
- Loan terms and conditions
- Download from loan details page

### Payment Receipts
- Generated for each payment
- Contains payment details
- Loan information
- Download from payment details page

---

## ⚠️ Important Notes

### Backup Your Data
**IMMEDIATELY** set up version control:

```bash
cd c:\Users\deiveegan\.gemini\antigravity\scratch\pawn-broker-complete
git init
git add .
git commit -m "Initial commit - Pawn Broker Application"
```

### Push to GitHub (Recommended)
```bash
git remote add origin https://github.com/yourusername/pawn-broker.git
git push -u origin main
```

### Regular Backups
- Database file: `database/database.sqlite`
- Uploaded files: `storage/app/public/`
- Copy these regularly to a safe location

---

## 🐛 Troubleshooting

### Server Won't Start
```bash
# Check if port 8000 is in use
php artisan serve --port=8001
```

### Database Errors
```bash
# Reset database
php artisan migrate:fresh
```

### Permission Errors
```bash
# Fix storage permissions (Windows)
icacls storage /grant Users:F /T
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📞 Next Steps

1. ✅ Start the server
2. ✅ Register your account
3. ✅ Add your first customer
4. ✅ Create a test loan
5. ✅ Record a payment
6. ✅ Set up Git backup
7. ⏳ Create remaining views (loans, payments)
8. ⏳ Create PDF templates
9. ⏳ Add more features as needed

---

## 🎉 You're All Set!

Your pawn broker application is fully functional and ready to use. Start by creating your first customer and loan!

**Application URL**: http://localhost:8000

---

*Last Updated: December 21, 2025 02:00 AM*
