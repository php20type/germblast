(() => {
    // app-sidebar toggle js
    const toggleButton = document.getElementById("menu-toggle");
    const sidebar = document.querySelector(".app-sidebar");
    const mainContent = document.querySelector(".main-content.app-content");
    const closeButton = document.getElementById("close");

    if (toggleButton) {
        toggleButton.addEventListener("click", function () {
            sidebar.classList.toggle("hidden");
            mainContent.classList.toggle("full-width");
        });
    }

    if (closeButton) {
        closeButton.addEventListener("click", function () {
            sidebar.classList.remove("hidden");
        });
    }

    // Scroll active sidebar menu item into view
    const activeSidebarItem = document.querySelector(".app-sidebar li.active");
    if (activeSidebarItem) {
        // Run immediately to capture early rendering
        activeSidebarItem.scrollIntoView({ behavior: "auto", block: "center" });
        // Also run after layout stabilization to guarantee visibility on heavy layout shifts
        setTimeout(() => {
            activeSidebarItem.scrollIntoView({ behavior: "auto", block: "center" });
        }, 100);
    }

    // Handle checkbox selection
    const selectAllCheckbox = document.getElementById('selectAll');
    const tableBody = document.querySelector('table tbody');
    const actionBar = document.getElementById('actionBar');
    const selectedCount = document.getElementById('selectedCount');

    function updateActionBar() {
        if (!actionBar || !selectedCount) return;

        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        if (checkedBoxes.length > 0) {
            actionBar.classList.add('show');
            selectedCount.textContent = checkedBoxes.length;
        } else {
            actionBar.classList.remove('show');
        }
    }

    updateActionBar();

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            if (!tableBody) return;
            const rowCheckboxes = tableBody.querySelectorAll('.row-checkbox');
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateActionBar();
        });
    }

    if (tableBody) {
        tableBody.addEventListener('change', function(e) {
            if (!e.target.classList.contains('row-checkbox')) return;

            updateActionBar();

            const rowCheckboxes = tableBody.querySelectorAll('.row-checkbox');
            const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(rowCheckboxes).some(cb => cb.checked);

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
        });

        tableBody.addEventListener('mouseenter', function(e) {
            const row = e.target.closest('tr');
            if (row) row.style.backgroundColor = '#f8f9fa';
        }, true);

        tableBody.addEventListener('mouseleave', function(e) {
            const row = e.target.closest('tr');
            if (row) row.style.backgroundColor = '';
        }, true);
    }
})();

// Global Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('globalSearchInput');
    const searchResults = document.getElementById('globalSearchResults');
    let debounceTimer;

    if (!searchInput || !searchResults) return;

    // Get the search URL from the data attribute
    const searchUrl = searchInput.getAttribute('data-search-url');
    if (!searchUrl) return;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            searchResults.innerHTML = '';
            searchResults.classList.remove('active');
            return;
        }

        searchResults.innerHTML = '<div class="search-results-loading"><i class="fa-solid fa-spinner fa-spin me-2"></i>Searching...</div>';
        searchResults.classList.add('active');

        debounceTimer = setTimeout(function() {
            fetch(searchUrl + "?query=" + encodeURIComponent(query), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                let html = '';
                let hasResults = false;

                // Group 1: Companies
                if (data.companies && data.companies.length > 0) {
                    hasResults = true;
                    html += '<div class="search-results-group">Companies</div>';
                    data.companies.forEach(function(item) {
                        html += `<a href="${item.url}" class="search-results-item">
                            <i class="fa-solid fa-building"></i>
                            <span>${item.name}</span>
                        </a>`;
                    });
                }

                // Group 2: People
                if (data.people && data.people.length > 0) {
                    hasResults = true;
                    html += '<div class="search-results-group">People</div>';
                    data.people.forEach(function(item) {
                        html += `<a href="${item.url}" class="search-results-item">
                            <i class="fa-solid fa-user"></i>
                            <span>${item.name}</span>
                        </a>`;
                    });
                }

                // Group 3: Leads
                if (data.leads && data.leads.length > 0) {
                    hasResults = true;
                    html += '<div class="search-results-group">Leads</div>';
                    data.leads.forEach(function(item) {
                        html += `<a href="${item.url}" class="search-results-item">
                            <i class="fa-solid fa-bullhorn"></i>
                            <span>${item.name}</span>
                        </a>`;
                    });
                }

                if (!hasResults) {
                    html = `<div class="search-results-empty">No results found for "${query}"</div>`;
                }

                searchResults.innerHTML = html;
                searchResults.classList.add('active');
            })
            .catch(error => {
                console.error('Error during search:', error);
                searchResults.innerHTML = '<div class="search-results-empty text-danger">An error occurred while searching.</div>';
                searchResults.classList.add('active');
            });
        }, 300);
    });

    // Close search dropdown on click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-bar')) {
            searchResults.classList.remove('active');
        }
    });

    // Re-show dropdown if input is focused and has text
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) {
            searchResults.classList.add('active');
        }
    });

    // Close dropdown on escape key
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchResults.classList.remove('active');
            searchInput.blur();
        }
    });
});

