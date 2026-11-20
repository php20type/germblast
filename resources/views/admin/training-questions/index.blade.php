@extends('admin.includes.layout')

@section('title', 'Select Training Test')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/operations.css') }}?v={{ filemtime(public_path('css/operations.css')) }}">
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
