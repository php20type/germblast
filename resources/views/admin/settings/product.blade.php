@extends('admin.includes.layout')

@section('title', 'Products')

@section('content')

    <main class="app-wrapper">
        <!-- All Companies Section start  -->
        <div class="profile-section my-4">
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    @include('admin.settings.sidebar')

                    <!-- Main Content -->
                    <div class="col-md-10 p-0">
                        <div class="activity-type-content companies-section">
                            <div class="heading-area-sec p-0 pb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">Products <i class="fas fa-thumbtack pinned-icon"></i></h3>
                                    <p class="text-muted mb-0">Track products sold, with seperate pricing per
                                        market. </p>
                                </div>
                                <div class="right-part">
                                    <button class="btn btn-email">IMPORT</button>
                                    <button class="btn btn-export">EXPORT</button>
                                </div>
                            </div>

                            <div class="table-container px-0 py-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0 text-uppercase">Products ({{ $productCount }})</h6>
                                    <a href="#" class="btn-add-activity" data-bs-toggle="modal"
                                        data-bs-target="#add_product">Add Product</a>
                                </div>

                                <div class="table-responsive position-relative">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">SKU</th>
                                                <th scope="col">U.S.</th>
                                                <th scope="col">test</th>
                                                <th scope="col">Last Used</th>
                                                <th scope="col">Created time</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->sku }}</td>
                                                    <td>${{ $product->price }}</td>
                                                    <td></td>
                                                    <td>N/A</td>
                                                    <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="position-relative">
                                                        <a class="text-dark" href="javascript:void(0)"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    onclick="viewReport('Cloned Lead')">
                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                    View report
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button"
                                                                    onclick="deleteItem('Cloned Lead')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="info-section">
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Have your product list somewhere else?</h6>
                                        <a href="#" class="view-quotas-link">Import products</a>
                                    </div>
                                    <p>Add or update existing products from a spreadsheet using our product importer</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>How do I edit product pricing?</h6>
                                        <a href="#" class="view-quotas-link">Edit markets</a>
                                    </div>
                                    <p>Products have unique pricing for every market. Each lead has a specific market, so
                                        attached products receive the appropriate pricing.</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Trigger processes</h6>
                                        <a href="#" class="view-quotas-link">Edit lead distribution</a>
                                    </div>
                                    <p>In the Lead Distribution section you can configure a process to be automatically
                                        attached to a lead when a certain product is added.</p>
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

                    <form class="company-form" action="{{ route('admin.settings.source.store') }}" method="post"
                        id="store_product">
                        @csrf


                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" placeholder="" name="name" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label d-block mb-2 fw-bold text-uppercase">Product Type</label>

                                    <div class="d-flex gap-3 toggle-button">
                                        @foreach ($product_types as $product_type)
                                            <input type="radio" class="btn-check" name="product_type"
                                                id="product_type_{{ $product_type }}" value="{{ $product_type }}"
                                                autocomplete="off">

                                            <label class="flex-fill text-center btn btn-outline-warning rounded-pill py-2"
                                                for="product_type_{{ $product_type }}">
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
                                    <label class="form-label">SKU</label>
                                    <input type="text" placeholder="SKU" name="sku" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">U.S.</label>
                                    <input type="number" placeholder="Price" name="us_price" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="checkbox" placeholder="availablity" name="availablity"
                                        id="availablity" value="0"/>
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

@endsection

@push('scripts')
    <script>
        $("#store_product").validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
                product_type: {
                    required: true
                },
                sku: {
                    required: true
                },
                us_price: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please enter the name of the product."
                },
                product_type: {
                    required: "Please select the product_type."
                },
                sku: {
                    required: "Please enter the sku."
                },
                us_price: {
                    required: "Please enter the us price."
                },
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback d-block',
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else if (element.parent('.form-group')) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
        }
        });


        $('#store_product').submit(function(e) {
            e.preventDefault();

            if (!$('#store_product').valid()) {
                return; // Stop if validation fails
            }

            $.ajax({
                url: "{{ route('admin.settings.product.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert('Product added successfully!');
                    $('#add_product').modal('hide');
                    console.log(response);
                    location.reload();

                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                    toastr.error('Something went wrong while adding new product.');
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
