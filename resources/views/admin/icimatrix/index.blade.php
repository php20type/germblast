@extends('admin.includes.layout')

@section('title', 'ICIMatrix')

@section('content')


    <main class="app-wrapper">
            <!-- All Companies Section start  -->
            <div class="profile-section my-4">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Sidebar -->
                        @include('admin.icimatrix.sidebar')
                    </div>
                </div>
            </div>
    </main>

@endsection

@push('scripts')
    <script>
        function toggleDropdown(section) {
            const sections = ['sales', 'operations','humanResources'];

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
