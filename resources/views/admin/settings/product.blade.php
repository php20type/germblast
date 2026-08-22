@extends('admin.includes.layout')

@section('title', 'Products')

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

        /* Standardized Action Buttons */
        .btn-outline-primary {
            color: #0d6efd !important;
            border-color: #0d6efd !important;
            background-color: transparent !important;
            font-weight: 500 !important;
            padding: 6px 16px !important;
            border-radius: 6px !important;
            transition: all 0.2s ease !important;
        }

        .btn-outline-primary:hover {
            color: #fff !important;
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.15) !important;
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
                                    <h3 class="mb-1">PRODUCTS <span style="font-size: 24px;">📌</span></h3>
                                    <p class="text-muted mb-0">Track products sold, with seperate pricing per market.</p>
                                </div>
                                <div class="right-part-sec mt-1">
                                    <a href="javascript:void(0);" class="btn btn-export" data-bs-toggle="modal" data-bs-target="#add_product">Add Product</a>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                <div class="mb-5">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0 text-uppercase">PRODUCTS ({{ $productCount }})</h6>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table w-100 equipment-report-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">SKU</th>
                                                    <th scope="col">U.S.</th>
                                                    <th scope="col">Created time</th>
                                                    <th scope="col" class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->sku }}</td>
                                                        <td>${{ $product->price }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M Y, H:i') }}</td>
                                                        <td class="text-end">
                                                            <a href="javascript:void(0);" 
                                                               class="btn btn-outline-primary btn-sm btn-edit-product"
                                                               data-id="{{ $product->id }}"
                                                               data-name="{{ $product->name }}"
                                                               data-sku="{{ $product->sku }}"
                                                               data-price="{{ $product->price }}"
                                                               data-product_type="{{ $product->product_type }}">
                                                                Edit
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="info-section bg-white p-4 rounded-3 border mt-2" style="border-color: #e5e7eb !important;">
                                    <div class="info-cards mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="fw-bold mb-0 text-uppercase">Have your product list somewhere else?</h6>
                                            
                                        </div>
                                        <p class="text-muted mb-0">Add or update existing products from a spreadsheet using our product importer</p>
                                    </div>
                                    <hr class="my-4 text-muted opacity-25">
                                    <div class="info-cards mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="fw-bold mb-0 text-uppercase">How do I edit product pricing?</h6>
                                            
                                        </div>
                                        <p class="text-muted mb-0">Products have unique pricing for every market. Each lead has a specific market, so attached products receive the appropriate pricing.</p>
                                    </div>
                                    <hr class="my-4 text-muted opacity-25">
                                    <div class="info-cards mb-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="fw-bold mb-0 text-uppercase">Trigger processes</h6>
                                            
                                        </div>
                                        <p class="text-muted mb-0">In the Lead Distribution section you can configure a process to be automatically attached to a lead when a certain product is added.</p>
                                    </div>
                                </div>

                            </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->
    </main>

    <div class="modal fade" id="add_product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Just remove modal-fullscreen from below class , to get a popup instead of full modal --}}
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add a new product</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">

                    <form class="company-form" action="{{ route('admin.settings.product.store') }}" method="post" id="store_product">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="e.g. Germblast Standard" name="name" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label d-block mb-2 fw-bold text-uppercase">Product Type <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3 toggle-button">
                                        @foreach ($product_types as $product_type)
                                            <input type="radio" class="btn-check" name="product_type" id="product_type_{{ $product_type }}" value="{{ $product_type }}" autocomplete="off">
                                            <label class="flex-fill text-center btn btn-outline-warning rounded-pill py-2" for="product_type_{{ $product_type }}">
                                                {{ $product_type }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">SKU <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="e.g. GB-STD" name="sku" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">U.S. Price <span class="text-danger">*</span></label>
                                    <input type="number" placeholder="e.g. 50" name="us_price" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="checkbox" name="availablity" id="availablity" value="0"/>
                                    <label class="form-label" for="availablity">Unavailable in market</label>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="AddProduct">New Product</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Product modal --}}
    <div class="modal fade" id="edit_product" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="editModalLabel">Edit Product</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">
                    <form class="company-form" action="" method="post" id="update_product">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="e.g. Germblast Standard" name="name" id="editProductName" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label d-block mb-2 fw-bold text-uppercase">Product Type <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3 toggle-button">
                                        @foreach ($product_types as $product_type)
                                            <input type="radio" class="btn-check" name="product_type" id="edit_product_type_{{ $product_type }}" value="{{ $product_type }}" autocomplete="off">
                                            <label class="flex-fill text-center btn btn-outline-warning rounded-pill py-2" for="edit_product_type_{{ $product_type }}">
                                                {{ $product_type }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">SKU <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="e.g. GB-STD" name="sku" id="editProductSku" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">U.S. Price <span class="text-danger">*</span></label>
                                    <input type="number" placeholder="e.g. 50" name="us_price" id="editProductPrice" class="form-control" />
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnUpdateProduct">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Reset form and validation on modal close
        $('#add_product').on('hidden.bs.modal', function () {
            const validator = $("#store_product").validate();
            if(validator) validator.resetForm();
            $('#store_product')[0].reset();
            $('#store_product .is-invalid').removeClass('is-invalid');
        });

        $("#store_product").validate({
            ignore: [],
            rules: {
                name: { required: true },
                product_type: { required: true },
                sku: { required: true },
                us_price: { required: true },
            },
            messages: {
                name: { required: "Please enter the name of the product." },
                product_type: { required: "Please select the product type." },
                sku: { required: "Please enter the sku." },
                us_price: { required: "Please enter the us price." },
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback d-block',
            highlight: function(element) { $(element).addClass('is-invalid'); },
            unhighlight: function(element) { $(element).removeClass('is-invalid'); },
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else if ($(element).attr('type') == 'radio') {
                    error.insertAfter($(element).closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#store_product').submit(function(e) {
            e.preventDefault();

            if (!$('#store_product').valid()) {
                return;
            }

            const btn = $('#AddProduct');
            btn.prop('disabled', true).text('Creating...');

            $.ajax({
                url: "{{ route('admin.settings.product.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success('Product added successfully!');
                    $('#add_product').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('New Product');
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong while adding new product.');
                }
            });
        });

        // Edit form reset on close
        $('#edit_product').on('hidden.bs.modal', function () {
            const validator = $("#update_product").validate();
            if(validator) validator.resetForm();
            $('#update_product')[0].reset();
            $('#update_product .is-invalid').removeClass('is-invalid');
        });

        // Edit button click
        $(document).on('click', '.btn-edit-product', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let name = $(this).data('name');
            let sku = $(this).data('sku');
            let price = $(this).data('price');
            let product_type = $(this).data('product_type');

            $('#editProductName').val(name);
            $('#editProductSku').val(sku);
            $('#editProductPrice').val(price);
            
            // Set radio button
            $(`input[name="product_type"][value="${product_type}"]`, '#update_product').prop('checked', true);

            $('#update_product').attr('action', "{{ url('admin/settings/product/update') }}/" + id);
            $('#edit_product').modal('show');
        });

        $("#update_product").validate({
            ignore: [],
            rules: {
                name: { required: true },
                product_type: { required: true },
                sku: { required: true },
                us_price: { required: true },
            },
            messages: {
                name: { required: "Please enter the name of the product." },
                product_type: { required: "Please select the product type." },
                sku: { required: "Please enter the sku." },
                us_price: { required: "Please enter the us price." },
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback d-block',
            highlight: function(element) { $(element).addClass('is-invalid'); },
            unhighlight: function(element) { $(element).removeClass('is-invalid'); },
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else if ($(element).attr('type') == 'radio') {
                    error.insertAfter($(element).closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#update_product').submit(function(e) {
            e.preventDefault();

            if (!$('#update_product').valid()) {
                return;
            }

            const btn = $('#btnUpdateProduct');
            btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success('Product updated successfully!');
                    $('#edit_product').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('Save Changes');
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong while updating the product.');
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
