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
