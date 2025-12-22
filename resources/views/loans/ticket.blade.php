<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawn Ticket - #{{ $loan->ticket_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap');
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; background: white; }
            .print-container { border: none; shadow: none; width: 100%; max-width: none; margin: 0; padding: 0; }
        }
        @page { size: A4; margin: 1cm; }
        .font-mono { font-family: 'Roboto Mono', monospace; }
        .font-black { font-weight: 900; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <!-- Toolbar -->
    <div class="max-w-4xl mx-auto mb-6 flex justify-between items-center no-print px-4">
        <a href="{{ route('loans.show', $loan) }}" class="flex items-center text-gray-600 hover:text-blue-600 transition-colors font-bold uppercase text-xs tracking-widest">
            <span class="material-icons mr-2 text-sm">arrow_back</span>
            Back to Loan
        </a>
        <div class="flex space-x-3">
            <a href="{{ route('loans.pawn-ticket', $loan) }}" class="flex items-center bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition-all font-black text-xs uppercase tracking-widest shadow-lg shadow-blue-200">
                <span class="material-icons text-sm mr-2">download</span>
                Download PDF
            </a>
            <button onclick="window.print()" class="flex items-center bg-white border-2 border-gray-200 px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-all font-black text-xs uppercase tracking-widest text-gray-700">
                <span class="material-icons text-sm mr-2">print</span>
                Print Ticket
            </button>
        </div>
    </div>

    <!-- Ticket Container -->
    <div class="max-w-4xl mx-auto bg-white shadow-2xl border border-gray-100 p-12 print-container relative overflow-hidden">
        <!-- Watermark/Background Decoration -->
        <div class="absolute top-0 right-0 p-12 opacity-[0.03] pointer-events-none">
            <span class="material-icons text-[300px]">verified_user</span>
        </div>

        <!-- Header -->
        <div class="text-center border-b-4 border-gray-900 pb-10 mb-10">
            <h1 class="text-4xl font-black uppercase tracking-tighter text-gray-900 leading-none">{{ config('app.name', 'Pawn Broker') }}</h1>
            <p class="text-xs font-black text-gray-400 mt-2 uppercase tracking-[0.3em]">Licensed Pawn Broker & Money Lender</p>
            
            <div class="mt-8 flex justify-between items-end bg-gray-50 p-6 rounded-2xl">
                <div class="text-left">
                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest leading-none mb-1">Pawn Ticket Number</p>
                    <p class="text-3xl font-mono font-black text-blue-600 tracking-tighter">{{ $loan->ticket_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest leading-none mb-1">Date of Issue</p>
                    <p class="text-xl font-black text-gray-900 uppercase italic">{{ $loan->loan_date->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-16 mb-12">
            <!-- Left: Pawner Information -->
            <div>
                <h2 class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                    Pawner (Customer)
                </h2>
                <div class="space-y-3">
                    <p class="text-2xl font-black text-gray-900 leading-tight uppercase">{{ $loan->customer->name }}</p>
                    <div class="text-gray-600 text-sm leading-relaxed space-y-1 bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                        <p class="font-bold">{{ $loan->customer->address }}</p>
                        <p>{{ $loan->customer->city }}, {{ $loan->customer->state }} - {{ $loan->customer->pincode }}</p>
                        <div class="pt-2 mt-2 border-t border-gray-200/50 flex flex-col space-y-1">
                            <p class="text-xs bg-white self-start px-2 py-0.5 rounded border border-gray-200">
                                <span class="text-gray-400 font-bold uppercase tracking-tighter mr-1">ID:</span> 
                                <span class="font-black text-gray-900">{{ $loan->customer->id_proof_type }} - {{ $loan->customer->id_proof_number }}</span>
                            </p>
                            <p class="text-xs bg-white self-start px-2 py-0.5 rounded border border-gray-200">
                                <span class="text-gray-400 font-bold uppercase tracking-tighter mr-1">Mobile:</span> 
                                <span class="font-black text-gray-900">+91 {{ $loan->customer->mobile }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Loan Terms -->
            <div>
                <h2 class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                    Loan Terms & Schedule
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-bold uppercase tracking-tighter">Interest Rate</span>
                        <span class="font-black text-gray-900 text-lg">{{ (float)$loan->interest_rate }}% <span class="text-[10px] text-gray-400 uppercase">per month</span></span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-bold uppercase tracking-tighter">Interest Type</span>
                        <span class="font-black text-gray-900 uppercase italic bg-gray-100 px-2 py-0.5 rounded text-xs">{{ $loan->interest_type }} Balance</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-bold uppercase tracking-tighter">Duration</span>
                        <span class="font-black text-gray-900">{{ $loan->loan_period_months }} Months</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t-2 border-dashed border-gray-100">
                        <span class="text-gray-500 font-bold uppercase tracking-tighter">Maturity Date</span>
                        <span class="font-black text-red-600 text-lg uppercase italic">{{ $loan->due_date->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Valuation Section -->
        <div class="mb-12">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-900 text-white rounded-t-xl overflow-hidden">
                        <th class="py-4 px-6 text-[10px] font-black uppercase tracking-widest rounded-tl-xl">Item Description</th>
                        <th class="py-4 px-6 text-[10px] font-black uppercase tracking-widest">Weight (gms)</th>
                        <th class="py-4 px-6 text-[10px] font-black uppercase tracking-widest">Purity</th>
                        <th class="py-4 px-6 text-[10px] font-black uppercase tracking-widest rounded-tr-xl text-right">Value (Market)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 border-x border-b border-gray-100">
                    @foreach($loan->items as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-5 px-6">
                                <p class="font-black text-gray-900 uppercase text-sm">{{ $item->item_name }}</p>
                                <p class="text-xs text-gray-500 italic mt-1">{{ $item->description }}</p>
                            </td>
                            <td class="py-5 px-6">
                                <p class="font-black text-gray-900 text-sm">{{ $item->formatted_weight }}</p>
                                <p class="text-[10px] text-gray-400 font-bold italic">{{ number_format($item->weight, 3) }} gms</p>
                            </td>
                            <td class="py-5 px-6">
                                <span class="bg-white border border-gray-200 px-2 py-1 rounded-lg text-[10px] font-black text-blue-600 uppercase">{{ $item->purity }}</span>
                            </td>
                            <td class="py-5 px-6 text-right">
                                <p class="font-black text-gray-400 text-xs">₹{{ number_format($item->weight * $loan->market_rate, 2) }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50/50 border-x border-b border-gray-100">
                        <td class="py-4 px-6 font-black text-gray-400 text-[10px] uppercase tracking-widest text-right" colspan="3">Total Market Valuation:</td>
                        <td class="py-4 px-6 text-right font-black text-gray-900">₹{{ number_format($loan->valuation_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Principal Highlight -->
        <div class="bg-blue-600 text-white rounded-2xl p-8 text-center mb-12 shadow-xl shadow-blue-100 flex items-center justify-between relative overflow-hidden">
            <div class="absolute left-0 top-0 h-full w-2 bg-blue-700 opacity-50"></div>
            <div class="text-left relative z-10">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-1">Principal Amount Advanced</p>
                <div class="flex items-baseline">
                    <span class="text-lg font-bold mr-1 opacity-70 italic">₹</span>
                    <span class="text-5xl font-black font-mono tracking-tighter italic">{{ number_format($loan->principal_amount, 2) }}</span>
                </div>
            </div>
            <div class="text-right relative z-10 hidden md:block">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-1">Loan-to-Value (LTV)</p>
                <p class="text-3xl font-black italic">80.0<span class="text-sm opacity-70 mt-1">%</span></p>
            </div>
        </div>

        <!-- Signatures -->
        <div class="mt-24 grid grid-cols-2 gap-32">
            <div class="text-center group">
                <div class="border-t-2 border-gray-900 pt-4 px-4">
                    <p class="font-black text-[10px] uppercase tracking-widest text-gray-900">Signature of Pawner</p>
                    <p class="text-[9px] text-gray-400 mt-2 italic">(Pawner marks here)</p>
                </div>
            </div>
            <div class="text-center group">
                <div class="border-t-2 border-gray-900 pt-4 px-4 bg-gray-50/50">
                    <p class="font-black text-[10px] uppercase tracking-widest text-gray-900">For {{ config('app.name') }}</p>
                    <p class="text-[9px] text-gray-400 mt-2 italic font-bold">Authorized Signatory</p>
                </div>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="mt-20 pt-8 border-t border-gray-100">
            <div class="flex justify-center mb-4">
                <span class="bg-gray-100 text-gray-400 px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest">Legal Notice</span>
            </div>
            <p class="text-[9px] text-gray-400 text-center px-16 leading-relaxed italic">
                The article(s) described above have been pawned for the loan amount mentioned. 
                Redemption is subject to payment of principal plus interest and any other applicable charges as per state money lending laws. 
                This ticket must be surrendered during redemption. If not redeemed within the stipulated period, the broker may auction the article(s) after giving due notice.
            </p>
            <p class="text-center mt-6 text-[8px] text-gray-300 font-mono tracking-tighter">Generated by {{ config('app.name') }} Digital Ledger | Timestamp: {{ now()->toDateTimeString() }}</p>
        </div>
    </div>
</body>
</html>
