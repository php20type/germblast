// app-sidebar toggle js
const toggleButton = document.getElementById("menu-toggle");
const sidebar = document.querySelector(".app-sidebar");
const mainContent = document.querySelector(".main-content.app-content");
const closeButton = document.getElementById("close");

toggleButton.addEventListener("click", function () {
    sidebar.classList.toggle("hidden");
    mainContent.classList.toggle("full-width");
});

closeButton.addEventListener("click", function () {
    sidebar.classList.remove("hidden");
});


// Handle checkbox selection
const selectAllCheckbox = document.getElementById('selectAll');
const rowCheckboxes = document.querySelectorAll('.row-checkbox');
const actionBar = document.getElementById('actionBar');
const selectedCount = document.getElementById('selectedCount');

function updateActionBar() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkedBoxes.length > 0) {
        actionBar.classList.add('show');
        selectedCount.textContent = checkedBoxes.length;
    } else {
        actionBar.classList.remove('show');
    }
}

// Initialize with first row checked
updateActionBar();

selectAllCheckbox.addEventListener('change', function () {
    rowCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateActionBar();
});

rowCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(rowCheckboxes).some(cb => cb.checked);

        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;

        updateActionBar();
    });
});

// Table row hover effects
const tableRows = document.querySelectorAll('tbody tr');
tableRows.forEach(row => {
    row.addEventListener('mouseenter', function () {
        this.style.backgroundColor = '#f8f9fa';
    });
    row.addEventListener('mouseleave', function () {
        this.style.backgroundColor = '';
    });
});
