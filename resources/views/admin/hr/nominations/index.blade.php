@extends('admin.includes.layout')

@section('title', 'Outstanding Nominations Management')

@push('styles')
<style>
    .section-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 5px;
    }

    .survey-title {
        font-size: 16px;
        font-weight: 600;
        color: #4b5563;
        margin-top: 24px;
        margin-bottom: 12px;
    }
    
    .office-title {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 12px;
    }

    .no-votes {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 20px;
        font-style: italic;
    }

    .results-container {
        padding-left: 20px;
        border-left: 2px solid #f3f4f6;
        margin-top: 20px;
    }

    /* Override table styling to match the rest of the HR module */
    .equipment-report-table th {
        background-color: #f9fafb !important;
        color: #374151 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        border-bottom: 1px solid #e5e7eb !important;
        padding: 12px !important;
    }

    .equipment-report-table td {
        font-size: 13px !important;
        color: #4b5563 !important;
        vertical-align: middle !important;
        padding: 12px !important;
        border-bottom: 1px solid #f3f4f6 !important;
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
                        <div class="heading-area-sec mb-4">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">OUTSTANDING AWARDS / NOMINATIONS</h3>
                                <p class="text-muted mb-0">
                                    Manage outstanding technician, team member, and management nominations.
                                </p>
                            </div>
                        </div>

                        @foreach($categories as $catKey => $catTitle)
                        <div class="px-4 pb-2">
                            <div class="section-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <div class="section-title">{{ $catTitle }}</div>
                                        <p class="text-muted mb-0" style="font-size: 14px;">Results from Previous Nomination Sessions (last 3)</p>
                                    </div>
                                    @if(isset($activeCycles[$catKey]))
                                        <button class="btn btn-danger btn-close-vote" data-id="{{ $activeCycles[$catKey]->id }}">Close Voting</button>
                                    @else
                                        <button class="btn btn-export btn-initiate" data-category="{{ $catKey }}" data-title="{{ $catTitle }}">Initiate a New Vote</button>
                                    @endif
                                </div>

                                <div class="results-container">
                                    @if(isset($activeCycles[$catKey]))
                                        <div class="alert alert-info py-2 mb-4">
                                            <strong>Active Cycle:</strong> {{ $activeCycles[$catKey]->title }} (Started on {{ $activeCycles[$catKey]->start_date->format('m/d/Y') }})
                                        </div>

                                        @if(!in_array($activeCycles[$catKey]->id, $votedCycleIds))
                                            <div class="card bg-light mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title" style="font-size: 15px;">Cast Your Vote</h5>
                                                    <form class="vote-form" action="{{ route('admin.employee.voting.submit') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="nomination_cycle_id" value="{{ $activeCycles[$catKey]->id }}">
                                                        
                                                        <div class="row mb-3">
                                                            <div class="col-md-12">
                                                                <label class="form-label">Nominee</label>
                                                                <select name="nominee_id" class="form-select select2" required>
                                                                    <option value="">-- Select Nominee --</option>
                                                                    @foreach($groupedUsers as $officeName => $users)
                                                                        <optgroup label="{{ $officeName }}">
                                                                            @foreach($users as $user)
                                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Reason for Nomination (Optional)</label>
                                                            <textarea name="comments" class="form-control" rows="2" placeholder="Why are you nominating this person?"></textarea>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary btn-sm">Submit Vote</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-success mb-4 py-2">You have successfully cast your vote for this cycle!</div>
                                        @endif
                                    @endif

                                    @if(!empty($formattedPastCycles[$catKey]) && $formattedPastCycles[$catKey]->count() > 0)
                                        @foreach($formattedPastCycles[$catKey] as $cycle)
                                            <div class="survey-title">Nomination Results for {{ $cycle->title }}</div>
                                            
                                            @if($cycle->grouped_nominations->isEmpty())
                                                <div class="no-votes">No votes recorded for this cycle.</div>
                                            @else
                                                @foreach($cycle->grouped_nominations as $officeName => $nominations)
                                                    <div class="office-title">Nominations (in order of votes) for the {{ $officeName }} office.</div>
                                                    
                                                    @if($nominations->isEmpty())
                                                        <div class="no-votes">No votes on this one.</div>
                                                    @else
                                                        <div class="table-responsive">
                                                            <table class="table w-100 equipment-report-table mb-4">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 150px;">Candidate</th>
                                                                        <th>Nominations</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($nominations as $nom)
                                                                        <tr>
                                                                            <td class="align-top">
                                                                                <strong>{!! nl2br(e(str_replace(' ', "\n", $nom['nominee']->name ?? 'Unknown'))) !!}</strong>
                                                                            </td>
                                                                            <td>
                                                                                <div class="mb-1 text-muted">{{ $nom['count'] }} nominations</div>
                                                                                @foreach($nom['comments'] as $comment)
                                                                                    <div>{{ $nom['nominee']->name ?? 'Unknown' }} - {{ $comment }}</div>
                                                                                @endforeach
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="no-votes">No previous voting sessions available.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Initiate Vote Modal -->
<div class="modal fade" id="initiateVoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="initiateVoteForm" action="{{ route('admin.hr.nominations.cycle.store') }}" method="POST">
            @csrf
            <input type="hidden" name="category" id="cycleCategory">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="initiateModalTitle">Initiate a New Vote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title / Survey Name</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Survey from Q3 2026">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Initiate</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.btn-initiate').click(function() {
            var category = $(this).data('category');
            var title = $(this).data('title');
            $('#cycleCategory').val(category);
            $('#initiateModalTitle').text('Initiate: ' + title);
            $('#initiateVoteModal').modal('show');
        });

        $('#initiateVoteForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var submitBtn = form.find('button[type="submit"]');
            submitBtn.prop('disabled', true);
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(function() { location.reload(); }, 1000);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false);
                    toastr.error(xhr.responseJSON?.message || 'Error initiating vote.');
                }
            });
        });

        $('.btn-close-vote').click(function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Close Voting Cycle?',
                text: "Are you sure you want to close this voting cycle? Employees will no longer be able to vote.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, close it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/hr/nominations/cycle/' + id + '/close',
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            toastr.success(response.message);
                            setTimeout(function() { location.reload(); }, 1000);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Error closing vote.');
                        }
                    });
                }
            });
        });

        // Initialize select2
        if ($('.select2').length > 0) {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        }

        $('.vote-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var submitBtn = form.find('button[type="submit"]');
            submitBtn.prop('disabled', true);
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    toastr.success(response.message);
                    form.find('input, select, textarea, button').prop('disabled', true);
                    form.slideUp(500, function() {
                        $(this).after('<div class="alert alert-success mt-3 py-2">You have successfully cast your vote for this cycle!</div>');
                    });
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false);
                    toastr.error(xhr.responseJSON?.message || 'Error submitting vote.');
                }
            });
        });
    });
</script>
@endpush
