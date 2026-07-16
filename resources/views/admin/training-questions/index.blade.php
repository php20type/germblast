@extends('admin.includes.layout')

@section('title', 'Select Training Test')

@push('styles')
    <style>
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table tbody td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        a.text-action {
            color: #337ab7 !important;
        }
    </style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.operations.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mx-4 mt-3" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">TRAINING TESTS LIST</h3>
                                <p class="text-muted mb-0">Select a test to manage its questions.</p>
                            </div>
                        </div>

                        <!-- Table Card -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left !important; width: 45%;">Test Name</th>
                                            <th style="text-align: center !important; width: 25%;">Category</th>
                                            <th style="text-align: center !important; width: 15%;">Total Questions</th>
                                            <th class="text-end" style="width: 15%; padding-right: 35px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tests as $test)
                                            <tr>
                                                <td style="text-align: left !important; padding: 20px !important;">
                                                    <div style="font-size: 15px; color: #374151; font-weight: 600;">
                                                        {{ $test->name }}
                                                    </div>
                                                </td>
                                                <td style="text-align: center !important;">
                                                    {{ $test->category->name ?? '-' }}
                                                </td>
                                                <td style="text-align: center !important;">
                                                    <span class="badge bg-secondary">{{ $test->questions_count }}</span>
                                                </td>
                                                <td style="text-align: right !important; padding: 20px !important; padding-right: 35px !important; vertical-align: middle;">
                                                    <div class="d-flex justify-content-end align-items-center gap-3">
                                                        <a href="{{ route('admin.training-questions.show', $test->id) }}" class="text-action" style="font-size: 18px;" title="Manage Questions">
                                                            <i class="fa-solid fa-list-check"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