// ==========================================
// Global AJAX Setup for Loaders and Delays
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    if (typeof jQuery !== 'undefined') {
        var originalAjax = jQuery.ajax;
        jQuery.ajax = function() {
            var options = arguments[0];
            if (typeof options === "string") {
                options = arguments[1] || {};
                options.url = arguments[0];
            }

            var method = (options.method || options.type || 'GET').toUpperCase();

            // Skip loader for background/search GET requests
            var isSearch = false;
            var url = options.url || '';
            if (typeof url === 'string' && url.includes('/search')) {
                isSearch = true;
            }
            if (options.global === false) {
                isSearch = true;
            }
            if (options.data) {
                if (typeof options.data === 'string' && options.data.includes('search=')) {
                    isSearch = true;
                } else if (typeof options.data === 'object' && ('search' in options.data)) {
                    isSearch = true;
                }
            }

            // For search GET requests, run immediately without loader/delay
            if (method === 'GET' && isSearch) {
                // Mock AppLoader to prevent explicit calls in views
                if (typeof AppLoader !== 'undefined') {
                    var _origBeforeSend = options.beforeSend;
                    var _origComplete = options.complete;
                    if (_origBeforeSend) {
                        options.beforeSend = function() {
                            var _show = AppLoader.show;
                            AppLoader.show = function(){};
                            var ret = _origBeforeSend.apply(this, arguments);
                            AppLoader.show = _show;
                            return ret;
                        };
                    }
                    if (_origComplete) {
                        options.complete = function() {
                            var _hide = AppLoader.hide;
                            AppLoader.hide = function(){};
                            var ret = _origComplete.apply(this, arguments);
                            AppLoader.hide = _hide;
                            return ret;
                        };
                    }
                }
                return originalAjax.apply(this, arguments);
            }

            // Show loader immediately
            if (typeof AppLoader !== 'undefined') {
                AppLoader.show();
            }

            // Wrap success to hide loader before original success runs
            var origSuccess = options.success;
            if (origSuccess) {
                options.success = function() {
                    if (typeof AppLoader !== 'undefined') {
                        AppLoader.hide();
                    }
                    return origSuccess.apply(this, arguments);
                };
            }

            // Wrap error to hide loader before original error runs
            var origError = options.error;
            if (origError) {
                options.error = function() {
                    if (typeof AppLoader !== 'undefined') {
                        AppLoader.hide();
                    }
                    return origError.apply(this, arguments);
                };
            }

            var dfd = jQuery.Deferred();
            var self = this;
            var args = arguments;

            // Delay 300ms
            setTimeout(function() {
                // Directly pass the normalized options object instead of args
                var jqXHR = originalAjax.call(self, options);

                jqXHR.done(function() {
                    if (typeof AppLoader !== 'undefined') {
                        AppLoader.hide(); // Hide if success wasn't in options
                    }
                    dfd.resolveWith(this, arguments);
                }).fail(function() {
                    if (typeof AppLoader !== 'undefined') {
                        AppLoader.hide(); // Hide if error wasn't in options
                    }
                    dfd.rejectWith(this, arguments);
                });
            }, 300);

            var promise = dfd.promise();
            promise.success = promise.done;
            promise.error = promise.fail;

            promise.abort = function() {
                if (typeof AppLoader !== 'undefined') {
                    AppLoader.hide();
                }
                dfd.reject();
            };
            return promise;
        };
    }

    // ==========================================
    // Global fetch Setup for Loaders and Delays
    // ==========================================
    if (typeof window.fetch !== 'undefined') {
        var originalFetch = window.fetch;
        window.fetch = function() {
            var args = arguments;
            var options = args[1] || {};
            var method = (options.method || 'GET').toUpperCase();

            var url = typeof args[0] === 'string' ? args[0] : (args[0] ? args[0].url : '');
            var isSearch = false;
            if (typeof url === 'string' && url.includes('/search')) {
                isSearch = true;
            }

            // For search GET requests, run immediately without loader/delay
            if (method === 'GET' && isSearch) {
                return originalFetch.apply(this, args);
            }

            // Show loader immediately
            if (typeof AppLoader !== 'undefined') {
                AppLoader.show();
            }

            return new Promise(function(resolve, reject) {
                setTimeout(function() {
                    originalFetch.apply(window, args)
                        .then(function(response) {
                            if (typeof AppLoader !== 'undefined') {
                                AppLoader.hide();
                            }
                            resolve(response);
                        })
                        .catch(function(error) {
                            if (typeof AppLoader !== 'undefined') {
                                AppLoader.hide();
                            }
                            reject(error);
                        });
                }, 300);
            });
        };
    }
});

