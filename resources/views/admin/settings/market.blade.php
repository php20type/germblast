@extends('admin.includes.layout')

@section('title', 'Markets')

@section('content')
@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Boxed Table System from Equipment Management */
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: left;
            white-space: nowrap;
        }

        .equipment-report-table tbody td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: left;
            white-space: nowrap;
        }

        .equipment-report-table thead th:last-child,
        .equipment-report-table tbody td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tr:last-child td {
            border-bottom: none !important;
        }
    </style>
@endpush


    <main class="app-wrapper">
        <!-- All Companies Section start  -->
        <div class="companies-section my-4">
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    @include('admin.settings.sidebar')

                    <!-- Main Content -->
                    <div class="col-md-10 p-0">
                        <div class="main-content">
                            <div class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">MARKETS</h3>
                                    <p class="text-muted mb-0">Choose what currencies are available in your account.</p>
                                </div>
                                <div class="right-part-sec mt-1">
                                    <a href="javascript:void(0);" class="btn btn-export" id="toggleAddMarket" onclick="addMarket()">Add Market</a>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                <div class="mb-5">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0 text-uppercase">MARKETS ({{ $totalCounts }})</h6>
                                    </div>

                                    <table class="table w-100 equipment-report-table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Currency</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($markets as $market)
                                                <tr>
                                                    <td>{{ $market->name }}</td>
                                                    <td>{{ $market->currency->code ?? 'N/A' }}</td>
                                                    <td class="text-end">
                                                        <a href="javascript:void(0);" 
                                                           class="btn btn-outline-primary btn-sm btn-edit-market"
                                                           data-id="{{ $market->id }}"
                                                           data-name="{{ $market->name }}"
                                                           data-currency_id="{{ $market->currency_id }}">
                                                            Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="info-section bg-white p-4 rounded-3 border mt-4" style="border-color: #e5e7eb !important;">
                                    <div class="info-cards mb-4">
                                        <h6 class="fw-bold mb-2">WHAT IS A MARKET?</h6>
                                        <p class="text-muted mb-0">Products have unique pricing for each market. Each lead has a specific market, so attached products receive the appropriate pricing.</p>
                                    </div>
                                    <hr class="my-4 text-muted opacity-25">
                                    <div class="info-cards mb-4">
                                        <h6 class="fw-bold mb-2">MULTIPLE CURRENCIES</h6>
                                        <p class="text-muted mb-0">Every market can use a different currency. Define a market with your currency type, then edit product pricing for that market.</p>
                                    </div>
                                    <hr class="my-4 text-muted opacity-25">
                                    <div class="info-cards mb-0">
                                        <h6 class="fw-bold mb-2">DEFAULT MARKETS</h6>
                                        <p class="text-muted mb-0">Every user can set a default market in their My Account page. When they create a new lead, it will default to this setting.</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->
    </main>

    {{-- Competitor modal --}}
    <div class="modal fade" id="add_market" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Just remove modal-fullscreen from below class , to get a popup instead of full modal --}}
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">New Market</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">

                    <form class="company-form" action="{{ route('admin.settings.market.store') }}" method="post"
                        id="store_market">
                        @csrf


                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="e.g. US Market" name="name" class="form-control" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Currency <span class="text-danger">*</span></label>
                                    <select name="currency_id" id="currency_id" class="form-select">
                                        <option value="">-- Select Currency --</option>
                                        @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="AddMarket">New Market</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Market modal --}}
    <div class="modal fade" id="edit_market" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="editModalLabel">Edit Market</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">
                    <form class="company-form" action="" method="post" id="update_market">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="e.g. US Market" name="name" id="editMarketName" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Currency <span class="text-danger">*</span></label>
                                    <select name="currency_id" id="editMarketCurrency" class="form-select">
                                        <option value="">-- Select Currency --</option>
                                        @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnUpdateMarket">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function addMarket() {
            $('#add_market').modal('show');
        }

        // Reset form and validation on modal close
        $('#add_market').on('hidden.bs.modal', function () {
            const validator = $("#store_market").validate();
            if(validator) validator.resetForm();
            $('#store_market')[0].reset();
            $('#store_market .is-invalid').removeClass('is-invalid');
        });

        $("#store_market").validate({
            ignore: [],
            rules: {
                name: { required: true },
                currency_id: { required: true },
            },
            messages: {
                name: { required: "Please enter the market name." },
                currency_id: { required: "Please select the currency." },
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback d-block',
            highlight: function(element) { $(element).addClass('is-invalid'); },
            unhighlight: function(element) { $(element).removeClass('is-invalid'); },
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#store_market').submit(function(e) {
            e.preventDefault();

            if (!$('#store_market').valid()) {
                return; // Stop if validation fails
            }

            const btn = $('#AddMarket');
            btn.prop('disabled', true).text('Creating...');

            $.ajax({
                url: "{{ route('admin.settings.market.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success('Market added successfully!');
                    $('#add_market').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('New Market');
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong while adding new market.');
                }
            });
        });

        // Edit form reset on close
        $('#edit_market').on('hidden.bs.modal', function () {
            const validator = $("#update_market").validate();
            if(validator) validator.resetForm();
            $('#update_market')[0].reset();
            $('#update_market .is-invalid').removeClass('is-invalid');
        });

        // Edit button click
        $(document).on('click', '.btn-edit-market', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let name = $(this).data('name');
            let currency_id = $(this).data('currency_id');

            $('#editMarketName').val(name);
            $('#editMarketCurrency').val(currency_id);

            $('#update_market').attr('action', "{{ url('admin/settings/market/update') }}/" + id);
            $('#edit_market').modal('show');
        });

        $("#update_market").validate({
            ignore: [],
            rules: {
                name: { required: true },
                currency_id: { required: true },
            },
            messages: {
                name: { required: "Please enter the market name." },
                currency_id: { required: "Please select the currency." },
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback d-block',
            highlight: function(element) { $(element).addClass('is-invalid'); },
            unhighlight: function(element) { $(element).removeClass('is-invalid'); },
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#update_market').submit(function(e) {
            e.preventDefault();

            if (!$('#update_market').valid()) {
                return;
            }

            const btn = $('#btnUpdateMarket');
            btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success('Market updated successfully!');
                    $('#edit_market').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('Save Changes');
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong while updating the market.');
                }
            });
        });


        function toggleSettings() {
            const settingsContent = document.getElementById('settingsContent');
            const chevronIcon = document.getElementById('settingsChevron');

            if (settingsContent.classList.contains('show')) {
                settingsContent.classList.remove('show');
                chevronIcon.classList.add('rotated');
            } else {
                settingsContent.classList.add('show');
                chevronIcon.classList.remove('rotated');
            }
        }

        function toggleDropdown(section) {
            const sections = ['administration', 'sales', 'data', 'organization', 'connections'];

            // Close all other dropdowns
            sections.forEach(otherSection => {
                if (otherSection !== section) {
                    const otherContent = document.getElementById(otherSection + 'Content');
                    const otherChevron = document.getElementById(otherSection + 'Chevron');
                    otherContent.classList.remove('show');
                    otherChevron.classList.remove('rotated');
                }
            });

            // Toggle the clicked dropdown
            const dropdownContent = document.getElementById(section + 'Content');
            const chevronIcon = document.getElementById(section + 'Chevron');

            if (dropdownContent.classList.contains('show')) {
                dropdownContent.classList.remove('show');
                chevronIcon.classList.remove('rotated');
            } else {
                dropdownContent.classList.add('show');
                chevronIcon.classList.add('rotated');
            }
        }

        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
