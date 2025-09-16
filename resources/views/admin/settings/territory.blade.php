@extends('admin.includes.layout')

@section('title', 'Territories')

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
                        <div class="activity-type-content">
                            <div
                                class="heading-area-sec d-md-flex justify-content-between align-items-center border-bottom pb-3 mb-2">
                                <div class="left-part-sec">
                                    <h3 class="mb-1 fw-bold">Territories</h3>
                                    <p class="text-muted mb-0">Specify the regions where your leads are located.</p>
                                </div>
                                {{-- <div class="right-part-sec">
                                    <button class="btn btn-primary">SAVE</button>
                                </div> --}}
                                <div class="right-part-sec">
                                    <button class="btn btn-warning" id="addNewTerritoryLocation">Add New Location</button>
                                </div>
                                <hr>
                            </div>

                            <div class="main-container">
                                <!-- Lubbock Office Card Start -->
                                <div class="territory-card">
                                    <div class="territory-header d-flex justify-content-between">
                                        <div>
                                            <i class="fas fa-building"></i> Lubbock Office
                                            <span class="location-counter">2 locations</span>
                                        </div>

                                        <button class="btn btn-danger btn-sm remove-territory-location-row">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="territory-body">
                                        <div id="locationRowContainer">

                                            <div class="location-row">
                                                <div class="remove-btn-container mb-2">
                                                    <button class="btn btn-danger btn-sm remove-location-row">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-2" id="type">
                                                        <select class="form-select" name="type">
                                                            <option value="country">Country</option>
                                                            <option value="state">State/Province</option>
                                                            <option value="city">City</option>
                                                            <option value="postal">Postal Code</option>
                                                            <option value="area">Area Code</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2" data-type="country">
                                                        <select class="form-select" name="country">
                                                            <option value="" disabled selected>Select Country
                                                            </option>
                                                            @foreach (App\Helpers\Helper::getCountries() as $country)
                                                                <option value='{{ $country->id }}' {{-- {{ old('country', $user->country) == $country->id ? 'selected' : '' }} --}}
                                                                    {{-- {{ $user->country_id == $country->id ? 'selected' : '' }} --}}
                                                                    data-kt-select2-country="{{ $country->short_name }}">
                                                                    {{ ucfirst($country->name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2" data-type="state">
                                                        <select class="form-select" name="state_province">

                                                        </select>
                                                    </div>
                                                    <div class="col-md-2" data-type="postal">
                                                        <select class="form-select" name="postal_code">
                                                            <option value="">-- Postal Code --</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2" data-type="area">
                                                        <select class="form-select" name="area_code">
                                                            <option value="">-- Area Code --</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2" data-type="city">
                                                        <select class="form-select" name="city">
                                                            <option value="">-- City --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row g-3 mt-2 align-items-center" data-type="range">
                                                    <div class="col-auto">
                                                        <input type="checkbox" class="form-check-input" checked>
                                                        <span class="distance-label">and within</span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <select class="form-select" style="width: 10vw;" name="range">
                                                            <option value="5">5 mi (8 km)</option>
                                                            <option value="25">25 mi (40 km)</option>
                                                            <option value="50">50 mi (80 km)</option>
                                                            <option value="100">100 mi (160 km)</option>
                                                            <option value="250">250 mi (400 km)</option>
                                                        </select>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="add-btn-container mb-4 mx-3">
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-add btn-custom" id="addLocationRow">
                                                <i class="fas fa-plus"></i> Add another location to this territory
                                            </button>


                                            <button type="submit" class="btn btn-success my-3" id="AddNewLocation">
                                                New Location
                                            </button>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <!-- info section Start -->
                            <div class="info-section">
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>What is a territory?</h6>
                                    </div>
                                    <p>Territories define specific geographic regions that your company uses to organize and
                                        assign leads. For example, create a territory called “New England” that includes
                                        Massachusetts and Vermont, or “New York Metro” that includes everything within 25
                                        miles of New York City.</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>What can I do with territories?</h6>

                                    </div>
                                    <p>After you create one or more territories, you can use the Lead Distribution page to
                                        assign new leads in a territory to a specific user or team. You can also filter by
                                        territories from the leads, companies, or people tabs.</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Territory order</h6>

                                    </div>
                                    <p>Nutshell processes this list from the top down. Place your most precise territories
                                        at the top (e.g. cities and postal codes), and wider ranging territories at the
                                        bottom.</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Recalculating territories</h6>
                                    </div>
                                    <p>When you modify and save your territories, Nutshell will ask if you want to
                                        recalculate all territories using the new rules. Note that you can also manually
                                        change a person or company’s territory.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- All Companies Section End  -->
    </main>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '#addNewTerritoryLocation', function() {
                var row = $('.territory-card').first().clone(); // Clone only the first card
                row.find('input').val(''); // Clear inputs
                row.find('select').val(''); // Clear dropdowns
                $('.main-container').append(row); // Append as a new card, not inside existing one
            });


            // Remove a specific product row
            $(document).on('click', '.remove-territory-location-row', function() {
                if ($('.territory-card').length > 1) {
                    $(this).closest('.territory-card').remove();
                } else {
                    alert('At least one territory location row is required.');
                }
            });

            // Product row logic
            $('#addLocationRow').click(function() {
                var row = $('.location-row:first').clone(); // Clone the first row
                row.find('input').val(''); // Clear inputs
                row.find('select').val(''); // Clear dropdown
                $('#locationRowContainer').append(row); // Append to container
            });

            // Remove a specific product row
            $(document).on('click', '.remove-location-row', function() {
                if ($('.location-row').length > 1) {
                    $(this).closest('.location-row').remove();
                } else {
                    alert('At least one location row is required.');
                }
            });


            function toggleFields($row, type) {
                // Hide all fields with data-type
                $row.find('[data-type]').hide();

                // Show fields based on selected type
                switch (type) {
                    case 'country':
                        $row.find('[data-type="country"]').show();
                        break;
                    case 'state':
                        $row.find('[data-type="country"]').show();
                        $row.find('[data-type="state"]').show();
                        break;
                    case 'city':
                        $row.find('[data-type="country"]').show();
                        $row.find('[data-type="state"]').show();
                        $row.find('[data-type="city"]').show();
                        $row.find('[data-type="range"]').show();
                        break;
                    case 'postal':
                        $row.find('[data-type="country"]').show();
                        $row.find('[data-type="postal"]').show();
                        $row.find('[data-type="range"]').show();
                        break;
                    case 'area':
                        $row.find('[data-type="area"]').show();
                        break;
                }
            }

            // Trigger on page load for each location-row
            $('.location-row').each(function() {
                const selectedType = $(this).find('select[name="type"]').val();
                toggleFields($(this), selectedType);
            });

            // Change event
            $(document).on('change', 'select[name="type"]', function() {
                const $row = $(this).closest('.location-row');
                const selectedType = $(this).val();
                toggleFields($row, selectedType);
            });
        });
    </script>

    <script>
         $('#store_territory').submit(function(e) {
            e.preventDefault();

            // if (!$('#store_competitor').valid()) {
            //     return; // Stop if validation fails
            // }

            $.ajax({
                url: "{{ route('admin.settings.territory.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert('Territory added successfully!');
                    // $('#add_competitor').modal('hide');
                    console.log(response);
                    // location.reload();

                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                    toastr.error('Something went wrong while adding new territory.');
                }
            });
        });


    </script>

    {{-- Fetching list of countries , states and cities  --}}
    <script>
        $(document).on('change', 'select[name="country"]', function() {
            let $row = $(this).closest('.location-row');
            let countryId = $(this).val();

            if (countryId) {
                $.get(`/states/${countryId}`, function(data) {
                    let $stateSelect = $row.find('select[name="state_province"]');
                    let $citySelect = $row.find('select[name="city"]');

                    $stateSelect.empty().append('<option value="">Select State</option>');
                    $citySelect.empty().append('<option value="">Select City</option>');

                    $.each(data, function(i, state) {
                        $stateSelect.append(
                            `<option value="${state.state_id}">${state.name}</option>`);
                    });
                });
            }
        });

        $(document).on('change', 'select[name="state_province"]', function() {
            let $row = $(this).closest('.location-row');
            let stateId = $(this).val();

            if (stateId) {
                $.get(`/cities/${stateId}`, function(data) {
                    let $citySelect = $row.find('select[name="city"]');
                    $citySelect.empty().append('<option value="">Select City</option>');
                    $.each(data, function(i, city) {
                        $citySelect.append(`<option value="${city.id}">${city.name}</option>`);
                    });
                });
            }
        });
    </script>


    <script>
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
