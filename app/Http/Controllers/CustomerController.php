<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('loans')->latest()->paginate(15);
        
        if (request()->expectsJson()) {
            return response()->json($customers);
        }

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Dynamic validation based on ID proof type
        $idProofType = strtoupper($request->input('id_proof_type', ''));
        $idProofRules = ['required', 'string'];
        
        // Add specific validation rules based on document type
        if ($idProofType === 'AADHAAR' || $idProofType === 'AADHAR') {
            $idProofRules[] = new \App\Rules\ValidAadhaar();
        } elseif ($idProofType === 'PAN') {
            $idProofRules[] = new \App\Rules\ValidPAN();
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'nullable|email',
            'id_proof_type' => 'required|string',
            'id_proof_number' => $idProofRules,
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|string|max:10',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('customers', 'public');
        }

        // Verify ID proof using external API
        $verificationService = new \App\Services\IdentityVerificationService();
        $verificationResult = $verificationService->verifyIdentity(
            $validated['id_proof_type'],
            $validated['id_proof_number']
        );

        // Store verification status
        $validated['id_verified'] = $verificationResult['verified'] ?? false;
        $validated['id_verified_at'] = $verificationResult['verified'] ? now() : null;
        $validated['verification_response'] = json_encode($verificationResult);

        $customer = Customer::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Customer created successfully.',
                'customer' => $customer,
                'verification' => $verificationResult,
            ], 201);
        }

        // Show verification status message
        $message = 'Customer created successfully.';
        if ($verificationResult['verified']) {
            $message .= ' ID proof verified successfully.';
        } elseif (isset($verificationResult['format_valid']) && $verificationResult['format_valid']) {
            $message .= ' ID proof format is valid (API verification not configured).';
        } else {
            $message .= ' Warning: ID proof could not be verified.';
        }

        return redirect()->route('customers.show', $customer)
            ->with('success', $message);
    }

    public function show(Customer $customer)
    {
        $customer->load(['loans.items', 'loans.payments']);
        
        if (request()->expectsJson()) {
            return response()->json($customer);
        }

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'nullable|email',
            'id_proof_type' => 'required|string',
            'id_proof_number' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|string|max:10',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($customer->photo) {
                Storage::disk('public')->delete($customer->photo);
            }
            $validated['photo'] = $request->file('photo')->store('customers', 'public');
        }

        $customer->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Customer updated successfully.',
                'customer' => $customer
            ]);
        }

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->photo) {
            Storage::disk('public')->delete($customer->photo);
        }
        
        $customer->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Customer deleted successfully.']);
        }

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
