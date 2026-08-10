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
                        required: true
                    },
                    email: {
                        required: true
                    },
                    bio: {
                        required: true
                    },
                    company_id: {
                        required: false
                    },
                    phone: {
                        required: true
                    },
                    address: {
                        required: true
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
                        required: "Please enter Company name."
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
                    phone: {
                        required: "Please enter the phone number."
                    },
                    address: {
                        required: "Please enter the address."
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
                    } else {
                        error.insertAfter(element); // Default
                    }
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
                        toastr.error('Something went wrong while adding the person.');
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

            stateSelect.empty().append('<option value="">Select State</option>').prop('disabled', true).trigger('change');
            citySelect.empty().append('<option value="">Select City</option>').prop('disabled', true).trigger('change');

            if (!countryId) return;
            $.get(`/states/` + countryId, function(states) {
                stateSelect.prop('disabled', false);
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

            citySelect.empty().append('<option value="">Select City</option>').prop('disabled', true).trigger('change');
            if (!stateId) return;
            $.get(`/cities/` + stateId, function(cities) {
                citySelect.prop('disabled', false);
                $.each(cities, function(i, city) {
                    citySelect.append(`<option value="` + city.id + `">` + city.name + `</option>`);
                });
            });
        });
    });
    </script>
