<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Job Profitability Report - {{ $date->format('F Y') }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            margin-bottom: 20px;
        }
        .logo {
            max-height: 45px;
            float: left;
        }
        .report-title {
            text-align: right;
            margin-top: 0;
            color: #0d6efd;
            font-size: 18px;
            font-weight: bold;
        }
        .report-details {
            text-align: right;
            font-size: 11px;
            color: #555;
        }
        .clear {
            clear: both;
        }
        table.profitability-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.profitability-table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 6px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
        }
        table.profitability-table td {
            border: 1px solid #dee2e6;
            padding: 6px;
            font-size: 9px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .fw-bold {
            font-weight: bold;
        }
        /* Color matching */
        .row-green {
            background-color: #e8f5e9 !important;
        }
        .row-pink {
            background-color: #ffebee !important;
        }
        .row-yellow {
            background-color: #fffde7 !important;
        }
        .text-success-custom {
            color: #2e7d32 !important;
            font-weight: bold;
        }
        .text-danger-custom {
            color: #c0392b !important;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;    
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="float: left;">
            @if(file_exists(public_path('img/logo/logo.png')))
                <img src="{{ public_path('img/logo/logo.png') }}" class="logo" alt="GermBlast">
            @endif
        </div>
        <div style="float: right;" class="report-details">
            <div class="report-title">JOB PROFITABILITY</div>
            <div><strong>Month:</strong> {{ $date->format('F Y') }}</div>
            <div><strong>Generated:</strong> {{ now()->format('m/d/y h:i A') }}</div>
        </div>
        <div class="clear"></div>
    </div>

    <table class="profitability-table">
        <thead>
            <tr>
                <th colspan="3" class="text-center fw-bold" style="background-color: #e9ecef; font-size: 11px;">Basic Info</th>
                <th colspan="4" class="text-center fw-bold" style="background-color: #e9ecef; font-size: 11px;">Hours Metrics</th>
                <th colspan="4" class="text-center fw-bold" style="background-color: #e9ecef; font-size: 11px;">Labor Metrics</th>
            </tr>
            <tr>
                <th>Client</th>
                <th>Date</th>
                <th class="text-right">Price ($)</th>
                <th class="text-right">Hours</th>
                <th class="text-right">OT</th>
                <th class="text-right">Budget</th>
                <th class="text-right">Ratio</th>
                <th class="text-right">Actual ($)</th>
                <th class="text-right">Budget ($)</th>
                <th class="text-right">Ratio</th>
                <th class="text-right">Delta ($)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                @php
                    $isPink = $record['row_class'] === 'row-pink';
                    $isGreen = $record['row_class'] === 'row-green';
                    
                    $priceClass = $isGreen ? 'text-success-custom' : ($isPink ? 'text-danger-custom' : '');
                    $deltaClass = $isGreen ? 'text-success-custom' : ($isPink ? 'text-danger-custom' : '');
                @endphp
                <tr class="{{ $record['row_class'] }}">
                    <td class="fw-bold">{{ $record['client'] }}</td>
                    <td>{{ $record['date'] }}</td>
                    <td class="text-right {{ $priceClass }}">{{ $record['price'] }}</td>
                    <td class="text-right">{{ $record['hours'] }}</td>
                    <td class="text-right">{{ $record['ot'] }}</td>
                    <td class="text-right">{{ $record['budget_hours'] }}</td>
                    <td class="text-right">{{ $record['ratio_hours'] }}</td>
                    <td class="text-right">{{ $record['actual_labor'] }}</td>
                    <td class="text-right">{{ $record['budget_labor'] }}</td>
                    <td class="text-right">{{ $record['ratio_labor'] }}</td>
                    <td class="text-right fw-bold {{ $deltaClass }}">{{ $record['delta'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} GermBlast — Infection Controls, Inc. — 1414 Avenue J, Lubbock, TX 79401
    </div>
</body>
</html>
