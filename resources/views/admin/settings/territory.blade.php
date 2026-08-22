@extends('admin.includes.layout')

@section('title', 'Territories')

@push('styles')
    <style>
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

        /* Location Row styling */
        .location-row {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            position: relative;
            border: 1px solid #e5e7eb;
        }
        .remove-location-row {
            position: absolute;
            top: -10px;
            right: -10px;
            border-radius: 50%;
            padding: 2px 6px;
        }

        /* Info section for bottom placement */
        .info-cards {
            padding: 24px;
            background: #f8f9fa;
            border-radius: 12px;
            margin-top: 15px;
        }
        .info-cards h6 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
        }
        .info-cards p {
            font-size: 14px;
            line-height: 22px;
            color: #6b7280;
            margin-bottom: 0;
        }
    </style>
@endpush

@section('content')

    <main class="app-wrapper">
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
                                    <h3 class="mb-1 text-uppercase">Territories</h3>
                                    <p class="text-muted mb-0">Specify the regions where your leads are located.</p>
                                </div>
                                <div class="right-part-sec mt-1">
                                    <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#add_territory">Add Territory</button>
                                </div>
                            </div>

                            <div class="px-4 pb-4 pt-3">
                                
                                <table class="table w-100 equipment-report-table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Franchise Name</th>
                                            <th scope="col">Locations Count</th>
                                            <th scope="col">Created time</th>
                                            <th scope="col" class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($territories as $territory)
                                        <tr>
                                            <td class="fw-bold">{{ $territory->name }}</td>
                                            <td>{{ $territory->franchise_name }}</td>
                                            <td><span class="badge bg-secondary">{{ $territory->locations->count() }} rules</span></td>
                                            <td>{{ \Carbon\Carbon::parse($territory->created_at)->format('F jS, Y') }}</td>
                                            <td class="text-end">
                                                <a href="javascript:void(0);" class="btn btn-outline-info btn-sm btn-manage-locations"
                                                    data-id="{{ $territory->id }}"
                                                    data-name="{{ $territory->name }}"
                                                    data-locations='{{ json_encode($territory->locations) }}'>
                                                    Locations
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm btn-edit-territory"
                                                    data-id="{{ $territory->id }}" 
                                                    data-name="{{ $territory->name }}"
                                                    data-franchise_name="{{ $territory->franchise_name }}">
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @if(count($territories) == 0)
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No territories found.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <!-- Info Section Footer -->
                                <div class="info-section mt-4">
                                    <div class="info-cards">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6>What is a territory?</h6>
                                        </div>
                                        <p>Territories define specific geographic regions that your company uses to organize and assign leads. For example, create a territory called “New England” that includes Massachusetts and Vermont, or “New York Metro” that includes everything within 25 miles of New York City.</p>
                                    </div>
                                    <div class="info-cards">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6>What can I do with territories?</h6>
                                        </div>
                                        <p>After you create one or more territories, you can use the Lead Distribution page to assign new leads in a territory to a specific user or team. You can also filter by territories from the leads, companies, or people tabs.</p>
                                    </div>
                                    <div class="info-cards">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6>Territory order & Recalculating</h6>
                                        </div>
                                        <p>Place your most precise territories at the top (e.g. cities and postal codes), and wider ranging territories at the bottom. When you modify and save your territories, Nutshell will ask if you want to recalculate all territories using the new rules.</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Add Territory Modal -->
    <div class="modal fade" id="add_territory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add Territory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="store_territory" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label">Territory Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. New York Metro" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Franchise Name <span class="text-danger">*</span></label>
                            <input type="text" name="franchise_name" class="form-control" required placeholder="e.g. Northeast Regional" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveAddBtn">Save Territory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Territory Modal -->
    <div class="modal fade" id="edit_territory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Territory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="update_territory" method="POST">
                    @csrf
                    <input type="hidden" id="edit_territory_id" />
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label">Territory Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit_name" name="name" class="form-control" required />
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Franchise Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit_franchise_name" name="franchise_name" class="form-control" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveEditBtn">Update Territory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Manage Locations Modal -->
    <div class="modal fade" id="manage_locations" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Manage Location Rules - <span id="locations_territory_name"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="update_locations" method="POST">
                    @csrf
                    <input type="hidden" id="locations_territory_id" />
                    <div class="modal-body">
                        <div id="manageLocationRowContainer">
                            <!-- JS Will populate rows here -->
                        </div>

                        <!-- Add Location Row Template (Hidden) -->
                        <div class="location-row add-template-row mt-3" style="display: none;">
                            <button type="button" class="btn btn-danger btn-sm remove-location-row"><i class="fas fa-times"></i></button>
                            <div class="row g-3">
                                <div class="col-md-4" data-type="country">
                                    <label class="form-label small text-muted mb-1">Country</label>
                                    <select class="form-select country-select" data-name-template="locations[__INDEX__][country]">
                                        <option value="" disabled selected>Select Country</option>
                                        @foreach (App\Helpers\Helper::getCountries() as $country)
                                            <option value='{{ $country->id }}'>{{ ucfirst($country->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4" data-type="state">
                                    <label class="form-label small text-muted mb-1">State/Province</label>
                                    <select class="form-select state-select" data-name-template="locations[__INDEX__][state_province]">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                                <div class="col-md-4" data-type="city">
                                    <label class="form-label small text-muted mb-1">City</label>
                                    <select class="form-select city-select" data-name-template="locations[__INDEX__][city]">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row g-3 mt-1">
                                <div class="col-md-6" data-type="postal">
                                    <label class="form-label small text-muted mb-1">Postal Code</label>
                                    <input type="text" class="form-control" data-name-template="locations[__INDEX__][postal_code]" placeholder="Postal Code" />
                                </div>
                                <div class="col-md-6" data-type="area">
                                    <label class="form-label small text-muted mb-1">Area Code</label>
                                    <input type="text" class="form-control" data-name-template="locations[__INDEX__][area_code]" placeholder="Area Code" />
                                </div>
                            </div>
                            <div class="row g-3 mt-2 align-items-center" data-type="range">
                                <div class="col-auto">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <span class="distance-label">and within</span>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select" data-name-template="locations[__INDEX__][range]">
                                        <option value="5">5 mi (8 km)</option>
                                        <option value="25">25 mi (40 km)</option>
                                        <option value="50">50 mi (80 km)</option>
                                        <option value="100">100 mi (160 km)</option>
                                        <option value="250">250 mi (400 km)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addLocationRow('manageLocationRowContainer', '.add-template-row')">
                            <i class="fas fa-plus"></i> Add Location Rule
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveLocationsBtn">Update Rules</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function updateRowIndices(containerId, templateSelector) {
            $('#' + containerId + ' > .location-row:not(' + templateSelector + ')').each(function(index) {
                $(this).find('select, input').each(function() {
                    var nameTpl = $(this).attr('data-name-template');
                    if (nameTpl) {
                        $(this).attr('name', nameTpl.replace(/__INDEX__/g, index));
                    }
                });
            });
        }

        function addLocationRow(containerId, templateSelector) {
            var $template = $(templateSelector).first();
            var $newRow = $template.clone().removeClass(templateSelector.replace('.', '')).show();
            
            // Clean up any copied Select2 artifacts before appending and initializing
            $newRow.find('.select2-container').remove();
            $newRow.find('select').removeClass('select2-hidden-accessible').removeAttr('data-select2-id aria-hidden tabindex');
            $newRow.find('option').removeAttr('data-select2-id');

            $('#' + containerId).append($newRow);

            updateRowIndices(containerId, templateSelector);
        }

        $(document).ready(function() {
            
            $('#store_territory').validate({
                ignore: [],
                errorClass: 'text-danger',
                rules: {
                    name: { required: true },
                    franchise_name: { required: true }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });

            $('#update_territory').validate({
                ignore: [],
                errorClass: 'text-danger',
                rules: {
                    name: { required: true },
                    franchise_name: { required: true }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });

            // Remove Add Modal automatic row generation

            // Remove Row
            $(document).on('click', '.remove-location-row', function() {
                var $container = $(this).closest('div[id$="LocationRowContainer"]');
                var templateSelector = '.add-template-row';
                
                if ($container.find('.location-row:not(' + templateSelector + ')').length <= 1) {
                    toastr.warning('You must have at least one location rule.');
                    return;
                }
                
                $(this).closest('.location-row').remove();
                if($container.length) updateRowIndices($container.attr('id'), templateSelector);
            });
            // Helper functions for loading cascading dropdowns
            function loadStates($row, countryId, selectedStateId = null, callback = null) {
                let $stateSelect = $row.find('.state-select');
                $stateSelect.html('<option value="">Loading...</option>');
                
                if(countryId) {
                    $.ajax({
                        url: `/states/${countryId}`,
                        type: 'GET',
                        success: function(response) {
                            $stateSelect.html('<option value="">Select State</option>');
                            $.each(response, function(key, state) {
                                let isSelected = selectedStateId == state.state_id ? 'selected' : '';
                                $stateSelect.append('<option value="' + state.state_id + '" ' + isSelected + '>' + state.name + '</option>');
                            });
                            $stateSelect.trigger('change');
                            if (callback) callback();
                        }
                    });
                } else {
                    $stateSelect.html('<option value="">Select State</option>').trigger('change');
                    if (callback) callback();
                }
            }

            function loadCities($row, stateId, selectedCityId = null) {
                let $citySelect = $row.find('.city-select');
                $citySelect.html('<option value="">Loading...</option>');
                
                if(stateId) {
                    $.ajax({
                        url: `/cities/${stateId}`,
                        type: 'GET',
                        success: function(response) {
                            $citySelect.html('<option value="">Select City</option>');
                            $.each(response, function(key, city) {
                                let isSelected = selectedCityId == city.id ? 'selected' : '';
                                $citySelect.append('<option value="' + city.id + '" ' + isSelected + '>' + city.name + '</option>');
                            });
                            $citySelect.trigger('change');
                        }
                    });
                } else {
                    $citySelect.html('<option value="">Select City</option>').trigger('change');
                }
            }

            // Country Change -> Fetch States
            $(document).on('change', '.country-select', function() {
                let $row = $(this).closest('.location-row');
                let countryId = $(this).val();
                loadStates($row, countryId);
                $row.find('.city-select').html('<option value="">Select City</option>');
            });

            // State Change -> Fetch Cities
            $(document).on('change', '.state-select', function() {
                let $row = $(this).closest('.location-row');
                let stateId = $(this).val();
                loadCities($row, stateId);
            });

            // AJAX Store
            $('#store_territory').submit(function(e) {
                e.preventDefault();
                
                if (!$(this).valid()) return false;

                var btn = $('#saveAddBtn');
                btn.prop('disabled', true).text('Saving...');
                
                $.ajax({
                    url: "{{ route('admin.settings.territory.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.message || 'Territory added successfully!');
                        $('#add_territory').modal('hide');
                        setTimeout(function(){ location.reload(); }, 1000);
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Save Territory');
                        toastr.error('Please fill all required fields correctly.');
                    }
                });
            });

            // Manage Locations Button Click
            $(document).on('click', '.btn-manage-locations', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var locations = $(this).data('locations');
                if (typeof locations === 'string') {
                    locations = JSON.parse(locations);
                }
                
                $('#locations_territory_id').val(id);
                $('#locations_territory_name').text(name);
                
                $('#manageLocationRowContainer').empty();
                
                if(locations && locations.length > 0) {
                    locations.forEach(function(loc) {
                        addLocationRow('manageLocationRowContainer', '.add-template-row');
                        
                        var $row = $('#manageLocationRowContainer .location-row:not(.add-template-row)').last();
                        
                        if(loc.postal_code) $row.find('[name$="[postal_code]"]').val(loc.postal_code);
                        if(loc.area_code) $row.find('[name$="[area_code]"]').val(loc.area_code);
                        if(loc.range) $row.find('[name$="[range]"]').val(loc.range);
                        
                        if(loc.country) {
                            $row.find('.country-select').val(loc.country).trigger('change');
                            loadStates($row, loc.country, loc.state, function() {
                                if (loc.state) {
                                    loadCities($row, loc.state, loc.city);
                                }
                            });
                        }
                    });
                } else {
                    addLocationRow('manageLocationRowContainer', '.add-template-row');
                }
                
                updateRowIndices('manageLocationRowContainer', '.add-template-row');
                $('#manage_locations').modal('show');
            });

            // Edit Button Click
            $(document).on('click', '.btn-edit-territory', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var franchiseName = $(this).data('franchise_name');
                
                $('#edit_territory_id').val(id);
                $('#edit_name').val(name);
                $('#edit_franchise_name').val(franchiseName);
                
                $('#edit_territory').modal('show');
            });

            // AJAX Update
            $('#update_territory').submit(function(e) {
                e.preventDefault();
                
                if (!$(this).valid()) return false;
                
                var id = $('#edit_territory_id').val();

                var btn = $('#saveEditBtn');
                btn.prop('disabled', true).text('Updating...');
                
                $.ajax({
                    url: "/admin/settings/territory/update/" + id,
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.message || 'Territory updated successfully!');
                        $('#edit_territory').modal('hide');
                        setTimeout(function(){ location.reload(); }, 1000);
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Update Territory');
                        toastr.error('Please fill all required fields correctly.');
                    }
                });
            });

            // AJAX Update Locations
            $('#update_locations').submit(function(e) {
                e.preventDefault();
                
                if($('#manageLocationRowContainer .location-row:not(.add-template-row)').length === 0) {
                    toastr.error('You must add at least one location rule.');
                    return;
                }
                
                var id = $('#locations_territory_id').val();
                
                var btn = $('#saveLocationsBtn');
                btn.prop('disabled', true).text('Updating...');
                
                $.ajax({
                    url: "/admin/settings/territory/update-locations/" + id,
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.message || 'Rules updated successfully!');
                        $('#manage_locations').modal('hide');
                        setTimeout(function(){ location.reload(); }, 1000);
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).text('Update Rules');
                        toastr.error('Please fill all required fields correctly.');
                    }
                });
            });

            // Reset modals when closed
            $('#add_territory').on('hidden.bs.modal', function () {
                $('#store_territory')[0].reset();
                $('#store_territory').validate().resetForm();
            });
            $('#edit_territory').on('hidden.bs.modal', function () {
                $('#update_territory')[0].reset();
                $('#update_territory').validate().resetForm();
            });
            $('#manage_locations').on('hidden.bs.modal', function () {
                $('#update_locations')[0].reset();
                $('#manageLocationRowContainer').empty();
            });

        });
    </script>
@endpush
