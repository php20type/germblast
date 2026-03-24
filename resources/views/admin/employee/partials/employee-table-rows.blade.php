@forelse ($employees as $employee)
    <tr>
        <td>
            <input type="checkbox" class="form-check-input row-checkbox" data-id="{{ $employee->id }}">
        </td>
        <td>
            <div class="company-name">
                <a href="{{ route('admin.employee.edit', $employee->id) }}" class="text-decoration-none text-dark">
                    {{ $employee->name ?? 'N/A' }}
                </a>
            </div>
        </td>
        <td>
            {{ $employee->email ?? 'N/A' }}
        </td>
        <td>
            <span class="badge-customer">
                {{ strtoupper(str_replace('_', ' ', $employee->role)) }}
            </span>
        </td>
        <td>
            @if($employee->staff_type)
                <span class="badge bg-info">
                    {{ strtoupper($employee->staff_type) }}
                </span>
            @else
                <span class="text-muted">N/A</span>
            @endif
        </td>
        <td>
            @if($employee->territory)
                <span class="badge bg-secondary">
                    {{ $employee->territory->name }}
                </span>
            @else
                <span class="text-muted">N/A</span>
            @endif
        </td>
        <td>{{ \Carbon\Carbon::parse($employee->created_at)->format('d F Y') }}</td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">No employees found</td>
    </tr>
@endforelse
