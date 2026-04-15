@forelse($reports as $report)
<tr>

    <!-- DATE -->
    <td>{{ $report->report_date ? \Carbon\Carbon::parse($report->report_date)->format('jS F Y') : 'N/A' }}</td>

    <!-- SUBMITTED AT -->
    @if(isset($type) && ($type === 'submitted' || $type === 'filled'))
        <td>
            {{ $report->submitted_at ? \Carbon\Carbon::parse($report->submitted_at)->format('jS F Y') : '-' }}
        </td>
    @endif

    <!-- FILLED AT -->
    @if(isset($type) && $type === 'filled')
        <td>
            {{ $report->filled_at ? \Carbon\Carbon::parse($report->filled_at)->format('jS F Y') : '-' }}
        </td>
    @endif

    <!-- EMPLOYEE -->
    <td>
        <a href="{{ route('admin.expense-report.edit', $report->id) }}">
            {{ $report->user->name ?? 'N/A' }}
        </a>
    </td>

    <!-- TYPE -->
    <td>
        <span class="badge bg-info">{{ $report->report_type ?? 'N/A' }}</span>
    </td>

    <!-- STATUS -->
    <td>
        <span class="badge bg-{{ $report->status === 'Approved' ? 'success' : ($report->status === 'Rejected' ? 'danger' : ($report->status === 'Filled' ? 'warning' : 'secondary')) }}">
            {{ $report->status ?? 'N/A' }}
        </span>
    </td>

    <!-- ITEMS -->
    <td>
        <span class="badge bg-secondary">{{ $report->items->count() }} items</span>
    </td>

    <!-- AMOUNT -->
    <td>
        <strong>${{ number_format($report->total_amount, 2) }}</strong>
    </td>

</tr>
@empty
<tr>
    <td colspan="8" class="text-center text-muted py-4">No expense reports found.</td>
</tr>
@endforelse
