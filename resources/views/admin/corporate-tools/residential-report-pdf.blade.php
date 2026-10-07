<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Residential Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #333; }
        .header p { margin: 5px 0; color: #666; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; color: #333; }
        tr:nth-child(even) { background-color: #fdfdfd; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Residential Report</h2>
        <p>Month of: {{ $date->format('F Y') }}</p>
        <p>Generated on: {{ now()->format('m/d/Y H:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>City</th>
                <th>Special?</th>
                <th>Date</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                <tr>
                    <td>{{ $record['client'] }}</td>
                    <td>{{ $record['city'] }}</td>
                    <td>{{ $record['special'] }}</td>
                    <td>{{ $record['date'] }}</td>
                    <td>{{ $record['price'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">No records found for this period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
