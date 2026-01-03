<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pawn Ticket #{{ $loan->ticket_number }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; font-size: 11px; margin: 0; padding: 0; }
        .container { padding: 30px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #000; padding-bottom: 10px; }
        .company-name { font-size: 22px; font-weight: bold; text-transform: uppercase; margin: 0; }
        .ticket-title { font-size: 14px; margin: 5px 0; font-weight: bold; color: #666; }
        
        .info-grid { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-box { width: 50%; vertical-align: top; }
        .section-title { font-size: 9px; font-weight: bold; color: #999; text-transform: uppercase; border-bottom: 1px solid #eee; margin-bottom: 8px; padding-bottom: 2px; display: block; }
        
        .label { color: #888; font-weight: bold; width: 100px; display: inline-block; }
        .value { color: #000; font-weight: bold; }
        
        .item-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .item-table th { background: #f5f5f5; padding: 8px; font-size: 9px; text-transform: uppercase; text-align: left; border-bottom: 2px solid #ddd; }
        .item-table td { padding: 10px 8px; border-bottom: 1px solid #eee; }
        
        .principal-box { background: #f9f9f9; border: 2px solid #333; padding: 15px; text-align: center; margin: 20px 0; }
        .principal-label { font-size: 10px; font-weight: bold; color: #555; text-transform: uppercase; }
        .principal-value { font-size: 24px; font-weight: bold; margin: 5px 0; }
        
        .footer { margin-top: 40px; text-align: center; font-size: 8px; color: #999; }
        .signatures { margin-top: 50px; width: 100%; }
        .sig-box { border-top: 1px solid #000; width: 150px; text-align: center; padding-top: 5px; font-weight: bold; font-size: 9px; }
        
        .status-badge { background: #eee; padding: 2px 6px; border-radius: 4px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($loan->shop && $loan->shop->logo)
                <img src="{{ public_path('storage/' . $loan->shop->logo) }}" alt="Shop Logo" style="max-height: 60px; margin: 0 auto 10px;">
            @endif
            <h1 class="company-name">{{ $loan->shop ? $loan->shop->name : config('app.name', 'Pawn Broker') }}</h1>
            @if($loan->shop && $loan->shop->address)
                <p style="font-size: 10px; color: #666; margin: 3px 0;">{{ $loan->shop->address }}</p>
            @endif
            @if($loan->shop && $loan->shop->mobile)
                <p style="font-size: 10px; color: #666; margin: 3px 0;">Contact: +91 {{ $loan->shop->mobile }}</p>
            @endif
            <p class="ticket-title">OFFICIAL PAWN TICKET</p>
            <table style="width: 100%; margin-top: 10px;">
                <tr>
                    <td style="text-align: left;">No: <strong style="font-size: 14px; color: #000;">{{ $loan->ticket_number }}</strong></td>
                    <td style="text-align: right;">Date: <strong>{{ $loan->loan_date->format('d/m/Y') }}</strong></td>
                </tr>
            </table>
        </div>

        <table class="info-grid">
            <tr>
                <td class="info-box" style="padding-right: 20px;">
                    <span class="section-title">Pawner Information</span>
                    <p style="font-size: 14px; margin: 5px 0;"><strong>{{ $loan->customer->name }}</strong></p>
                    <p style="margin: 3px 0; color: #555;">{{ $loan->customer->address }}</p>
                    <p style="margin: 3px 0; color: #555;">{{ $loan->customer->city }}, {{ $loan->customer->state }} - {{ $loan->customer->pincode }}</p>
                    <p style="margin: 8px 0 0 0;"><span style="color: #999;">ID:</span> {{ $loan->customer->id_proof_type }} - {{ $loan->customer->id_proof_number }}</p>
                    <p style="margin: 3px 0;"><span style="color: #999;">Mob:</span> +91 {{ $loan->customer->mobile }}</p>
                </td>
                <td class="info-box">
                    <span class="section-title">Loan Terms</span>
                    <table style="width: 100%;">
                        <tr><td class="label">Int. Rate:</td><td class="value">{{ (float)$loan->interest_rate }}% / Mo</td></tr>
                        <tr><td class="label">Int. Type:</td><td class="value">{{ $loan->interest_type }}</td></tr>
                        <tr><td class="label">Period:</td><td class="value">{{ $loan->loan_period_months }} Months</td></tr>
                        <tr><td class="label">Due Date:</td><td class="value" style="color: #c00;">{{ $loan->due_date->format('d/m/Y') }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <span class="section-title">Article Description & Valuation</span>
        <table class="item-table">
            <thead>
                <tr>
                    <th>Description of Article</th>
                    <th>Purity</th>
                    <th>Weight</th>
                    <th style="text-align: right;">Market Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loan->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->item_name }}</strong><br>
                        <span style="font-size: 9px; color: #777;">{{ $item->description }}</span>
                    </td>
                    <td>{{ $item->purity }}</td>
                    <td>
                        {{ $item->formatted_weight }}<br>
                        <span style="font-size: 8px; color: #999;">({{ number_format($item->weight, 3) }} gms)</span>
                    </td>
                    <td style="text-align: right;">₹{{ number_format($item->weight * $loan->market_rate, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; padding-top: 10px; font-weight: bold; color: #666;">Total Valuation:</td>
                    <td style="text-align: right; padding-top: 10px; font-weight: bold;">₹{{ number_format($loan->valuation_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="principal-box">
            <span class="principal-label">Principal Amount Advanced (80% LTV)</span>
            <p class="principal-value">₹{{ number_format($loan->principal_amount, 2) }}</p>
            <p style="font-size: 9px; color: #666; margin: 0;">Market Rate Applied: ₹{{ number_format($loan->market_rate, 2) }} / gram</p>
        </div>

        <table class="signatures">
            <tr>
                <td width="50%">
                    <div class="sig-box">Signature of Pawner</div>
                </td>
                <td width="50%" align="right">
                    <div class="sig-box" style="margin-left: auto;">For {{ $loan->shop ? $loan->shop->name : config('app.name') }}</div>
                </td>
            </tr>
        </table>

        <div class="footer">
            <p><strong>Note:</strong> This is a legal document. Redemption is subject to principal and interest payments as per state laws. This ticket must be produced for redemption.</p>
            <p>Generated on: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
