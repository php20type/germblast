<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoiceDetails['invoice_no'] ?? '' }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            margin-bottom: 30px;
        }
        .logo {
            max-height: 60px;
            float: left;
        }
        .invoice-title {
            text-align: right;
            margin-top: 0;
        }
        .invoice-details {
            text-align: right;
            font-size: 12px;
        }
        .clear {
            clear: both;
        }
        .addresses {
            margin-bottom: 30px;
        }
        .address-box {
            width: 48%;
            float: left;
        }
        .address-box.right {
            float: right;
        }
        .address-title {
            font-weight: bold;
            color: #555;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.items-table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
        }
        table.items-table td {
            border-bottom: 1px solid #dee2e6;
            padding: 8px;
            font-size: 13px;
        }
        table.items-table .text-right {
            text-align: right;
        }
        table.items-table .text-center {
            text-align: center;
        }
        .total-box {
            float: right;
            width: 40%;
            text-align: right;
            font-size: 14px;
        }
        .total-row {
            margin-bottom: 5px;
        }
        .total-amount {
            font-size: 18px;
            font-weight: bold;
            color: #dc3545;
        }
        .notes-box {
            margin-top: 50px;
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #ffb81c;
            border-radius: 4px;
        }
        .notes-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 13px;
        }
        .notes-content {
            font-size: 12px;
            color: #555;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #777;    
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="float: left;">
            {{-- DomPDF needs full local path or base64 or public path for images --}}
            @if(file_exists(public_path('img/logo/logo.png')))
                <img src="{{ public_path('img/logo/logo.png') }}" class="logo" alt="GermBlast">
            @endif
        </div>
        <div style="float: right;" class="invoice-details">
            <h2 class="invoice-title" style="color: #0d6efd; margin-bottom: 5px;">INVOICE</h2>
            <div><strong>Invoice Number:</strong> {{ $invoiceDetails['invoice_no'] ?? '' }}</div>
            @if(!empty($invoiceDetails['invoice_type']))
            <div><strong>Invoice Type:</strong> {{ $invoiceDetails['invoice_type'] }}</div>
            @endif
            <div><strong>Order Number:</strong> {{ $order->order_no ?? 'N/A' }}</div>
            <div><strong>Invoice Date:</strong> {{ \Carbon\Carbon::parse($invoiceDetails['invoice_date'] ?? date('Y-m-d'))->format('M d, Y') }}</div>
            <div><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoiceDetails['due_date'] ?? date('Y-m-d'))->format('M d, Y') }}</div>

        </div>
        <div class="clear"></div>
    </div>

    <div class="addresses" style="margin-top: 20px;">
        <div class="address-box">
            <div class="address-title">Service Provider</div>
            <div><strong>Infection Controls, Inc.</strong></div>
            <div>1414 Avenue J</div>
            <div>Lubbock, TX 79401</div>
            <div>Phone: 877.771.3558</div>
        </div>
        <div class="address-box right">
            <div class="address-title">Customer</div>
            <div><strong>{{ $order->service->lead->company->name ?? 'N/A' }}</strong></div>
            @if ($order->service->lead->company && $order->service->lead->company->companyAddress)
                <div>{{ $order->service->lead->company->companyAddress->address }}</div>
                @if ($order->service->lead->company->companyAddress->mailing_address)
                    <div>{{ $order->service->lead->company->companyAddress->mailing_address }}</div>
                @endif
            @endif
            @if ($order->service->lead->company && $order->service->lead->company->companyPhone)
                <div>Phone: {{ $order->service->lead->company->companyPhone->phone }}</div>
            @endif
            @if ($order->service->lead->company && $order->service->lead->company->companyEmail)
                <div>Email: {{ $order->service->lead->company->companyEmail->email }}</div>
            @endif
        </div>
        <div class="clear"></div>
    </div>

    <table class="items-table" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Item Description</th>
                <th class="text-center" style="width: 80px;">Qty</th>
                <th class="text-right" style="width: 100px;">Price</th>
                <th class="text-right" style="width: 120px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach(($invoiceDetails['items'] ?? []) as $item)
                <tr>
                    <td>{{ $item['type'] }}</td>
                    <td class="text-center">{{ $item['qty'] }}</td>
                    <td class="text-right">${{ number_format($item['price'], 2) }}</td>
                    <td class="text-right" style="font-weight: bold;">${{ number_format($item['total'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="width: 100%;">
        <div class="total-box">
            <div class="total-row">
                <strong>Amount Due:</strong> 
                <span class="total-amount">${{ number_format($invoiceDetails['total_amount'] ?? 0, 2) }}</span>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    @if(!empty($invoiceDetails['notes']))
    <div class="notes-box">
        <div class="notes-title">Notes:</div>
        <div class="notes-content">{!! nl2br(e($invoiceDetails['notes'])) !!}</div>
    </div>
    @endif

    <div class="footer">
        &copy; {{ date('Y') }} GermBlast — Infection Controls, Inc. — 1414 Avenue J, Lubbock, TX 79401<br>
        Thank you for your business!
    </div>
</body>
</html>
