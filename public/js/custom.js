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


