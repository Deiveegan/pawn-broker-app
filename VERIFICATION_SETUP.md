# Aadhaar and PAN Verification Setup Guide

## Overview

The Pawn Broker application now includes automatic Aadhaar and PAN verification during customer account creation. This feature validates the format of ID documents and optionally verifies them using external APIs.

## Features

✅ **Format Validation**
- Aadhaar: Validates 12-digit format
- PAN: Validates format (5 letters, 4 digits, 1 letter - e.g., ABCDE1234F)

✅ **API Verification** (Optional)
- Verifies Aadhaar using Surepass API
- Verifies PAN using Surepass API
- Stores verification status in database

✅ **Graceful Fallback**
- Works without API configuration (format validation only)
- Handles API failures gracefully
- Logs errors for debugging

## Setup Instructions

### Step 1: Sign Up for Surepass API (Optional but Recommended)

1. Visit [https://surepass.io/](https://surepass.io/)
2. Create an account
3. Subscribe to the KYC API plan
4. Get your API token from the dashboard

### Step 2: Configure Environment Variables

Add the following to your `.env` file:

```env
# Surepass API Configuration (Optional)
SUREPASS_API_TOKEN=your_api_token_here
SUREPASS_BASE_URL=https://kyc-api.surepass.io
```

**Note:** If you don't configure the API token, the system will still work with format validation only.

### Step 3: Database Migration

The migration has already been run. It adds these fields to the `customers` table:
- `id_verified` (boolean) - Whether the ID was verified
- `id_verified_at` (timestamp) - When verification occurred
- `verification_response` (text) - JSON response from verification API

## How It Works

### Customer Creation Flow

1. **User submits customer form** with ID proof type and number
2. **Format validation** checks if the ID number matches the expected format
3. **API verification** (if configured) calls Surepass API to verify the document
4. **Store results** in database with verification status
5. **Show feedback** to user about verification success/failure

### Validation Rules

#### Aadhaar Validation
- Must be exactly 12 digits
- Spaces and hyphens are automatically removed
- Example valid formats:
  - `123456789012`
  - `1234 5678 9012`
  - `1234-5678-9012`

#### PAN Validation
- Must follow format: 5 letters + 4 digits + 1 letter
- Case insensitive (automatically converted to uppercase)
- Example valid format: `ABCDE1234F`

### API Verification

When API token is configured, the system will:

1. **Aadhaar**: Call Surepass Aadhaar Validation API
   - Endpoint: `POST /api/v1/aadhaar-validation/aadhaar-validation`
   - Verifies if the Aadhaar number is valid and active

2. **PAN**: Call Surepass PAN Verification API
   - Endpoint: `POST /api/v1/pan/pan`
   - Verifies if the PAN number is valid and active

## Usage Examples

### Creating a Customer with Aadhaar

```php
POST /customers

{
    "name": "John Doe",
    "mobile": "9876543210",
    "email": "john@example.com",
    "id_proof_type": "Aadhaar",
    "id_proof_number": "123456789012",
    "address": "123 Main St",
    "city": "Mumbai",
    "state": "Maharashtra",
    "pincode": "400001"
}
```

### Creating a Customer with PAN

```php
POST /customers

{
    "name": "Jane Smith",
    "mobile": "9876543210",
    "email": "jane@example.com",
    "id_proof_type": "PAN",
    "id_proof_number": "ABCDE1234F",
    "address": "456 Park Ave",
    "city": "Delhi",
    "state": "Delhi",
    "pincode": "110001"
}
```

## Response Messages

### Success Scenarios

1. **Verified Successfully**
   ```
   Customer created successfully. ID proof verified successfully.
   ```

2. **Format Valid (No API)**
   ```
   Customer created successfully. ID proof format is valid (API verification not configured).
   ```

### Error Scenarios

1. **Invalid Format**
   ```
   The id proof number must be a valid 12-digit Aadhaar number.
   ```
   or
   ```
   The id proof number must be a valid PAN number (format: ABCDE1234F).
   ```

2. **Verification Failed**
   ```
   Customer created successfully. Warning: ID proof could not be verified.
   ```

## Checking Verification Status

You can check if a customer's ID was verified:

```php
$customer = Customer::find(1);

if ($customer->id_verified) {
    echo "ID verified on: " . $customer->id_verified_at;
} else {
    echo "ID not verified";
}

// View verification response
$response = json_decode($customer->verification_response, true);
print_r($response);
```

## Testing

### Without API Token (Format Validation Only)

1. Don't set `SUREPASS_API_TOKEN` in `.env`
2. Create a customer with Aadhaar: `123456789012`
3. Expected: Format validation passes, but `id_verified` = false

### With API Token (Full Verification)

1. Set valid `SUREPASS_API_TOKEN` in `.env`
2. Create a customer with a real Aadhaar number
3. Expected: API verification occurs, `id_verified` = true if valid

## Troubleshooting

### Issue: "ID proof could not be verified"

**Possible causes:**
1. API token not configured
2. API token is invalid
3. Network connectivity issues
4. API service is down
5. Invalid Aadhaar/PAN number

**Solution:**
- Check `.env` file for `SUREPASS_API_TOKEN`
- Check `storage/logs/laravel.log` for detailed error messages
- Verify API token is active on Surepass dashboard
- Test API connectivity manually

### Issue: Validation fails for valid Aadhaar

**Possible causes:**
1. Aadhaar contains spaces or special characters
2. Aadhaar is not exactly 12 digits

**Solution:**
- The system automatically removes spaces and hyphens
- Ensure the number is exactly 12 digits
- Example: `1234 5678 9012` is valid

## API Endpoints

### Surepass API Documentation

- **Aadhaar Verification**: https://surepass.io/aadhaar-verification-api
- **PAN Verification**: https://surepass.io/pan-verification-api

## Security Considerations

1. **API Token**: Store in `.env` file, never commit to version control
2. **Sensitive Data**: Verification responses may contain personal information
3. **Logging**: Errors are logged but sensitive data is not exposed
4. **HTTPS**: Always use HTTPS in production for API calls

## Alternative APIs

If you prefer a different verification provider, you can modify the `IdentityVerificationService` class:

```php
// app/Services/IdentityVerificationService.php

public function verifyAadhaar(string $aadhaarNumber): array
{
    // Replace with your preferred API
    $response = Http::post('https://your-api.com/verify', [
        'aadhaar' => $aadhaarNumber
    ]);
    
    // Process response
    return [
        'success' => true,
        'verified' => $response->json()['is_valid'],
        'message' => 'Verification complete',
    ];
}
```

## Support

For issues or questions:
1. Check the logs: `storage/logs/laravel.log`
2. Review Surepass API documentation
3. Contact Surepass support for API-related issues

## Future Enhancements

Potential improvements:
- [ ] Add support for more ID types (Voter ID, Driving License)
- [ ] Implement re-verification for existing customers
- [ ] Add verification status badge in UI
- [ ] Send verification status notifications
- [ ] Add verification expiry and renewal