// Global Modal Form Reset
// Ensure any form inside a modal is reset when the modal is closed,
// and any validation states are cleared.
$(document).on('hidden.bs.modal', '.modal', function () {
    const form = $(this).find('form');
    if (form.length) {
        // Standard form reset
        form[0].reset();

        // Remove validation error classes and messages
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
        form.find('.error').text('');

        // Reset select2 fields without triggering other change events
        if ($.fn.select2) {
            form.find('.select2, select').trigger('change.select2');
        }
    }
});

// Timeline filters (company, people, lead details): fixed-width Select2 so long option text wraps
$(function () {
    if (!$.fn.select2) return;

    var widths = { 'filter-range': '150px', 'filter-activity': '280px', 'filter-user': '180px' };

    $('.company-details-section .filter-section select.dropdown-orange').each(function () {
        $(this).select2({
            width: widths[this.id] || '200px',
            minimumResultsForSearch: Infinity,
            dropdownCssClass: 'timeline-filter-dropdown'
        });
    });
});

// Multi-select Select2: use the dedicated search box inside the dropdown (like single selects)
// instead of the inline search field in the selection box
(function () {
    if (!$.fn.select2 || !$.fn.select2.amd) return;

    try {
        var req = $.fn.select2.amd.require;
        var Utils = req('select2/utils');
        var Dropdown = req('select2/dropdown');
        var DropdownSearch = req('select2/dropdown/search');
        var CloseOnSelect = req('select2/dropdown/closeOnSelect');
        var AttachBody = req('select2/dropdown/attachBody');
        var defaults = $.fn.select2.defaults;
        var applyDefaults = defaults.apply;

        defaults.apply = function (options) {
            if (options.multiple && options.dropdownAdapter == null) {
                var adapter = Utils.Decorate(Dropdown, DropdownSearch);

                if (options.closeOnSelect == null || options.closeOnSelect) {
                    adapter = Utils.Decorate(adapter, CloseOnSelect);
                }

                options.dropdownAdapter = Utils.Decorate(adapter, AttachBody);
            }

            return applyDefaults.call(this, options);
        };
    } catch (e) {
        // Fall back to Select2's default multi-select behaviour
    }
})();

