@forelse($reports as $report)
<tr>

    <!-- DATE -->
    <td>
        <span class="fw-semibold text-dark">{{ $report->report_date ? \Carbon\Carbon::parse($report->report_date)->format('jS F Y') : 'N/A' }}</span>
    </td>

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
        @canany(['expense_report.edit', 'expense_report.add'])
        <a href="{{ route('admin.expense-report.edit', $report->id) }}" class="text-decoration-none">
            {{ $report->user->name ?? 'N/A' }}
        </a>
        @else
        <span class="text-dark">{{ $report->user->name ?? 'N/A' }}</span>
        @endcanany
    </td>

    <!-- TYPE -->
    <td>
        <span class="fw-semibold text-secondary">{{ $report->report_type ?? 'N/A' }}</span>
    </td>

    <!-- STATUS -->
    <td>
        @php
            $statusSlug = strtolower($report->status ?? 'open');
            $pillClass = 'status-pill-' . $statusSlug;
        @endphp
        <span class="status-pill {{ $pillClass }}">
            {{ $report->status ?? 'N/A' }}
        </span>
    </td>

    <!-- ITEMS -->
    <td>
        <span class="badge bg-secondary text-white rounded-pill px-2 py-1">{{ $report->items->count() }} items</span>
    </td>

    <!-- AMOUNT -->
    <td>
        <strong class="text-dark">${{ number_format($report->total_amount, 2) }}</strong>
    </td>

</tr>
@empty
<tr>
    <td colspan="8" class="text-center text-muted py-4">No expense reports found.</td>
</tr>
@endforelse
