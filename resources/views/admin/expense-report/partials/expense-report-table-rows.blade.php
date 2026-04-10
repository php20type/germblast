@forelse($expenseReports as $report)
<tr>
    <td>
        {{ $report->report_date ?? 'N/A' }}
    </td>
    <td>
        <a href="{{ route('admin.expense-report.edit', $report->id) }}">
            {{ $report->user->name ?? 'N/A' }}
        </a>
    </td>
    <td>
        <span class="badge bg-info">{{ $report->report_type ?? 'N/A' }}</span>
    </td>
    <td>
        <span class="badge bg-{{ $report->status === 'Approved' ? 'success' : ($report->status === 'Rejected' ? 'danger' : ($report->status === 'Filed' ? 'warning' : 'secondary')) }}">
            {{ $report->status ?? 'N/A' }}
        </span>
    </td>
    <td>
        <span class="badge bg-secondary">{{ $report->items->count() ?? 0 }} items</span>
    </td>
    <td>
        <strong>${{ number_format($report->total_amount, 2) }}</strong>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="text-center text-muted py-4">
        No expense reports found.
    </td>
</tr>
@endforelse
