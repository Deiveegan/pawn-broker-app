<?php

/**
 * Demo script to test Aadhaar and PAN verification
 * 
 * Run this with: php artisan tinker
 * Then paste the code below
 */

// Test Aadhaar Format Validation
$service = new \App\Services\IdentityVerificationService();

echo "=== Aadhaar Format Validation ===\n";
echo "Valid: 123456789012 - " . ($service->isValidAadhaarFormat('123456789012') ? 'PASS' : 'FAIL') . "\n";
echo "Valid: 1234 5678 9012 - " . ($service->isValidAadhaarFormat('1234 5678 9012') ? 'PASS' : 'FAIL') . "\n";
echo "Invalid: 12345 - " . ($service->isValidAadhaarFormat('12345') ? 'FAIL' : 'PASS') . "\n";
echo "\n";

// Test PAN Format Validation
echo "=== PAN Format Validation ===\n";
echo "Valid: ABCDE1234F - " . ($service->isValidPANFormat('ABCDE1234F') ? 'PASS' : 'FAIL') . "\n";
echo "Valid: abcde1234f - " . ($service->isValidPANFormat('abcde1234f') ? 'PASS' : 'FAIL') . "\n";
echo "Invalid: INVALID123 - " . ($service->isValidPANFormat('INVALID123') ? 'FAIL' : 'PASS') . "\n";
echo "\n";

// Test Aadhaar Verification (without API)
echo "=== Aadhaar Verification (Format Only) ===\n";
$result = $service->verifyAadhaar('123456789012');
echo "Success: " . ($result['success'] ? 'YES' : 'NO') . "\n";
echo "Verified: " . ($result['verified'] ? 'YES' : 'NO') . "\n";
echo "Message: " . $result['message'] . "\n";
echo "\n";

// Test PAN Verification (without API)
echo "=== PAN Verification (Format Only) ===\n";
$result = $service->verifyPAN('ABCDE1234F');
echo "Success: " . ($result['success'] ? 'YES' : 'NO') . "\n";
echo "Verified: " . ($result['verified'] ? 'YES' : 'NO') . "\n";
echo "Message: " . $result['message'] . "\n";
echo "\n";

// Test Identity Verification
echo "=== Identity Verification ===\n";
$result = $service->verifyIdentity('Aadhaar', '123456789012');
echo "Aadhaar Result: " . $result['message'] . "\n";

$result = $service->verifyIdentity('PAN', 'ABCDE1234F');
echo "PAN Result: " . $result['message'] . "\n";

$result = $service->verifyIdentity('Voter ID', '12345');
echo "Voter ID Result: " . $result['message'] . "\n";