// Datepicker / timepicker: every standard date and time input uses flatpickr (same as the other date fields).
// The values stay Y-m-d and H:i, so submitted data, validation and min/max rules behave as before.
(function () {
    if (typeof flatpickr === 'undefined') return;

    // jQuery Validate skips hidden inputs; the real (hidden) date-time input must still be validated
    if ($.validator) {
        $.validator.setDefaults({ ignore: ':hidden:not(.datepicker-source)' });
    }

    function initDateInput(input) {
        if (input._flatpickr || input.dataset.nativeDate !== undefined) return;

        var value = input.value;
        var options = {
            dateFormat: 'Y-m-d',
            allowInput: true,
            time_24hr: false,
            onOpen: function (selectedDates, dateStr, instance) {
                // Pick up values that scripts set directly on the input
                if (instance.input.value && instance.input.value !== dateStr) {
                    instance.setDate(instance.input.value, false);
                }
            }
        };

        if (input.getAttribute('min')) options.minDate = input.getAttribute('min');
        if (input.getAttribute('max')) options.maxDate = input.getAttribute('max');

        input.type = 'text';
        input.value = value;
        input.setAttribute('autocomplete', 'off');
        if (!input.getAttribute('placeholder')) input.setAttribute('placeholder', 'Select date');

        var picker = flatpickr(input, options);

        // Dates are picked from the calendar (not typed), like the existing datepicker fields.
        // Not readonly, so the required attribute is still enforced on submit.
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Tab' || e.key === 'Escape') return;
            if (e.key === 'Backspace' || e.key === 'Delete') {
                e.preventDefault();
                picker.clear();
                return;
            }
            e.preventDefault();
        });

        // Keep the calendar limits in step with min/max changes made by page scripts
        new MutationObserver(function () {
            picker.set('minDate', input.getAttribute('min') || null);
            picker.set('maxDate', input.getAttribute('max') || null);
        }).observe(input, { attributes: true, attributeFilter: ['min', 'max'] });
    }

    function initTimeInput(input) {
        if (input._flatpickr || input.dataset.nativeTime !== undefined) return;

        var value = input.value;
        var options = {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            allowInput: true,
            onOpen: function (selectedDates, dateStr, instance) {
                // Pick up values that scripts set directly on the input
                if (instance.input.value && instance.input.value !== dateStr) {
                    instance.setDate(instance.input.value, false);
                }
            }
        };

        if (input.getAttribute('min')) options.minTime = input.getAttribute('min');
        if (input.getAttribute('max')) options.maxTime = input.getAttribute('max');

        // step is in seconds on a time input; the picker steps in minutes
        var step = parseInt(input.getAttribute('step'), 10);
        if (step >= 60 && step % 60 === 0) options.minuteIncrement = step / 60;

        input.type = 'text';
        input.value = value;
        input.setAttribute('autocomplete', 'off');
        if (!input.getAttribute('placeholder')) input.setAttribute('placeholder', 'Select time');

        var picker = flatpickr(input, options);

        // Times are picked from the picker (not typed), like the existing datepicker fields.
        // Not readonly, so the required attribute is still enforced on submit.
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Tab' || e.key === 'Escape') return;
            if (e.key === 'Backspace' || e.key === 'Delete') {
                e.preventDefault();
                picker.clear();
                return;
            }
            e.preventDefault();
        });

        // Keep the limits in step with min/max changes made by page scripts
        new MutationObserver(function () {
            picker.set('minTime', input.getAttribute('min') || null);
            picker.set('maxTime', input.getAttribute('max') || null);
        }).observe(input, { attributes: true, attributeFilter: ['min', 'max'] });
    }

    function initDateTimeInput(input) {
        if (input._flatpickr || input.dataset.nativeTime !== undefined) return;

        var value = input.value;
        var options = {
            enableTime: true,
            dateFormat: 'Y-m-d\\TH:i', // real value: same format as a datetime-local input
            altInput: true,
            altFormat: 'Y-m-d h:i K', // shown value: same as the existing task due date picker
            time_24hr: false,
            allowInput: true
        };

        if (input.getAttribute('min')) options.minDate = input.getAttribute('min');
        if (input.getAttribute('max')) options.maxDate = input.getAttribute('max');

        input.type = 'text';
        input.value = value;
        input.classList.add('datepicker-source');
        if (!input.getAttribute('placeholder')) input.setAttribute('placeholder', 'Select date & time');

        var picker = flatpickr(input, options);
        var visible = picker.altInput;

        // Show the visible field first so validation messages appear below it
        input.parentNode.insertBefore(visible, input);
        visible.setAttribute('autocomplete', 'off');

        // Picked from the calendar (not typed), like the other picker fields.
        // Not readonly, so the required attribute is still enforced on submit.
        visible.addEventListener('keydown', function (e) {
            if (e.key === 'Tab' || e.key === 'Escape') return;
            if (e.key === 'Backspace' || e.key === 'Delete') {
                e.preventDefault();
                picker.clear();
                return;
            }
            e.preventDefault();
        });

        // Scripts that set the value directly (e.g. $('#x').val('2026-01-01T10:00')) update the visible field too
        var nativeValue = Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value');
        var syncing = false;
        Object.defineProperty(input, 'value', {
            configurable: true,
            get: function () {
                return nativeValue.get.call(this);
            },
            set: function (v) {
                nativeValue.set.call(this, v);
                if (syncing) return;

                // Skip when the picker itself is the one setting the value
                var current = picker.selectedDates[0] ? picker.formatDate(picker.selectedDates[0], options.dateFormat) : '';
                if ((v || '') === current) return;

                syncing = true;
                picker.setDate(v || null, false);
                syncing = false;
            }
        });

        // Keep the limits in step with min/max changes made by page scripts
        new MutationObserver(function () {
            picker.set('minDate', input.getAttribute('min') || null);
            picker.set('maxDate', input.getAttribute('max') || null);
        }).observe(input, { attributes: true, attributeFilter: ['min', 'max'] });
    }

    function initPickerInput(input) {
        try {
            if (input.type === 'time') {
                initTimeInput(input);
            } else if (input.type === 'date') {
                initDateInput(input);
            } else if (input.type === 'datetime-local') {
                initDateTimeInput(input);
            }
        } catch (e) {
            // One problem field must not stop the others from being converted
            console.error('Date/time picker init failed for', input, e);
        }
    }

    function initDateInputs(root) {
        var scope = root && root.querySelectorAll ? root : document;

        var selector = 'input[type="date"], input[type="time"], input[type="datetime-local"]';

        if (scope.matches && scope.matches(selector)) initPickerInput(scope);

        scope.querySelectorAll(selector).forEach(initPickerInput);
    }

    $(function () {
        initDateInputs(document);

        // Inputs added later (modals, AJAX-loaded content)
        new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                mutation.addedNodes.forEach(function (node) {
                    if (node.nodeType === 1) initDateInputs(node);
                });
            });
        }).observe(document.body, { childList: true, subtree: true });
    });
})();

