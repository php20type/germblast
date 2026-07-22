@forelse ($employees as $employee)
    <tr>
        <td>
            <img
                src="{{ $employee->profile_image
                    ? asset('storage/'.$employee->profile_image)
                    : asset('img/home/default-profile.png') }}"
                alt="profile"
                style="width:60px; height:60px; object-fit:cover; border-radius:50%;">
        </td>
        {{-- <td>
            <div class="company-name">
                <a href="{{ route('admin.employee.edit', $employee->id) }}" class="text-decoration-none text-dark">
                    {{ $employee->name ?? 'N/A' }}
                </a>
            </div>
        </td> --}}
        <td style="width:220px; min-width:220px;">
            <div class="company-name">
                @can('employee.edit')
                    <a href="{{ route('admin.employee.edit', $employee->id) }}" class="text-decoration-none text-dark">
                        {{ $employee->name ?? 'N/A' }}
                    </a>
                @else
                    <span class="text-dark">
                        {{ $employee->name ?? 'N/A' }}
                    </span>
                @endcan
            </div>
            @if(count($employee->specialties) > 0)
                <div class="mt-1 text-muted" style="font-size:0.75rem;">
                    {{ implode(' || ', $employee->specialties) }}
                </div>
            @endif
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
        <td>
            <div class="d-flex align-items-center">
                <span class="hourly-rate" data-value="{{ $employee->hourly_rate }}">
                    *****
                </span>

                <i class="fas fa-eye ms-2 toggle-rate" style="cursor:pointer;"></i>
            </div>
        </td>
        <td>
            <div class="d-flex align-items-center">
                <span class="overtime-rate-display" data-value="{{ $employee->overtime_rate ?? 0 }}">
                    *****
                </span>

                <i class="fas fa-eye ms-2 toggle-overtime-rate" style="cursor:pointer;"></i>
            </div>
        </td>
        <td>{{ \Carbon\Carbon::parse($employee->created_at)->format('d F Y') }}</td>
     </tr>
 @empty
     <tr>
         <td colspan="8" class="text-center">No employees found</td>
     </tr>
 @endforelse
