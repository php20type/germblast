@extends('admin.includes.layout')

@section('title', 'Markets')

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
                            <div class="heading-area-sec">
                                <div class="left-part-sec">
                                    <h3 class="mb-1 fw-bold">MARKETS</h3>
                                    <p class="text-muted mb-0">Choose what currencies are available in your account.</p>
                                </div>
                                <hr>
                            </div>

                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">MARKETS ({{ $totalCounts }})</h6>
                                    <a href="javascript:void(0);" class="btn-add-activity" id="toggleAddMarket"
                                        onclick="addMarket()">Add Market</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Currency</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($markets as $market)
                                                <tr>
                                                    <td>{{ $market->name }}</td>
                                                    <td>{{ $market->currency->code }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="info-section">
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>WHAT IS A MARKET?</h6>
                                    </div>
                                    <p>Products have unique pricing for each market. Each lead has a specific market, so
                                        attached products receive the appropriate pricing.</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>MULTIPLE CURRENCIES</h6>
                                    </div>
                                    <p>Every market can use a different currency. Define a market with your currency type,
                                        then edit product pricing for that market.</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>DEFAULT MARKETS</h6>
                                    </div>
                                    <p>Every user can set a default market in their My Account page. When they create a new
                                        lead, it will default to this setting.</p>
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
                                    <label class="form-label">Name</label>
                                    <input type="text" placeholder="" name="name" class="form-control" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Currency</label>
                                    <select name="currency_id" id="currency_id" class="form-select">
                                        <option value="">-- Select Currency --</option>
                                        @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 d-none">
                                <div class="form-group">
                                    <label class="form-label">Code</label>
                                    <input type="text" placeholder="" name="code" class="form-control" />
                                </div>
                            </div>

                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="AddCompetitor">New Market</button>
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

        $("#store_market").validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
                currency_id: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please enter the market name."
                },
                currency_id: {
                    required: "Please select the currency."
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
                    error.insertAfter(element.parent()); // Inserts after the .input-group
                } else {
                    error.insertAfter(element); // Default
                }
            }
        });


        $('#store_market').submit(function(e) {
            e.preventDefault();

            if (!$('#store_market').valid()) {
                return; // Stop if validation fails
            }

            $.ajax({
                url: "{{ route('admin.settings.market.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert('Market added successfully!');
                    $('#add_market').modal('hide');
                    console.log(response);
                    location.reload();

                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                    toastr.error('Something went wrong while adding new market.');
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
