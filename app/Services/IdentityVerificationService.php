<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IdentityVerificationService
{
    /**
     * Verify Aadhaar number using Surepass API
     * You need to sign up at https://surepass.io/ and get an API token
     * Add SUREPASS_API_TOKEN to your .env file
     */
    public function verifyAadhaar(string $aadhaarNumber): array
    {
        // Validate Aadhaar format first
        if (!$this->isValidAadhaarFormat($aadhaarNumber)) {
            return [
                'success' => false,
                'message' => 'Invalid Aadhaar number format. Must be 12 digits.',
                'verified' => false,
            ];
        }

        // Check if API token is configured
        $apiToken = config('services.surepass.token');
        if (!$apiToken) {
            Log::warning('Surepass API token not configured. Skipping Aadhaar verification.');
            return [
                'success' => true,
                'message' => 'Aadhaar format is valid. API verification skipped (no token configured).',
                'verified' => false,
                'format_valid' => true,
            ];
        }

        try {
            // Call Surepass Aadhaar Verification API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
                'Content-Type' => 'application/json',
            ])->post('https://kyc-api.surepass.io/api/v1/aadhaar-validation/aadhaar-validation', [
                'id_number' => $aadhaarNumber,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'verified' => $data['data']['is_valid'] ?? false,
                    'message' => $data['data']['is_valid'] ? 'Aadhaar verified successfully.' : 'Aadhaar verification failed.',
                    'data' => $data['data'] ?? null,
                ];
            }

            return [
                'success' => false,
                'verified' => false,
                'message' => 'Aadhaar verification API error: ' . $response->body(),
            ];

        } catch (\Exception $e) {
            Log::error('Aadhaar verification failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'verified' => false,
                'message' => 'Aadhaar verification service unavailable.',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify PAN number using Surepass API
     */
    public function verifyPAN(string $panNumber): array
    {
        // Validate PAN format first
        if (!$this->isValidPANFormat($panNumber)) {
            return [
                'success' => false,
                'message' => 'Invalid PAN format. Must be in format: ABCDE1234F',
                'verified' => false,
            ];
        }

        // Check if API token is configured
        $apiToken = config('services.surepass.token');
        if (!$apiToken) {
            Log::warning('Surepass API token not configured. Skipping PAN verification.');
            return [
                'success' => true,
                'message' => 'PAN format is valid. API verification skipped (no token configured).',
                'verified' => false,
                'format_valid' => true,
            ];
        }

        try {
            // Call Surepass PAN Verification API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
                'Content-Type' => 'application/json',
            ])->post('https://kyc-api.surepass.io/api/v1/pan/pan', [
                'id_number' => strtoupper($panNumber),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'verified' => $data['data']['is_valid'] ?? false,
                    'message' => $data['data']['is_valid'] ? 'PAN verified successfully.' : 'PAN verification failed.',
                    'data' => $data['data'] ?? null,
                ];
            }

            return [
                'success' => false,
                'verified' => false,
                'message' => 'PAN verification API error: ' . $response->body(),
            ];

        } catch (\Exception $e) {
            Log::error('PAN verification failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'verified' => false,
                'message' => 'PAN verification service unavailable.',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Validate Aadhaar number format (12 digits)
     */
    public function isValidAadhaarFormat(string $aadhaar): bool
    {
        // Remove spaces and hyphens
        $aadhaar = preg_replace('/[\s\-]/', '', $aadhaar);
        
        // Check if it's exactly 12 digits
        return preg_match('/^[0-9]{12}$/', $aadhaar) === 1;
    }

    /**
     * Validate PAN format (5 letters, 4 digits, 1 letter)
     * Format: ABCDE1234F
     */
    public function isValidPANFormat(string $pan): bool
    {
        // PAN format: 5 letters, 4 digits, 1 letter
        return preg_match('/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', strtoupper($pan)) === 1;
    }

    /**
     * Verify identity based on document type
     */
    public function verifyIdentity(string $documentType, string $documentNumber): array
    {
        $documentType = strtoupper($documentType);

        switch ($documentType) {
            case 'AADHAAR':
            case 'AADHAR':
                return $this->verifyAadhaar($documentNumber);
            
            case 'PAN':
                return $this->verifyPAN($documentNumber);
            
            default:
                return [
                    'success' => true,
                    'verified' => false,
                    'message' => 'Document type "' . $documentType . '" does not support automatic verification.',
                ];
        }
    }
}
