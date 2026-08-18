@extends('admin.includes.layout')

@section('title', 'Quickbooks Export')

@push('styles')
    <style>
        .section-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
        }
        .section-header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
            margin: 0;
            display: flex;
            align-items: center;
        }
        .form-control {
            border-radius: 6px;
        }
        .export-btn {
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 6px;
        }
    </style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.corporate-tools.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">
                        <!-- Header -->
                        <div class="heading-area-sec mb-4">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">QuickBooks Export</h3>
                                <p class="text-muted mb-0">Export Customer and Invoice data in QuickBooks CSV format.</p>
                            </div>
                        </div>
                        
                        <div class="px-4 pb-4">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">
                                                <i class="fas fa-users text-primary me-2"></i> Customer Export
                                            </h3>
                                        </div>
                                        <form action="{{ route('admin.quickbooks.export-customers') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label text-muted fw-bold mb-1" style="font-size: 14px;">Start Date</label>
                                                <input type="date" name="start_date" class="form-control" required>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label text-muted fw-bold mb-1" style="font-size: 14px;">End Date</label>
                                                <input type="date" name="end_date" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-export w-100 py-2" style="font-size: 15px;">
                                                <i class="fas fa-file-csv me-2"></i> Export Customers to CSV
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">
                                                <i class="fas fa-file-invoice-dollar text-success me-2"></i> Invoice Export
                                            </h3>
                                        </div>
                                        <form action="{{ route('admin.quickbooks.export-invoices') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label text-muted fw-bold mb-1" style="font-size: 14px;">Start Date</label>
                                                <input type="date" name="start_date" class="form-control" required>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label text-muted fw-bold mb-1" style="font-size: 14px;">End Date</label>
                                                <input type="date" name="end_date" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-export w-100 py-2" style="font-size: 15px;">
                                                <i class="fas fa-file-csv me-2"></i> Export Invoices to CSV
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
