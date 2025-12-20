# USER MANUAL

## 📖 Pawn Broker Application - Complete User Guide

**Version**: 1.0.0  
**Last Updated**: December 21, 2025  
**For**: End Users (Pawn Shop Staff & Managers)

---

## 📋 Table of Contents

1. [Getting Started](#getting-started)
2. [Dashboard Overview](#dashboard-overview)
3. [Customer Management](#customer-management)
4. [Loan Management](#loan-management)
5. [Payment Processing](#payment-processing)
6. [Reports and PDFs](#reports-and-pdfs)
7. [Common Tasks](#common-tasks)
8. [Tips and Best Practices](#tips-and-best-practices)
9. [Troubleshooting](#troubleshooting)
10. [FAQ](#faq)

---

## Getting Started

### Logging In

1. Open your web browser
2. Navigate to: `http://yourdomain.com` (or `http://localhost:8000` for local)
3. Click **"Login"** button
4. Enter your email and password
5. Click **"Log In"**

### First Time Setup

If you're a new user:
1. Click **"Register"** on the login page
2. Fill in:
   - Your full name
   - Email address
   - Password (minimum 8 characters)
   - Confirm password
3. Click **"Register"**
4. You'll be automatically logged in

### Logging Out

1. Click your name in the top-right corner
2. Select **"Log Out"**

---

## Dashboard Overview

After logging in, you'll see the main dashboard with:

### Navigation Menu
- **Dashboard** - Home page with statistics
- **Customers** - Manage customer records
- **Loans** - Manage pawn loans
- **Payments** - Record and view payments

### Quick Statistics (Dashboard)
- Total Customers
- Active Loans
- Total Loan Amount
- Payments Today
- Overdue Loans

---

## Customer Management

### Adding a New Customer

1. Click **"Customers"** in the navigation menu
2. Click **"Add New Customer"** button
3. Fill in the customer details:

#### Personal Information (Required)
- **Name**: Customer's full name
- **Mobile**: 10-digit mobile number

#### Personal Information (Optional)
- **Email**: Email address
- **Aadhaar**: 12-digit Aadhaar number
- **PAN**: PAN card number (format: ABCDE1234F)
- **ID Proof Type**: Select from dropdown (Aadhaar/PAN/Driving License/etc.)
- **ID Proof Number**: Corresponding ID number

#### Address Information
- **Address**: Full street address
- **City**: City name
- **State**: State name
- **Pincode**: 6-digit PIN code

#### Photo Upload
- Click **"Choose File"**
- Select customer photo (JPG, PNG, max 2MB)
- Photo will be displayed on customer profile

4. Click **"Save Customer"**
5. You'll see a success message and be redirected to the customer details page

### Viewing Customer Details

1. Go to **"Customers"** page
2. Click **"View"** button next to any customer
3. You'll see:
   - Customer personal information
   - Contact details
   - Address
   - Photo (if uploaded)
   - List of all loans for this customer
   - Quick action buttons

### Editing Customer Information

1. Go to customer details page
2. Click **"Edit"** button
3. Update any information
4. Click **"Update Customer"**

**Note**: You cannot change the customer's mobile number if they have active loans.

### Deleting a Customer

1. Go to **"Customers"** page
2. Click **"Delete"** button next to the customer
3. Confirm the deletion

**Important**: You cannot delete a customer who has active loans. Close all loans first.

### Searching for Customers

1. Go to **"Customers"** page
2. Use the search box at the top
3. Search by:
   - Customer name
   - Mobile number
   - City

---

## Loan Management

### Creating a New Loan

1. Go to **"Loans"** page
2. Click **"Create New Loan"** button
3. Fill in loan details:

#### Loan Information
- **Customer**: Select customer from dropdown (or create new)
- **Principal Amount**: Loan amount in ₹
- **Interest Rate**: Interest rate per month (%)
- **Duration**: Loan period in days
- **Loan Date**: Date of loan disbursement

4. Click **"Calculate"** to see:
   - Due date (automatically calculated)
   - Interest amount
   - Total amount to be repaid

5. Click **"Create Loan"**

#### Auto-Generated Information
- **Loan Number**: Automatically generated (format: LN20251221001)
- **Due Date**: Loan date + duration days
- **Total Amount**: Principal + Interest

### Adding Pawned Items

After creating a loan, add the items being pawned:

1. On the loan details page, click **"Add Item"**
2. Fill in item details:
   - **Category**: Gold/Silver/Electronics/Vehicle/Others
   - **Description**: Detailed description
   - **Weight**: (For jewelry) in grams
   - **Purity**: (For jewelry) 22K, 18K, etc.
   - **Estimated Value**: Market value in ₹
   - **Photo**: Upload item photo

3. Click **"Add Item"**
4. Repeat for multiple items

### Viewing Loan Details

1. Go to **"Loans"** page
2. Click **"View"** next to any loan
3. You'll see:
   - Customer information
   - Loan terms and amounts
   - List of pawned items
   - Payment history
   - Current balance
   - Days remaining/overdue

### Loan Status

Loans can have three statuses:

- **🟢 Active**: Loan is current and active
- **🔴 Overdue**: Loan has passed due date
- **⚫ Closed**: Loan fully settled
- **🟠 Defaulted**: Loan defaulted (manual status)

### Editing a Loan

1. Go to loan details page
2. Click **"Edit"** button
3. Update loan information
4. Click **"Update Loan"**

**Note**: You cannot edit closed or defaulted loans.

### Generating Pawn Ticket

1. Go to loan details page
2. Click **"Print Pawn Ticket"** button
3. PDF will be generated and downloaded
4. Print and give to customer

---

## Payment Processing

### Recording a Payment

1. Go to **"Payments"** page
2. Click **"Record Payment"** button
3. Fill in payment details:

#### Payment Information
- **Loan**: Select loan from dropdown
- **Amount**: Payment amount in ₹
- **Payment Date**: Date of payment
- **Payment Type**: Select one:
  - **Interest Only**: Only interest payment
  - **Principal**: Partial principal payment
  - **Full Settlement**: Complete loan closure
- **Payment Method**: Cash/UPI/Bank Transfer/Cheque/Card
- **Notes**: Any additional notes (optional)

4. Click **"Record Payment"**

#### Auto-Generated Information
- **Receipt Number**: Automatically generated (format: RCP20251221001)

### Payment Types Explained

#### Interest Only
- Pays only the interest amount
- Principal remains unchanged
- Loan stays active

#### Principal (Partial Settlement)
- Pays part of the principal
- Interest should be paid first
- Loan stays active until fully paid

#### Full Settlement
- Pays complete outstanding amount
- Loan automatically closes
- Customer can reclaim items

### Viewing Payment Details

1. Go to **"Payments"** page
2. Click **"View"** next to any payment
3. You'll see:
   - Payment receipt number
   - Loan information
   - Customer details
   - Payment amount and date
   - Payment method
   - Notes

### Generating Payment Receipt

1. Go to payment details page
2. Click **"Print Receipt"** button
3. PDF receipt will be generated
4. Print and give to customer

### Payment History

To view all payments for a loan:
1. Go to loan details page
2. Scroll to **"Payment History"** section
3. You'll see:
   - All payments made
   - Payment dates
   - Amounts
   - Payment types
   - Running balance

---

## Reports and PDFs

### Pawn Ticket (Loan Agreement)

**What it contains**:
- Customer information
- Loan details and terms
- List of pawned items
- Interest calculation
- Due date
- Terms and conditions

**How to generate**:
1. Go to loan details page
2. Click **"Print Pawn Ticket"**
3. PDF downloads automatically

### Payment Receipt

**What it contains**:
- Receipt number
- Customer information
- Loan number
- Payment amount
- Payment date and method
- Outstanding balance
- Shop details

**How to generate**:
1. Go to payment details page
2. Click **"Print Receipt"**
3. PDF downloads automatically

---

## Common Tasks

### Daily Opening Checklist

1. **Login** to the system
2. **Check Dashboard** for:
   - Overdue loans
   - Payments due today
   - New customer inquiries
3. **Review** any pending tasks

### Processing a New Pawn Transaction

**Step-by-step workflow**:

1. **Customer Arrives**
   - Check if existing customer (search by mobile)
   - If new, create customer record

2. **Assess Items**
   - Inspect pawned items
   - Determine value
   - Agree on loan amount

3. **Create Loan**
   - Enter loan details
   - Calculate interest
   - Generate loan number

4. **Add Items**
   - Record each item
   - Take photos
   - Note weight/purity (for jewelry)

5. **Generate Pawn Ticket**
   - Print pawn ticket
   - Get customer signature
   - Give copy to customer

6. **Disburse Cash**
   - Give loan amount to customer
   - Store items securely

### Processing a Payment

**Step-by-step workflow**:

1. **Customer Arrives**
   - Ask for loan number or search by name/mobile
   - View loan details

2. **Check Balance**
   - View current outstanding amount
   - Check if interest is due

3. **Record Payment**
   - Select payment type
   - Enter amount
   - Choose payment method

4. **Generate Receipt**
   - Print payment receipt
   - Give to customer

5. **If Full Settlement**
   - Loan automatically closes
   - Return pawned items to customer
   - Get customer signature

### Closing a Loan

**Automatic closure** when:
- Full settlement payment is recorded
- System automatically changes status to "Closed"

**Manual closure** (if needed):
1. Go to loan details
2. Click **"Edit"**
3. Change status to "Closed"
4. Save

### Handling Overdue Loans

1. **Identify Overdue Loans**
   - Dashboard shows overdue count
   - Go to **"Loans"** page
   - Filter by status: "Overdue"

2. **Contact Customer**
   - View customer details
   - Call mobile number
   - Send reminder

3. **Record Payment** when received

4. **If No Response**
   - Mark as "Defaulted" (manual)
   - Follow company policy for auction

---

## Tips and Best Practices

### Customer Management
✅ **DO**:
- Always verify customer identity
- Take clear photos
- Double-check mobile numbers
- Update address if customer moves

❌ **DON'T**:
- Skip mandatory fields
- Use fake/test data
- Delete customers with loan history

### Loan Management
✅ **DO**:
- Take clear photos of all items
- Record exact weight for jewelry
- Verify purity with testing
- Calculate fair loan amounts
- Print pawn ticket immediately

❌ **DON'T**:
- Over-value items
- Skip item documentation
- Forget to give pawn ticket to customer

### Payment Processing
✅ **DO**:
- Always generate receipt
- Verify payment method
- Count cash carefully
- Update system immediately

❌ **DON'T**:
- Accept payments without recording
- Forget to print receipt
- Mix up loan numbers

### Data Entry
✅ **DO**:
- Enter data immediately
- Double-check numbers
- Use proper formats
- Save frequently

❌ **DON'T**:
- Delay data entry
- Use abbreviations
- Skip optional but useful fields

---

## Troubleshooting

### Cannot Login

**Problem**: "Invalid credentials" error

**Solution**:
1. Check email spelling
2. Verify password (case-sensitive)
3. Click "Forgot Password" to reset
4. Contact administrator if still issues

### Cannot Add Customer

**Problem**: "Mobile number already exists"

**Solution**:
- Mobile number must be unique
- Search for existing customer
- Update existing record instead

**Problem**: "Invalid Aadhaar/PAN format"

**Solution**:
- Aadhaar: exactly 12 digits
- PAN: 5 letters + 4 digits + 1 letter
- Remove spaces and special characters

### Cannot Create Loan

**Problem**: "Customer not found"

**Solution**:
- Create customer record first
- Or select from existing customers

**Problem**: "Invalid interest calculation"

**Solution**:
- Check principal amount (must be positive)
- Check interest rate (must be 0 or positive)
- Check duration (must be positive)

### Photo Upload Issues

**Problem**: "File too large"

**Solution**:
- Maximum file size: 2MB
- Resize photo before uploading
- Use JPG format for smaller size

**Problem**: "Invalid file type"

**Solution**:
- Only JPG, PNG, JPEG allowed
- Check file extension

### PDF Not Generating

**Problem**: PDF doesn't download

**Solution**:
1. Check browser pop-up blocker
2. Allow downloads from site
3. Try different browser
4. Contact administrator

---

## FAQ

### General Questions

**Q: Can I use this on mobile?**  
A: Yes, the application is mobile-responsive and works on all devices.

**Q: Is my data secure?**  
A: Yes, all data is encrypted and securely stored. Only authorized users can access.

**Q: Can multiple users work simultaneously?**  
A: Yes, the system supports multiple concurrent users.

### Customer Management

**Q: Can I have two customers with same mobile number?**  
A: No, mobile numbers must be unique to prevent duplicates.

**Q: Can I delete a customer?**  
A: Yes, but only if they have no active loans. Close all loans first.

**Q: What if customer changes mobile number?**  
A: Edit the customer record and update the mobile number.

### Loan Management

**Q: Can I modify a loan after creation?**  
A: Yes, but only if the loan is still active. Closed loans cannot be edited.

**Q: What happens when a loan becomes overdue?**  
A: The system automatically marks it as overdue. You should contact the customer.

**Q: Can I extend a loan duration?**  
A: Yes, edit the loan and update the duration/due date.

**Q: How is interest calculated?**  
A: Interest = (Principal × Rate × Days) ÷ 30 (monthly rate)

### Payment Management

**Q: Can I delete a payment?**  
A: No, payments cannot be deleted for audit purposes. Contact administrator if correction needed.

**Q: What if I enter wrong payment amount?**  
A: Contact administrator immediately to correct the record.

**Q: Can customer pay more than due amount?**  
A: Yes, excess amount will be adjusted against principal.

**Q: What happens after full settlement?**  
A: Loan automatically closes. Return items to customer.

---

## Getting Help

### In-App Help
- Look for **?** icons throughout the application
- Hover for quick tips

### Contact Support
- **Email**: support@yourdomain.com
- **Phone**: +91-XXXXXXXXXX
- **Hours**: Monday-Saturday, 9 AM - 6 PM

### Training
- Request training session from administrator
- User manual available for download
- Video tutorials (if available)

---

## Keyboard Shortcuts

- **Ctrl + S**: Save form (when in edit mode)
- **Ctrl + F**: Search (on list pages)
- **Esc**: Close modal/popup
- **Tab**: Navigate between form fields

---

## Glossary

- **Principal**: Original loan amount
- **Interest**: Charge for borrowing money
- **Pawn Ticket**: Loan agreement document
- **Collateral**: Items pawned as security
- **Settlement**: Loan repayment
- **Overdue**: Past due date
- **LTV**: Loan-to-Value ratio
- **Receipt**: Payment proof document

---

**User Manual Version**: 1.0.0  
**Last Updated**: December 21, 2025  
**For Questions**: Contact your system administrator

---

*This manual is for reference purposes. Actual screens may vary slightly based on updates.*
