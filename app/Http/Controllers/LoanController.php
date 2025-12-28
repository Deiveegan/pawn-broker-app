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
        
        if (request()->expectsJson()) {
            return response()->json($loans);
        }

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
            'loan_type' => 'required|string|in:Gold,Silver,Electronics,Others',
            'principal_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'interest_type' => 'required|string|in:Flat,Reducing',
            'loan_period_months' => 'required|integer|min:1',
            'loan_date' => 'required|date',
            'grace_period_days' => 'nullable|integer|min:0',
            'penalty_rate' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'valuation_amount' => 'nullable|numeric',
            'total_weight' => 'nullable|numeric',
            'market_rate' => 'nullable|numeric',
            // Multiple Item Details
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.description' => 'required|string',
            'items.*.weight' => 'nullable|numeric|min:0',
            'items.*.purity' => 'nullable|string',
        ]);

        // Map remarks to notes
        $validated['notes'] = $request->remarks;
        unset($validated['remarks']);

        // Calculate duration days (approx 30 days per month)
        $validated['duration_days'] = $validated['loan_period_months'] * 30;

        // Generate type-specific loan number
        $prefixMap = [
            'Gold' => 'GLN',
            'Silver' => 'SLN',
            'Electronics' => 'ELN',
            'Others' => 'PLN'
        ];
        $prefix = $prefixMap[$validated['loan_type']] ?? 'LN';
        
        $todayCount = Loan::whereDate('created_at', today())->count() + 1;
        $validated['loan_number'] = $prefix . date('Ymd') . str_pad($todayCount, 4, '0', STR_PAD_LEFT);
        
        // Calculate due date
        $loanDate = \Carbon\Carbon::parse($validated['loan_date']);
        $validated['due_date'] = $loanDate->copy()->addMonths((int)$validated['loan_period_months']);
        
        // Calculate total amount (Simple flat interest for now as per conventional pawn shops)
        $interest = ($validated['principal_amount'] * ($validated['interest_rate'] / 100)) * $validated['loan_period_months'];
        $validated['total_amount'] = $validated['principal_amount'] + $interest;

        $loan = Loan::create($validated);

        // Create the items
        foreach ($request->items as $itemData) {
            $itemName = $itemData['item_name'];
            if ($itemName === 'Others' && !empty($itemData['custom_item_name'])) {
                $itemName = $itemData['custom_item_name'];
            }

            $loan->items()->create([
                'category' => $request->loan_type,
                'item_name' => $itemName,
                'description' => $itemData['description'],
                'weight' => $itemData['weight'],
                'purity' => $itemData['purity'],
                'estimated_value' => $request->principal_amount / count($request->items), // Split estimated value among items
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Loan created successfully.',
                'loan' => $loan->load('items')
            ], 201);
        }

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Loan created successfully.');
    }

    public function show(Loan $loan)
    {
        $loan->load(['customer', 'items', 'payments']);
        
        if (request()->expectsJson()) {
            return response()->json($loan);
        }

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
            'loan_type' => 'required|string|in:Gold,Silver,Electronics,Others',
            'interest_rate' => 'required|numeric',
            'interest_type' => 'required|string',
            'loan_period_months' => 'required|integer|min:1',
            'loan_date' => 'required|date',
            'penalty_rate' => 'nullable|numeric',
            'status' => 'required|in:Active,Closed,Overdue,Auctioned',
            'remarks' => 'nullable|string',
            // Item Details
            'item_description' => 'required|string',
            'item_weight' => 'nullable|numeric|min:0',
            'item_purity' => 'nullable|string',
        ]);

        // Map remarks to notes
        $validated['notes'] = $validated['remarks'];
        unset($validated['remarks']);

        // Recalculate duration and due date
        $loanDate = \Carbon\Carbon::parse($validated['loan_date']);
        $validated['duration_days'] = $validated['loan_period_months'] * 30;
        $validated['due_date'] = $loanDate->copy()->addMonths((int)$validated['loan_period_months']);

        // Recalculate total amount (re-using store logic)
        $principal = $loan->principal_amount;
        $interestRate = $validated['interest_rate'];
        $months = $validated['loan_period_months'];

        if ($validated['interest_type'] === 'Flat') {
            $totalInterest = ($principal * $interestRate / 100) * $months;
            $validated['total_amount'] = $principal + $totalInterest;
        } else {
            // Simple reducing calculation for now (or keep same as principal if monthly interest)
            $validated['total_amount'] = $principal; 
        }

        $loan->update($validated);

        // Update the first item or create if not exists
        $item = $loan->items->first();
        if ($item) {
            $item->update([
                'category' => $request->loan_type,
                'description' => $request->item_description,
                'weight' => $request->item_weight,
                'purity' => $request->item_purity,
            ]);
        } else {
            $loan->items()->create([
                'category' => $request->loan_type,
                'item_name' => $request->loan_type . ' Item',
                'description' => $request->item_description,
                'weight' => $request->item_weight,
                'purity' => $request->item_purity,
                'estimated_value' => $loan->principal_amount,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Loan updated successfully.',
                'loan' => $loan->load('items')
            ]);
        }

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Loan updated successfully.');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Loan deleted successfully.']);
        }

        return redirect()->route('loans.index')
            ->with('success', 'Loan deleted successfully.');
    }

    public function ticket(Loan $loan)
    {
        $loan->load(['customer', 'items']);
        return view('loans.ticket', compact('loan'));
    }

    public function generatePawnTicket(Loan $loan)
    {
        $loan->load(['customer', 'items']);
        
        $pdf = Pdf::loadView('pdfs.pawn-ticket', compact('loan'));
        
        return $pdf->download('pawn-ticket-' . $loan->loan_number . '.pdf');
    }
}