// Shared jQuery Validate rules for contact details (same limits as the server rules App\Rules\StrictEmail,
// PhoneNumber and PostalCode). Use them as: email: { strictEmail: true }, phone: { phoneFormat: true }, zip: { zipFormat: true }
(function () {
    if (!$.validator) return;

    // name@company.com (jQuery's built-in "email" rule also accepts name@company)
    $.validator.addMethod('strictEmail', function (value, element) {
        return this.optional(element) || /^[^\s@]+@[^\s@]+\.[A-Za-z]{2,}$/.test(value);
    }, 'Please enter a valid email address.');

    // 7 to 15 digits; spaces, dashes, dots, brackets and a leading + are allowed
    $.validator.addMethod('phoneFormat', function (value, element) {
        if (this.optional(element)) return true;
        if (!/^\+?[0-9\s().\-]+$/.test(value)) return false;
        var digits = value.replace(/\D/g, '').length;
        return digits >= 7 && digits <= 15;
    }, 'Please enter a valid phone number.');

    // 3 to 10 characters: letters, digits, spaces and dashes
    $.validator.addMethod('zipFormat', function (value, element) {
        return this.optional(element) || /^[A-Za-z0-9][A-Za-z0-9 \-]{1,8}[A-Za-z0-9]$/.test(value);
    }, 'Please enter a valid zip / postal code.');
})();
