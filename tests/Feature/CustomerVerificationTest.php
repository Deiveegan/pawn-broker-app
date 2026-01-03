<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Services\IdentityVerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerVerificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_aadhaar_format()
    {
        $service = new IdentityVerificationService();
        
        // Valid Aadhaar formats
        $this->assertTrue($service->isValidAadhaarFormat('123456789012'));
        $this->assertTrue($service->isValidAadhaarFormat('1234 5678 9012'));
        $this->assertTrue($service->isValidAadhaarFormat('1234-5678-9012'));
        
        // Invalid Aadhaar formats
        $this->assertFalse($service->isValidAadhaarFormat('12345678901')); // 11 digits
        $this->assertFalse($service->isValidAadhaarFormat('1234567890123')); // 13 digits
        $this->assertFalse($service->isValidAadhaarFormat('ABCD12345678')); // Contains letters
    }

    /** @test */
    public function it_validates_pan_format()
    {
        $service = new IdentityVerificationService();
        
        // Valid PAN formats
        $this->assertTrue($service->isValidPANFormat('ABCDE1234F'));
        $this->assertTrue($service->isValidPANFormat('abcde1234f')); // Case insensitive
        
        // Invalid PAN formats
        $this->assertFalse($service->isValidPANFormat('ABCD1234F')); // Only 4 letters
        $this->assertFalse($service->isValidPANFormat('ABCDE12345')); // 5 digits
        $this->assertFalse($service->isValidPANFormat('12345ABCDE')); // Wrong order
    }

    /** @test */
    public function it_rejects_invalid_aadhaar_during_customer_creation()
    {
        $response = $this->postJson('/api/customers', [
            'name' => 'Test Customer',
            'mobile' => '9876543210',
            'id_proof_type' => 'Aadhaar',
            'id_proof_number' => '12345', // Invalid - only 5 digits
            'address' => '123 Test St',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('id_proof_number');
    }

    /** @test */
    public function it_rejects_invalid_pan_during_customer_creation()
    {
        $response = $this->postJson('/api/customers', [
            'name' => 'Test Customer',
            'mobile' => '9876543210',
            'id_proof_type' => 'PAN',
            'id_proof_number' => 'INVALID123', // Invalid format
            'address' => '123 Test St',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('id_proof_number');
    }

    /** @test */
    public function it_accepts_valid_aadhaar_format()
    {
        $response = $this->postJson('/api/customers', [
            'name' => 'Test Customer',
            'mobile' => '9876543210',
            'id_proof_type' => 'Aadhaar',
            'id_proof_number' => '123456789012', // Valid format
            'address' => '123 Test St',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('customers', [
            'name' => 'Test Customer',
            'id_proof_type' => 'Aadhaar',
            'id_proof_number' => '123456789012',
        ]);
    }

    /** @test */
    public function it_accepts_valid_pan_format()
    {
        $response = $this->postJson('/api/customers', [
            'name' => 'Test Customer',
            'mobile' => '9876543210',
            'id_proof_type' => 'PAN',
            'id_proof_number' => 'ABCDE1234F', // Valid format
            'address' => '123 Test St',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('customers', [
            'name' => 'Test Customer',
            'id_proof_type' => 'PAN',
            'id_proof_number' => 'ABCDE1234F',
        ]);
    }

    /** @test */
    public function it_stores_verification_status_in_database()
    {
        $this->postJson('/api/customers', [
            'name' => 'Test Customer',
            'mobile' => '9876543210',
            'id_proof_type' => 'Aadhaar',
            'id_proof_number' => '123456789012',
            'address' => '123 Test St',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
        ]);

        $customer = Customer::where('name', 'Test Customer')->first();
        
        // Verification status should be stored
        $this->assertNotNull($customer->verification_response);
        
        // Decode verification response
        $verificationData = json_decode($customer->verification_response, true);
        $this->assertArrayHasKey('success', $verificationData);
        $this->assertArrayHasKey('message', $verificationData);
    }
}
