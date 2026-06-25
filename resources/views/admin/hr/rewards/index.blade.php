@extends('admin.includes.layout')

@section('title', auth()->user()->isSuperAdmin() ? 'GB Rewards Management' : 'My Rewards')

@push('styles')
    <style>
        /* Modern Reward Cards Grid */
        .reward-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 24px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.01) !important;
        }

        .reward-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05) !important;
            border-color: rgba(255, 184, 28, 0.4) !important;
        }

        .reward-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #ffb81c;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .reward-card:hover::before {
            opacity: 1;
        }

        .reward-badge-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 184, 28, 0.12);
            color: #ffb81c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .reward-card:hover .reward-badge-circle {
            background: #ffb81c;
            color: #ffffff;
            transform: scale(1.05);
        }

        .btn-delete-reward {
            background: none;
            border: none;
            color: #9ca3af;
            font-size: 16px;
            padding: 4px 8px;
            transition: color 0.15s ease;
        }

        .btn-delete-reward:hover {
            color: #ef4444;
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #ffb81c;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 1px #e5e7eb;
        }
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.hr.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">

                        {{-- Header --}}
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                @if(auth()->user()->isSuperAdmin())
                                    <h3 class="mb-1">GB Rewards Management 🏆</h3>
                                    <p class="text-muted mb-0">
                                        Assign and manage rewards for all GermBlast employees.
                                    </p>    
                                @else
                                    <h3 class="mb-1">GB Rewards 🏆</h3>
                                    <p class="text-muted mb-0">
                                        Review all rewards, milestones, and recognitions awarded to you.
                                    </p>
                                @endif
                            </div>
                            @if(auth()->user()->isSuperAdmin())
                                <div class="right-part-sec">
                                    <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#AddReward">+ Add Reward</button>
                                </div>
                            @endif
                        </div>

                            @if(session('success'))
                                <div class="px-4">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                            @endif

                            {{-- Main Cards Grid Area --}}
                            <div class="px-4 pb-4">
                                @if($rewards->isEmpty())
                                    <div class="section-card text-center py-5">
                                        <div class="mb-3" style="font-size: 40px;">🏅</div>
                                        <h5 class="fw-semibold text-dark">No Rewards Found</h5>
                                        <p class="text-muted mb-0">
                                            {{ auth()->user()->isSuperAdmin() ? 'No employee rewards have been registered yet.' : "You haven't received any rewards yet. Keep up the great work!" }}
                                        </p>
                                    </div>
                                @else
                                    <div class="row mx-0">
                                        @foreach($rewards as $reward)
                                            <div class="col-12 mb-4 px-2">
                                                <div class="reward-card h-100 d-flex flex-column">
                                                    
                                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="reward-badge-circle">
                                                                🏆
                                                            </div>
                                                            <div>
                                                                <h4 class="mb-1 fw-bold text-dark" style="font-size: 16px; line-height: 1.3;">
                                                                    {{ $reward->name }}
                                                                </h4>
                                                                <span class="text-muted" style="font-size: 12px;">
                                                                    {{ $reward->created_at->format('M j, Y') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        @if(auth()->user()->isSuperAdmin())
                                                            <form action="{{ route('admin.hr.rewards.destroy', $reward->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reward?');" class="mb-0">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-delete-reward" title="Delete Reward">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>

                                                    <div class="reward-description text-muted flex-grow-1" style="font-size: 14px; line-height: 1.6;">
                                                        {{ $reward->description ?: 'No description provided.' }}
                                                    </div>

                                                    @if(auth()->user()->isSuperAdmin())
                                                        <div class="mt-3 pt-3 border-top d-flex align-items-center gap-2" style="border-color: #f3f4f6 !important;">
                                                            <div class="avatar-circle">
                                                                {{ strtoupper(substr($reward->user->name ?? 'N', 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <span class="fw-semibold text-dark d-block" style="font-size: 13px; line-height: 1.2;">
                                                                    {{ $reward->user->name ?? 'N/A' }}
                                                                </span>
                                                                <span class="text-muted" style="font-size: 11px;">Recipient</span>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->isSuperAdmin())
        <!-- Add Reward Modal Start -->
        <div class="modal fade" id="AddReward" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Add Reward</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.hr.rewards.store') }}" method="POST" class="company-form" id="rewardForm">
                            @csrf
                            <div class="row mx-0">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Employee</label>
                                        <span class="text-danger">*</span>
                                        <select name="user_id" id="user_id" class="form-select" required>
                                            <option value="" disabled selected>Select an employee...</option>
                                            @foreach($users as $u)
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Reward Name</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Employee of the Month" required />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" id="description" placeholder="Describe why this reward was given..." class="form-control" rows="6"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Reward Modal End -->
    @endif
@endsection

@push('scripts')
    @if(auth()->user()->isSuperAdmin())
        <script>
            $(document).ready(function () {
                $('#rewardForm').on('submit', function (e) {
                    e.preventDefault();
                    const $form = $(this);
                    const $btn  = $('#submitBtn');

                    $.ajax({
                        url: $form.attr('action'),
                        method: 'POST',
                        data: $form.serialize(),
                        beforeSend: function () { $btn.prop('disabled', true).text('Saving...'); },
                        success: function (res) {
                            alert(res.message || 'Reward assigned successfully!');
                            $form[0].reset();
                            $btn.prop('disabled', false).text('Save changes');
                            $('#AddReward').modal('hide');
                            location.reload();
                        },
                        error: function (xhr) {
                            const errors = xhr.responseJSON?.errors;
                            alert(errors ? Object.values(errors)[0][0] : 'Something went wrong.');
                            $btn.prop('disabled', false).text('Save changes');
                        }
                    });
                });
            });
        </script>
    @endif
@endpush
