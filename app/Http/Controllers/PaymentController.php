<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Loan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('loan.customer')->latest()->paginate(15);
        
        if (request()->expectsJson()) {
            return response()->json($payments);
        }

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        // Use 'Active' instead of 'active' to match the database values
        $loans = Loan::whereIn('status', ['Active', 'active'])->with('customer')->get();
        return view('payments.create', compact('loans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_type' => 'required|in:interest,principal,full_settlement',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Generate unique receipt number
        $validated['receipt_number'] = 'RCP' . date('Ymd') . str_pad(Payment::count() + 1, 4, '0', STR_PAD_LEFT);

        $payment = Payment::create($validated);

        // Update loan status if full settlement
        if ($validated['payment_type'] === 'full_settlement') {
            $payment->loan->update(['status' => 'Closed']);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Payment recorded successfully.',
                'payment' => $payment
            ], 201);
        }

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load('loan.customer');
        
        if (request()->expectsJson()) {
            return response()->json($payment);
        }

        return view('payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Payment deleted successfully.']);
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    public function generateReceipt(Payment $payment)
    {
        $payment->load('loan.customer');
        
        $pdf = Pdf::loadView('pdfs.payment-receipt', compact('payment'));
        
        return $pdf->download('receipt-' . $payment->receipt_number . '.pdf');
    }
}
