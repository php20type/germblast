    {{-- Scripts of the Add Lead modal (add-lead-modal): validation, product rows and submission, for every page that shows the modal. --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if ($('#add-lead-form').data('open-on-create') == 1 && new URLSearchParams(window.location.search).get('create') === '1') {
                $('#AddLead').modal('show');
            }

            //  Select2 script
            $('#AddLead').on('shown.bs.modal', function() {
                $('#companySelect').select2({
                    dropdownParent: $('#AddLead'),
                    placeholder: '-- Select a company --',
                    allowClear: true
                });
                $('#person_select').select2({
                    dropdownParent: $('#AddLead'),
                    placeholder: '-- Select a person --',
                    allowClear: true
                });
                $('#source_select').select2({
                    dropdownParent: $('#AddLead'),
                    placeholder: 'Choose...',
                    allowClear: true
                });
                $('#competitor_select').select2({
                    dropdownParent: $('#AddLead'),
                    placeholder: 'Choose...',
                    allowClear: true

                });
            });

        });


        $(document).ready(function() {

            var $leadForm = $('#add-lead-form');
            var companyField = $leadForm.data('company-multiple') == 1 ? 'company_id[]' : 'company_id';
            var afterSave = $leadForm.data('after-save'); // redirect | close | reload

            // Product row logic
            $('#addProductRow').click(function() {
                var row = $('.product-row:first').clone(); // Clone the first row
                row.find('input').val(''); // Clear inputs
                row.find('select').val(''); // Clear dropdown
                $('#productRowContainer').append(row); // Append to container
            });

            // Remove a specific product row
            $(document).on('click', '.remove-product-row', function() {
                if ($('.product-row').length > 1) {
                    $(this).closest('.product-row').remove();
                } else {
                    alert('At least one product row is required.');
                }
            });

            var leadRules = {
                name: {
                    required: true,
                    maxlength: 255
                },
                assignee_id: {
                    required: true
                },
                close_date: {
                    required: true
                },
                "product_id[]": {
                    required: true
                },
                "quantity[]": {
                    required: true,
                    number: true,
                    min: 1
                },
                "price[]": {
                    required: true,
                    number: true,
                    min: 0
                },
                confidence: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 100
                },
                "person_id[]": {
                    required: true
                },
                "source_id[]": {
                    required: true
                },
                "competitors_id[]": {
                    required: true
                },
                tag_id: {
                    required: true
                }
            };
            leadRules[companyField] = {
                required: true
            };

            var leadMessages = {
                name: {
                    required: "Please enter lead name."
                },
                assignee_id: {
                    required: "Please select an assignee."
                },
                close_date: {
                    required: "Please select a close date."
                },
                "product_id[]": {
                    required: "Please select a product."
                },
                "quantity[]": {
                    required: "Please enter the quantity."
                },
                "price[]": {
                    required: "Please enter the price."
                },
                confidence: {
                    required: "Please enter the confidence level."
                },
                "person_id[]": {
                    required: "Please select a person."
                },
                "source_id[]": {
                    required: "Please select a source."
                },
                "competitors_id[]": {
                    required: "Please select a competitor."
                },
                tag_id: {
                    required: "Please select the tag."
                }
            };
            leadMessages[companyField] = {
                required: "Please select a company."
            };

            $("#add-lead-form").validate({
                ignore: [],
                rules: leadRules,
                messages: leadMessages,
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

            // Extra product rows: jQuery Validate only checks the first field of a repeated name (product_id[] ...),
            // so the rows added with "Add New Product" are checked here.
            function validateLeadProductRows($form) {
                var ok = true;
                $form.find('.product-row-error').remove();
                $form.find('.product-row').not(':first').each(function() {
                    var checks = [
                        ['select[name="product_id[]"]', 'Please select a product.', null],
                        ['input[name="quantity[]"]', 'Please enter the quantity.', 1],
                        ['input[name="price[]"]', 'Please enter the price.', 0]
                    ];
                    var $row = $(this);
                    $.each(checks, function(i, c) {
                        var $field = $row.find(c[0]);
                        var value = $.trim($field.val());
                        var message = '';
                        if (value === '') {
                            message = c[1];
                        } else if (c[2] !== null && (isNaN(value) || parseFloat(value) < c[2])) {
                            message = 'Please enter a value greater than or equal to ' + c[2] + '.';
                        }
                        if (message) {
                            ok = false;
                            $field.addClass('is-invalid');
                            $('<span class="product-row-error invalid-feedback d-block"></span>').text(message).insertAfter($field);
                        } else {
                            $field.removeClass('is-invalid');
                        }
                    });
                });
                return ok;
            }

            $(document).on('input change', '.product-row select, .product-row input', function() {
                $(this).removeClass('is-invalid').next('.product-row-error').remove();
            });

            // select2 fields do not fire the click/blur events jQuery Validate listens to: re-check them on change
            $leadForm.on('change', '#companySelect, #person_select, #source_select, #competitor_select', function() {
                if ($(this).hasClass('is-invalid')) {
                    $(this).valid();
                }
            });


            // Submit Lead form
            $leadForm.submit(function(e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');

                var leadValid = $form.valid();
                var rowsValid = validateLeadProductRows($form);
                if (!leadValid || !rowsValid) return;

                $.ajax({
                    url: '{{ route('admin.lead.store') }}',
                    method: 'POST',
                    data: $form.serialize(),

                    beforeSend: function() {
                        $submitBtn.prop('disabled', true).text('Saving...');
                    },

                    success: function() {
                        if (afterSave === 'redirect') {
                            toastr.success('Lead created successfully! Redirecting...');
                            $form[0].reset();

                            setTimeout(function() {
                                window.location.href = "{{ route('admin.lead.index') }}";
                            }, 1500);
                            return;
                        }

                        toastr.success('Lead created successfully!');
                        $form[0].reset();
                        $submitBtn.prop('disabled', false).text('Create lead');
                        $('#AddLead').modal('hide');
                        if (afterSave === 'reload') {
                            location.reload();
                        }
                    },

                    error: function(xhr) {
                        alert(xhr.responseText);
                        var message = 'Something went wrong while creating the lead.';
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            message = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                        toastr.error(message);
                        $submitBtn.prop('disabled', false).text('Create lead');
                    }
                });
            });

        });

    </script>
