         <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (new URLSearchParams(window.location.search).get('create') === '1') {
                $('#AddPerson').modal('show');
            }

            $('#AddPerson').on('shown.bs.modal', function() {
                $(this).find('.country_select').select2({
                    dropdownParent: $('#AddPerson'),
                    placeholder: 'Select Country',
                    allowClear: true
                });
                $(this).find('.state_select').select2({
                    dropdownParent: $('#AddPerson'),
                    placeholder: 'Select State',
                    allowClear: true
                });
                $(this).find('.city_select').select2({
                    dropdownParent: $('#AddPerson'),
                    placeholder: 'Select City',
                    allowClear: true
                });
                $('#add_person_company_select').select2({
                    dropdownParent: $('#AddPerson'),
                    placeholder: 'Select company',
                    allowClear: true
                });
                $(this).find('.country_select').trigger('change');
            });

        });


        $(document).ready(function() {

            // ========
            $("#add-person-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        strictEmail: true,
                        maxlength: 255
                    },
                    bio: {
                        required: true,
                        maxlength: 5000
                    },
                    company_id: {
                        required: false
                    },
                    phone: {
                        required: true,
                        phoneFormat: true,
                        maxlength: 50
                    },
                    address_1: {
                        required: true,
                        maxlength: 255
                    },
                    address_2: {
                        maxlength: 255
                    },
                    country_id: {
                        required: true
                    },
                    state_id: {
                        required: true
                    },
                    city_id: {
                        required: true
                    },
                    zip: {
                        required: true,
                        zipFormat: true
                    },
                    url: {
                        required: false,
                        url: true
                    },
                    tag_id: {
                        required: true
                    },
                    assignee_id: {
                        required: true
                    },
                    territory_id: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "Please enter the person's name."
                    },
                    email: {
                        required: "Please enter the email."
                    },
                    bio: {
                        required: "Please enter the bio."
                    },
                    // company_id: {
                    //     required: "Please select the company."
                    // },
                    address_1: {
                        required: "Please enter the address line 1."
                    },
                    country_id: {
                        required: "Please select a country."
                    },
                    state_id: {
                        required: "Please select a state."
                    },
                    city_id: {
                        required: "Please select a city."
                    },
                    zip: {
                        required: "Please enter the zip code."
                    },
                    phone: {
                        required: "Please enter the phone number."
                    },
                    url: {
                        url: "The url field must be a valid URL."
                    },
                    tag_id: {
                        required: "Please select a tag."
                    },
                    assignee_id: {
                        required: "Please select an assignee."
                    },
                    territory_id: {
                        required: "Please select a territory."
                    }


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
                    } else if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container')); // Below the select2 box
                    } else {
                        error.insertAfter(element); // Default
                    }
                }
            });


            // select2 fields do not fire the click/blur events jQuery Validate listens to: re-check them on change
            $('#add-person-form').on('change', '.country_select, .state_select, .city_select', function() {
                if ($(this).hasClass('is-invalid')) {
                    $(this).valid();
                }
            });

            // Submit People form
            $('#add-person-form').submit(function(e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');

                if (!$form.valid()) return;

                $.ajax({
                    url: '{{ route('admin.people.store') }}',
                    method: 'POST',
                    data: $form.serialize(),

                    beforeSend: function() {
                        $submitBtn.prop('disabled', true).text('Saving...');
                    },

                    success: function() {
                        toastr.success('Person created successfully! Redirecting...');
                        $form[0].reset();

                        setTimeout(() => {
                            window.location.href = "{{ route('admin.people.index') }}";
                        }, 1500);
                    },

                    error: function(xhr) {
                        console.log(xhr.responseText);
                        var message = 'Something went wrong while adding the person.';
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            message = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                        toastr.error(message);
                        $submitBtn.prop('disabled', false).text('Submit');
                    }
                });
            });

        // Address cascades for Add Location structures
        $('.country_select').on('change', function() {
            let countryId = $(this).val();
            let modal = $(this).closest('.modal');
            let stateSelect = modal.find('.state_select');
            let citySelect = modal.find('.city_select');

            stateSelect.empty().append('<option value="">Select State</option>').trigger('change');
            citySelect.empty().append('<option value="">Select City</option>').trigger('change');

            if (!countryId) return;
            $.get(`/states/` + countryId, function(states) {
                $.each(states, function(i, state) {
                    stateSelect.append(`<option value="` + state.state_id + `">` + state.name + `</option>`);
                });
                if (countryId == 233) {
                    stateSelect.val('1407').trigger('change');
                }
            });
        });

        $('.state_select').on('change', function() {
            let stateId = $(this).val();
            let modal = $(this).closest('.modal');
            let citySelect = modal.find('.city_select');

            citySelect.empty().append('<option value="">Select City</option>').trigger('change');
            if (!stateId) return;
            $.get(`/cities/` + stateId, function(cities) {
                $.each(cities, function(i, city) {
                    citySelect.append(`<option value="` + city.id + `">` + city.name + `</option>`);
                });
            });
        });
    });
    </script>
