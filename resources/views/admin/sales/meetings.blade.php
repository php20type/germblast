@extends('admin.includes.layout')

@section('title', 'Schedule Meetings')

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.sales.sidebar')


                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="sales-dashboard">
                        <div class="dashboard-header section-card">
                            <div class="container-fluid">
                                <h1 class="display-6 mb-2 fw-bold">Schedule Meetings</h1>
                                <p class="text-muted">Simplify meeting planning</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main Content Ends -->

            </div>
        </div>
    </div>
    @endsection


    @push('scripts')
    @endpush
