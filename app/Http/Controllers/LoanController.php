<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['customer', 'items'])->latest()->paginate(15);
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('loans.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'principal_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'duration_days' => 'required|integer|min:1',
            'loan_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Generate unique loan number
        $validated['loan_number'] = 'LN' . date('Ymd') . str_pad(Loan::count() + 1, 4, '0', STR_PAD_LEFT);
        
        // Calculate due date
        $validated['due_date'] = date('Y-m-d', strtotime($validated['loan_date'] . ' + ' . $validated['duration_days'] . ' days'));
        
        // Calculate total amount
        $interest = ($validated['principal_amount'] * $validated['interest_rate'] * $validated['duration_days']) / (100 * 365);
        $validated['total_amount'] = $validated['principal_amount'] + $interest;

        $loan = Loan::create($validated);

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Loan created successfully.');
    }

    public function show(Loan $loan)
    {
        $loan->load(['customer', 'items', 'payments']);
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $customers = Customer::orderBy('name')->get();
        return view('loans.edit', compact('loan', 'customers'));
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,closed,defaulted',
            'notes' => 'nullable|string',
        ]);

        $loan->update($validated);

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Loan updated successfully.');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();

        return redirect()->route('loans.index')
            ->with('success', 'Loan deleted successfully.');
    }

    public function generatePawnTicket(Loan $loan)
    {
        $loan->load(['customer', 'items']);
        
        $pdf = Pdf::loadView('pdfs.pawn-ticket', compact('loan'));
        
        return $pdf->download('pawn-ticket-' . $loan->loan_number . '.pdf');
    }
}
