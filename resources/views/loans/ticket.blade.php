<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawn Ticket - #{{ $loan->ticket_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; background: white; }
            .print-container { border: none; shadow: none; width: 100%; max-width: none; margin: 0; }
        }
        @page { size: A4; margin: 1cm; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <!-- Toolbar -->
    <div class="max-w-4xl mx-auto mb-6 flex justify-between items-center no-print">
        <a href="{{ route('loans.show', $loan) }}" class="flex items-center text-gray-600 hover:text-blue-600 transition-colors">
            <span class="material-icons mr-2">arrow_back</span>
            Back to Loan
        </a>
        <div class="flex space-x-3">
            <a href="{{ route('loans.pawn-ticket', $loan) }}" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all font-medium">
                <span class="material-icons text-sm mr-2">download</span>
                Download PDF
            </a>
            <button onclick="window.print()" class="flex items-center bg-white border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all font-medium text-gray-700">
                <span class="material-icons text-sm mr-2">print</span>
                Print Ticket
            </button>
        </div>
    </div>

    <!-- Ticket Container -->
    <div class="max-w-4xl mx-auto bg-white shadow-xl border border-gray-100 p-12 print-container">
        <!-- Header -->
        <div class="text-center border-b-2 border-gray-900 pb-8 mb-8">
            <h1 class="text-3xl font-black uppercase tracking-tighter text-gray-900">{{ config('app.name', 'Pawn Broker') }}</h1>
            <p class="text-lg font-bold text-gray-600 mt-1 uppercase">Official Pawn Ticket</p>
            <div class="mt-4 flex justify-between items-end">
                <div class="text-left">
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Ticket Number</p>
                    <p class="text-xl font-mono font-black text-blue-600">#{{ $loan->ticket_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">Date Issued</p>
                    <p class="text-lg font-bold text-gray-900">{{ $loan->loan_date->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-12 mb-10">
            <!-- Left: Pawner Information -->
            <div>
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">Pawner (Customer)</h2>
                <div class="space-y-2">
                    <p class="text-xl font-bold text-gray-900">{{ $loan->customer->name }}</p>
                    <p class="text-gray-600 leading-relaxed">{{ $loan->customer->address }}</p>
                    <p class="text-gray-600">{{ $loan->customer->city }}, {{ $loan->customer->state }} - {{ $loan->customer->pincode }}</p>
                    <div class="pt-2">
                        <p class="text-sm"><span class="text-gray-400 font-medium">ID Info:</span> <span class="font-bold">{{ $loan->customer->id_proof_type }} - {{ $loan->customer->id_proof_number }}</span></p>
                        <p class="text-sm"><span class="text-gray-400 font-medium">Mobile:</span> <span class="font-bold">{{ $loan->customer->mobile }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Right: Loan Terms -->
            <div>
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">Loan Terms</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">Interest Rate</span>
                        <span class="font-bold text-gray-900">{{ $loan->interest_rate }}% <span class="text-xs text-gray-400">/Month</span></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">Interest Type</span>
                        <span class="font-bold text-gray-900">{{ $loan->interest_type }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">Loan Period</span>
                        <span class="font-bold text-gray-900">{{ $loan->loan_period_months }} Months</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-dashed border-gray-200">
                        <span class="text-gray-500 font-medium">Maturity Date</span>
                        <span class="font-bold text-red-600">{{ $loan->due_date->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Principal Highlight -->
        <div class="bg-gray-900 text-white rounded-xl p-8 text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-widest opacity-60 mb-2">Total Principal Amount Advanced</p>
            <p class="text-5xl font-black tracking-tighter italic">₹{{ number_format($loan->principal_amount, 2) }}</p>
        </div>

        <!-- Article Section -->
        <div class="mb-12">
            <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">Article / Security Description</h2>
            <div class="min-h-[120px] bg-gray-50 rounded-lg p-6 border border-gray-100 italic text-gray-700 leading-relaxed">
                {{ $loan->notes ?: 'No specific article description provided. This loan is secured against the items listed in the official ledger.' }}
            </div>
        </div>

        <!-- Signatures -->
        <div class="mt-24 grid grid-cols-2 gap-24">
            <div class="text-center">
                <div class="border-t-2 border-gray-900 pt-3">
                    <p class="font-black text-xs uppercase tracking-widest">Signature of Pawner</p>
                    <p class="text-[10px] text-gray-400 mt-1">(I agree to all terms mentioned above)</p>
                </div>
            </div>
            <div class="text-center">
                <div class="border-t-2 border-gray-900 pt-3">
                    <p class="font-black text-xs uppercase tracking-widest">For {{ config('app.name') }}</p>
                    <p class="text-[10px] text-gray-400 mt-1">(Authorized Signatory)</p>
                </div>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="mt-16 pt-6 border-t border-gray-100">
            <p class="text-[10px] text-gray-400 text-center uppercase tracking-widest font-bold">Important Notice</p>
            <p class="text-[9px] text-gray-400 text-center mt-2 px-12 leading-normal">
                This is a legal document. The article described above has been pawned for the loan amount mentioned. 
                Redemption is subject to payment of principal plus interest and any other applicable charges. 
                Failure to repay within the stipulated period may result in public auction of the pawned article.
            </p>
        </div>
    </div>
</body>
</html>
