@extends('admin.includes.layout')

@section('title', 'Dashboard')

@section('content')

    <!-- dashboard card start  -->
    <div class="dashboard-card my-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <!-- Top Row -->
                @can('company.create')
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module" style="cursor: pointer;" onclick="window.location.href='{{ route('admin.company.index') }}'">
                        <div class="icon-wrapper icon-company">
                            <img src={{ asset('img/icons/dashboard-app1.png') }} alt="app icon" />
                            <h5 class="card-title">COMPANY</h5>
                        </div>
                        <p class="card-text mb-1">{{ $companies->count() }} Total Companies</p>
                        <p class="card-text text-muted" style="font-size: 13px;">{{ $monthly_companies }} new this month</p>
                        <div class="mt-3">
                            <canvas class="trend-chart" data-trend="company" height="50"></canvas>
                        </div>
                    </div>
                </div>
                @endcan

                @can('people.create')
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module" style="cursor: pointer;" onclick="window.location.href='{{ route('admin.people.index') }}'">
                        <div class="icon-wrapper icon-person">
                            <img src={{ asset('img/icons/dashboard-app2.png') }} alt="app icon" />
                            <h5 class="card-title">PERSON</h5>
                        </div>
                        <p class="card-text mb-1">{{ $peoples->count() }} Total People</p>
                        <p class="card-text text-muted" style="font-size: 13px;">{{ $monthly_peoples }} new this month</p>
                        <div class="mt-3">
                            <canvas class="trend-chart" data-trend="person" height="50"></canvas>
                        </div>
                    </div>
                </div>
                @endcan

                @can('lead.create')
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module" style="cursor: pointer;" onclick="window.location.href='{{ route('admin.lead.index') }}'">
                        <div class="icon-wrapper icon-lead">
                            <img src={{ asset('img/icons/dashboard-app3.png') }} alt="app icon" />
                            <h5 class="card-title">LEAD</h5>
                        </div>
                        <p class="card-text mb-1">{{ $leads->count() }} Total Leads</p>
                        <p class="card-text text-muted" style="font-size: 13px;">{{ $monthly_leads }} new this month</p>
                        <div class="mt-3">
                            <canvas class="trend-chart" data-trend="lead" height="50"></canvas>
                        </div>
                    </div>
                </div>
                @endcan

                {{-- <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module">
                        <div class="icon-wrapper icon-activity">
                            <img src={{ asset('img/icons/dashboard-app4.png') }} alt="app icon" />
                            <h5 class="card-title">ACTIVITY</h5>
                        </div>
                        <p class="card-text">{{ \App\Models\Activity::count() }} Activities</p>
                    </div>
                </div> --}}

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module">
                        <div class="icon-wrapper icon-task">
                            <img src={{ asset('img/icons/dashboard-app5.png') }} alt="app icon" />
                            <h5 class="card-title">TASK</h5>
                        </div>
                        <p class="card-text mb-1">{{ \App\Models\Task::whereNull('completed_time')->count() }} Incomplete Tasks</p>
                        <p class="card-text text-muted" style="font-size: 13px;">{{ $monthly_tasks }} new this month</p>
                        <div class="mt-3">
                            <canvas class="trend-chart" data-trend="task" height="50"></canvas>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- dashboard card End  -->

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const labels = @json($trend_labels);
            const trends = @json($trends);
            const colors = {
                company: ['#6f42c1', 'rgba(111, 66, 193, 0.1)', 'Companies'],
                person: ['#0d6efd', 'rgba(13, 110, 253, 0.1)', 'People'],
                lead: ['#198754', 'rgba(25, 135, 84, 0.1)', 'Leads'],
                task: ['#dc3545', 'rgba(220, 53, 69, 0.1)', 'Tasks']
            };

            document.querySelectorAll('.trend-chart').forEach(function(canvas) {
                const key = canvas.dataset.trend;
                const [line, fill, name] = colors[key];
                canvas.parentElement.style.height = '60px';

                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'New ' + name,
                            data: trends[key],
                            borderColor: line,
                            backgroundColor: fill,
                            borderWidth: 1.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 4,
                            pointHoverBackgroundColor: line
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { top: 4, bottom: 0 } },
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            x: { display: false },
                            y: { display: false, beginAtZero: true }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                displayColors: false,
                                callbacks: {
                                    label: function(ctx) {
                                        return ctx.parsed.y + ' new ' + name.toLowerCase();
                                    }
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>
@endpush
