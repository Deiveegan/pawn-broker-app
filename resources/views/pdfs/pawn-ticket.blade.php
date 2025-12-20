<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pawn Ticket #{{ $loan->ticket_number }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .company-name { font-size: 24px; font-bold; text-transform: uppercase; margin: 0; }
        .ticket-title { font-size: 18px; margin: 5px 0; }
        .section { margin-bottom: 20px; }
        .section-title { font-weight: bold; text-decoration: underline; margin-bottom: 10px; display: block; }
        .grid { width: 100%; border-collapse: collapse; }
        .grid td { padding: 5px 0; vertical-align: top; }
        .label { color: #666; width: 150px; }
        .value { font-weight: bold; }
        .amount-box { border: 2px solid #333; padding: 15px; text-align: center; margin: 20px 0; }
        .amount-value { font-size: 20px; font-weight: bold; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
        .signature-section { margin-top: 60px; }
        .signature-box { border-top: 1px solid #333; width: 200px; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="company-name">{{ config('app.name', 'Pawn Broker') }}</h1>
        <p class="ticket-title">OFFICIAL PAWN TICKET</p>
        <p>No: <strong>{{ $loan->ticket_number }}</strong> | Date: <strong>{{ $loan->loan_date->format('d/m/Y') }}</strong></p>
    </div>

    <div class="section">
        <span class="section-title">CUSTOMER INFORMATION</span>
        <table class="grid">
            <tr>
                <td class="label">Name:</td>
                <td class="value">{{ $loan->customer->name }}</td>
            </tr>
            <tr>
                <td class="label">Address:</td>
                <td class="value">{{ $loan->customer->address }}<br>{{ $loan->customer->city }}, {{ $loan->customer->state }} - {{ $loan->customer->pincode }}</td>
            </tr>
            <tr>
                <td class="label">ID Proof:</td>
                <td class="value">{{ $loan->customer->id_proof_type }} - {{ $loan->customer->id_proof_number }}</td>
            </tr>
            <tr>
                <td class="label">Mobile:</td>
                <td class="value">{{ $loan->customer->mobile }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <span class="section-title">LOAN DETAILS</span>
        <table class="grid">
            <tr>
                <td class="label">Interest Rate:</td>
                <td class="value">{{ $loan->interest_rate }}% per month ({{ $loan->interest_type }})</td>
            </tr>
            <tr>
                <td class="label">Period:</td>
                <td class="value">{{ $loan->loan_period_months }} Months</td>
            </tr>
            <tr>
                <td class="label">Maturity Date:</td>
                <td class="value">{{ $loan->due_date->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <div class="amount-box">
        <p class="label" style="margin: 0;">PRINCIPAL AMOUNT</p>
        <p class="amount-value">₹{{ number_format($loan->principal_amount, 2) }}</p>
    </div>

    <div class="section">
        <span class="section-title">ARTICLE DESCRIPTION</span>
        <p class="value">{{ $loan->notes ?: 'No description provided.' }}</p>
    </div>

    <div class="signature-section">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="signature-box">Pawner's Signature</div>
                </td>
                <td style="text-align: right;">
                    <div class="signature-box" style="margin-left: auto;">For {{ config('app.name') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Terms and conditions apply. This ticket must be produced at the time of redemption.</p>
        <p>Generated on: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
