@extends('admin.includes.layout')

@section('title', 'Service Orders')

@push('styles')
<style>
    .section-card {
        background: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 16px !important;
        padding: 25px !important;
        margin-bottom: 25px !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
        transition: all 0.3s ease !important;
    }

    .section-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04) !important;
    }

    .status-pill {
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 4px 10px !important;
        border-radius: 20px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        border: 1px solid transparent !important;
    }
    
    .status-pill-info {
        background-color: rgba(59, 130, 246, 0.12) !important;
        color: #3b82f6 !important;
        border-color: rgba(59, 130, 246, 0.2) !important;
    }

</style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">
                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">SERVICE ORDERS <span style="font-size: 24px;">📋</span></h3>
                                <p class="text-muted mb-0">View and manage all service orders and their associated slots.</p>
                            </div>
                        </div>

                        <!-- Search and Filter -->
                        <div class="px-4 mb-4">
                            <form id="filter-form" method="GET" class="d-flex gap-3 align-items-center">
                                <input type="text" name="search" class="form-control" placeholder="Search by Company Name..." value="{{ request('search') }}" style="max-width: 300px;">
                                <select name="status" class="form-select" style="max-width: 200px;">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <a href="{{ request()->url() }}" id="clear-filter" class="btn btn-outline-secondary px-4" style="{{ (request()->has('search') || request()->has('status')) ? '' : 'display: none;' }}">Clear</a>
                            </form>
                        </div>

                        <!-- Cards Content -->
                        <div class="px-4 pb-4 text-start" id="orders-container">
                            @include('admin.service_orders.partials.orders-list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function fetchOrders(url) {
        $.ajax({
            url: url,
            type: 'GET',
            global: false,
            success: function(response) {
                if (response.html) {
                    $('#orders-container').html(response.html);
                }
            },
            error: function(xhr) {
                console.error("Error fetching orders", xhr);
            }
        });
    }

    // Handle form submission
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        var url = window.location.href.split('?')[0];
        var params = $(this).serialize();
        fetchOrders(url + '?' + params);
        window.history.pushState(null, '', url + '?' + params);
    });

    // Handle clear button
    $('#clear-filter').on('click', function(e) {
        e.preventDefault();
        $('#filter-form')[0].reset();
        $('#filter-form input[name="search"]').val('');
        $('#filter-form select[name="status"]').val('');
        var url = window.location.href.split('?')[0];
        fetchOrders(url);
        window.history.pushState(null, '', url);
        $(this).hide();
    });

    // Toggle clear button visibility and auto-submit
    var timeout = null;
    $('#filter-form input[name="search"]').on('input', function() {
        var $form = $(this).closest('form');
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            $form.trigger('submit');
        }, 500); // 500ms debounce
        
        toggleClearBtn();
    });
    
    $('#filter-form select[name="status"]').on('change', function() {
        $(this).closest('form').trigger('submit');
        toggleClearBtn();
    });

    function toggleClearBtn() {
        if ($('input[name="search"]').val() || $('select[name="status"]').val()) {
            $('#clear-filter').show();
        } else {
            $('#clear-filter').hide();
        }
    }

    // Handle pagination clicks
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        fetchOrders(url);
        window.history.pushState(null, '', url);
    });
});
</script>
@endpush
