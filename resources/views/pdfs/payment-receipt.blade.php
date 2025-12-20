<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt #{{ $payment->receipt_number }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #22c55e; padding-bottom: 10px; }
        .company-name { font-size: 24px; font-bold; text-transform: uppercase; margin: 0; }
        .receipt-title { font-size: 18px; color: #16a34a; margin: 5px 0; }
        .section { margin-bottom: 25px; }
        .grid { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .grid td { padding: 8px 0; border-bottom: 1px solid #f3f4f6; }
        .label { color: #6b7280; width: 150px; }
        .value { font-weight: bold; text-align: right; }
        .amount-highlight { background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 20px; text-align: center; margin: 20px 0; border-radius: 8px; }
        .amount-label { color: #16a34a; font-size: 12px; font-weight: bold; text-transform: uppercase; margin: 0; }
        .amount-value { font-size: 28px; font-weight: bold; color: #16a34a; margin: 5px 0; }
        .footer { margin-top: 60px; text-align: center; font-size: 11px; color: #9ca3af; border-top: 1px solid #eee; padding-top: 20px; }
        .signature-box { margin-top: 40px; text-align: right; }
        .info-box { font-size: 12px; background: #f9fafb; padding: 10px; border-radius: 4px; color: #4b5563; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="company-name">{{ config('app.name', 'Pawn Broker') }}</h1>
        <p class="receipt-title">PAYMENT RECEIPT</p>
        <p>No: <strong>{{ $payment->receipt_number }}</strong> | Date: <strong>{{ $payment->payment_date->format('d/m/Y') }}</strong></p>
    </div>

    <div class="amount-highlight">
        <p class="amount-label">Amount Received</p>
        <p class="amount-value">₹{{ number_format($payment->amount, 2) }}</p>
    </div>

    <div class="section">
        <table class="grid">
            <tr>
                <td class="label">Customer Name:</td>
                <td class="value">{{ $payment->loan->customer->name }}</td>
            </tr>
            <tr>
                <td class="label">Against Loan Ticket:</td>
                <td class="value">#{{ $payment->loan->ticket_number }}</td>
            </tr>
            <tr>
                <td class="label">Payment Type:</td>
                <td class="value">{{ strtoupper(str_replace('_', ' ', $payment->payment_type)) }}</td>
            </tr>
            <tr>
                <td class="label">Payment Method:</td>
                <td class="value">{{ $payment->payment_method }}</td>
            </tr>
            @if($payment->transaction_id)
            <tr>
                <td class="label">Transaction ID:</td>
                <td class="value">{{ $payment->transaction_id }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="info-box">
        <strong>Loan Balance Summary:</strong><br>
        Outstanding balance after this payment: ₹{{ number_format($payment->loan->outstanding_principal, 2) }}
    </div>

    @if($payment->notes)
    <div class="section" style="margin-top: 20px;">
        <p class="label" style="font-size: 12px; margin-bottom: 5px;">REMARKS:</p>
        <p style="font-style: italic; font-size: 13px;">{{ $payment->notes }}</p>
    </div>
    @endif

    <div class="signature-box">
        <p style="margin-bottom: 40px;">Authorized Signatory</p>
        <div style="border-top: 1px solid #333; width: 200px; display: inline-block;"></div>
    </div>

    <div class="footer">
        <p>This is a computer generated receipt and does not require a physical signature.</p>
        <p>Generated on: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
