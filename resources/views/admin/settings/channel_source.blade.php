@extends('admin.includes.layout')

@section('title', 'Channel And Sources')

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
                                    <h3 class="mb-1 fw-bold">Channels & sources </h3>
                                    <p class="text-muted mb-0">Identify where your leads come from with sources.</p>
                                </div>
                                <hr>
                            </div>

                            <!-- No channel Table Start -->
                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0 text-uppercase">No channel ({{ $no_channel_count }}) <span
                                            class="info-icon ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="Sources in this table have not yet been added to a channel. Click each source to edit."><i
                                                class="fa-regular fa-circle-info"></i></span></h6>
                                    <a href="#" class="btn-add-activity" data-bs-toggle="modal"
                                        data-bs-target="#add_source">Add source</a>
                                </div>

                                <div class="table-responsive position-relative">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Source</th>
                                                <th scope="col">Last used</th>
                                                <th scope="col">Created time</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($no_channels as $no_channel)
                                                <tr>
                                                    <td>{{ $no_channel->name ?? 'N/A' }}</td>
                                                    <td class="last-activity">
                                                        N/A
                                                    </td>
                                                    <td class="last-activity">
                                                        {{ \Carbon\Carbon::parse($no_channel->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="position-relative">
                                                        <a class="text-dark" href="javascript:void(0)"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    onclick="viewReport('Cloned Lead')">
                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                    View report
                                                                </button>
                                                            </li>

                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button"
                                                                    onclick="deleteItem('Cloned Lead')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Organic search Table Start -->
                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-uppercase">Organic search ({{ $organic_search_count }})
                                            <span class="info-icon ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Leads in the organic search channel are tracked automatically with Nutshell Analytics."><i
                                                    class="fa-regular fa-circle-info"></i></span>
                                        </h6>
                                        <p>Searched Google or other search engine</p>
                                    </div>
                                    <div>
                                        {{-- <a href="#" class="btn-add-activity">Add Organic search source</a> --}}
                                        <a href="#" class="btn-add-activity" data-bs-toggle="modal"
                                            data-bs-target="#add_source" data-channel-id="1">Add Organic search
                                            source</a>
                                    </div>
                                </div>

                                <div class="table-responsive position-relative">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Source</th>
                                                <th scope="col">Last used</th>
                                                <th scope="col">Created time</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($organic_searches as $organic_search)
                                                <tr>
                                                    <td>{{ $organic_search->name ?? 'N/A' }}</td>
                                                    <td class="last-activity">N/A</td>
                                                    <td class="last-activity">
                                                        {{ \Carbon\Carbon::parse($organic_search->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="position-relative">
                                                        <a class="text-dark" href="javascript:void(0)"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    onclick="viewReport('Cloned Lead')">
                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                    View report
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button"
                                                                    onclick="deleteItem('Cloned Lead')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Paid search Table Start -->
                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-uppercase">Paid search ({{ $paid_search_count }}) <span
                                                class="info-icon ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Leads in the paid search channel are tracked automatically with Nutshell Analytics."><i
                                                    class="fa-regular fa-circle-info"></i></span></h6>
                                        <p>Clicked your ad on Google or other search engines</p>
                                    </div>
                                    <div>
                                        {{-- <a href="#" class="btn-add-activity">Add Paid search source</a> --}}
                                        <a href="#" class="btn-add-activity" data-bs-toggle="modal"
                                            data-bs-target="#add_source" data-channel-id="2">Add Paid search source</a>
                                    </div>
                                </div>

                                <div class="table-responsive position-relative">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Source</th>
                                                <th scope="col">Last used</th>
                                                <th scope="col">Created time</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($paid_searches as $paid_search)
                                                <tr>
                                                    <td>{{ $paid_search->name ?? 'N/A' }}</td>
                                                    <td class="last-activity">N/A</td>
                                                    <td class="last-activity">
                                                        {{ \Carbon\Carbon::parse($paid_search->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="position-relative">
                                                        <a class="text-dark" href="javascript:void(0)"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    onclick="viewReport('Cloned Lead')">
                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                    View report
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button"
                                                                    onclick="deleteItem('Cloned Lead')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Organic social Table Start -->
                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-uppercase">Organic social
                                            ({{ $organic_social_count }}) <span class="info-icon ms-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Leads in the organic social channel are tracked automatically with Nutshell Analytics."><i
                                                    class="fa-regular fa-circle-info"></i></span></h6>
                                        <p>Visited your site from Twitter, Facebook, etc.</p>
                                    </div>
                                    <div>
                                        {{-- <a href="#" class="btn-add-activity">Add Organic social source</a> --}}
                                        <a href="#" class="btn-add-activity" data-bs-toggle="modal"
                                            data-bs-target="#add_source" data-channel-id="3">Add Organic social source</a>
                                    </div>
                                </div>

                                <div class="table-responsive position-relative">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Source</th>
                                                <th scope="col">Last used</th>
                                                <th scope="col">Created time</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($organic_socials as $organic_social)
                                                <tr>
                                                    <td>{{ $organic_social->name ?? 'N/A' }}</td>
                                                    <td class="last-activity">N/A</td>
                                                    <td class="last-activity">
                                                        {{ \Carbon\Carbon::parse($organic_social->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="position-relative">
                                                        <a class="text-dark" href="javascript:void(0)"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    onclick="viewReport('Cloned Lead')">
                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                    View report
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button"
                                                                    onclick="deleteItem('Cloned Lead')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Paid social Table Start -->
                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-uppercase">Paid social ({{ $paid_social_count }})
                                            <span class="info-icon ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Leads in the paid social channel are tracked automatically with Nutshell Analytics."><i
                                                    class="fa-regular fa-circle-info"></i></span>
                                        </h6>
                                        <p>Clicked your ad on Twitter, Facebook, etc.</p>
                                    </div>
                                    <div>
                                        {{-- <a href="#" class="btn-add-activity">Add Paid social source</a> --}}
                                        <a href="#" class="btn-add-activity" data-bs-toggle="modal"
                                            data-bs-target="#add_source" data-channel-id="4">Add Paid social source</a>
                                    </div>
                                </div>

                                <div class="table-responsive position-relative">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Source</th>
                                                <th scope="col">Last used</th>
                                                <th scope="col">Created time</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($paid_socials as $paid_social)
                                                <tr>
                                                    <td>{{ $paid_social->name ?? 'N/A' }}</td>
                                                    <td class="last-activity">N/A</td>
                                                    <td class="last-activity">
                                                        {{ \Carbon\Carbon::parse($paid_social->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="position-relative">
                                                        <a class="text-dark" href="javascript:void(0)"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    onclick="viewReport('Cloned Lead')">
                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                    View report
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button"
                                                                    onclick="deleteItem('Cloned Lead')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Email Table Start -->
                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-uppercase">Email social ({{ $email_count }})
                                            <span class="info-icon ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Leads in the email channel are tracked automatically with Nutshell Analytics."><i
                                                    class="fa-regular fa-circle-info"></i></span>
                                        </h6>
                                        <p>Clicked a link in your email campaign</p>
                                    </div>
                                    <div>
                                        {{-- <a href="#" class="btn-add-activity">Add email source</a> --}}
                                        <a href="#" class="btn-add-activity" data-bs-toggle="modal"
                                            data-bs-target="#add_source" data-channel-id="5">Add Email source</a>
                                    </div>
                                </div>

                                <div class="table-responsive position-relative">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Source</th>
                                                <th scope="col">Last used</th>
                                                <th scope="col">Created time</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($emails as $email)
                                                <tr>
                                                    <td>{{ $email->name ?? 'N/A' }}</td>
                                                    <td class="last-activity">N/A</td>
                                                    <td class="last-activity">
                                                        {{ \Carbon\Carbon::parse($email->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="position-relative">
                                                        <a class="text-dark" href="javascript:void(0)"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    onclick="viewReport('Cloned Lead')">
                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                    View report
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button"
                                                                    onclick="deleteItem('Cloned Lead')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Direct traffic Table Start -->
                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-uppercase">Direct traffic
                                            ({{ $direct_traffic_count }}) <span class="info-icon ms-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Leads in the direct traffic channel are tracked automatically with Nutshell Analytics."><i
                                                    class="fa-regular fa-circle-info"></i></span></h6>
                                        <p>Navigated directly to your website</p>
                                    </div>
                                    <div>
                                        {{-- <a href="#" class="btn-add-activity">Add Direct traffic source</a> --}}
                                        <a href="#" class="btn-add-activity" data-bs-toggle="modal"
                                            data-bs-target="#add_source" data-channel-id="6">Add Direct traffic source</a>
                                    </div>
                                </div>

                                <div class="table-responsive position-relative">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Source</th>
                                                <th scope="col">Last used</th>
                                                <th scope="col">Created time</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($direct_traffics as $direct_traffic)
                                                <tr>
                                                    <td>{{ $direct_traffic->name ?? 'N/A' }}</td>
                                                    <td class="last-activity">N/A</td>
                                                    <td class="last-activity">
                                                        {{ \Carbon\Carbon::parse($direct_traffic->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="position-relative">
                                                        <a class="text-dark" href="javascript:void(0)"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    onclick="viewReport('Cloned Lead')">
                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                    View report
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button"
                                                                    onclick="deleteItem('Cloned Lead')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Referral traffic Table Start -->
                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-uppercase">Referral traffic
                                            ({{ $referral_traffic_count }})<span class="info-icon ms-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Leads in the referral traffic channel are tracked automatically with manually added sources."><i
                                                    class="fa-regular fa-circle-info"></i></span></h6>
                                        <p>Arrived from a third-party website</p>
                                    </div>
                                    <div>
                                        {{-- <a href="#" class="btn-add-activity">Add Referral traffic source</a> --}}
                                        <a href="#" class="btn-add-activity" data-bs-toggle="modal"
                                            data-bs-target="#add_source" data-channel-id="7">Add Referral traffic
                                            source</a>
                                    </div>
                                </div>

                                <div class="table-responsive position-relative">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Source</th>
                                                <th scope="col">Last used</th>
                                                <th scope="col">Created time</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($referral_traffics as $referral_traffic)
                                                <tr>
                                                    <td>{{ $referral_traffic->name ?? 'N/A' }}</td>
                                                    <td class="last-activity">N/A</td>
                                                    <td class="last-activity">
                                                        {{ \Carbon\Carbon::parse($referral_traffic->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="position-relative">
                                                        <a class="text-dark" href="javascript:void(0)"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    onclick="viewReport('Cloned Lead')">
                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                    View report
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button"
                                                                    onclick="deleteItem('Cloned Lead')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Traditional Table Start -->
                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-uppercase">Traditional
                                            ({{ $traditional_count }})<span class="info-icon ms-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Leads in the traditional channel are tracked automatically with manually added sources."><i
                                                    class="fa-regular fa-circle-info"></i></span></h6>
                                        <p>Saw a billboard, connected at a tradeshow, etc.</p>
                                    </div>
                                    <div>
                                        {{-- <a href="#" class="btn-add-activity">Add Traditional source</a> --}}
                                        <a href="#" class="btn-add-activity" data-bs-toggle="modal"
                                            data-bs-target="#add_source" data-channel-id="8">Add Traditional source</a>
                                    </div>
                                </div>

                                <div class="table-responsive position-relative">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Source</th>
                                                <th scope="col">Last used</th>
                                                <th scope="col">Created time</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($traditionals as $traditional)
                                                <tr>
                                                    <td>{{ $traditional->name ?? 'N/A' }}</td>
                                                    <td class="last-activity">N/A</td>
                                                    <td class="last-activity">
                                                        {{ \Carbon\Carbon::parse($traditional->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="position-relative">
                                                        <a class="text-dark" href="javascript:void(0)"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <button class="dropdown-item" type="button"
                                                                    onclick="viewReport('Cloned Lead')">
                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                    View report
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-danger" type="button"
                                                                    onclick="deleteItem('Cloned Lead')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="info-section">
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Getting started with channels and sources</h6>
                                    </div>
                                    <p>Existing sources can now be grouped into channels. These broad, predetermined
                                        categories describe where a lead comes from.</p>
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 13 13" width="13" height="13">
                                            <path fill="currentColor"
                                                d="M0 2.438C0 1.54.729.812 1.625.812h9.75c.896 0 1.625.73 1.625 1.625v8.126c0 .896-.729 1.624-1.625 1.624h-9.75A1.626 1.626 0 0 1 0 10.563V2.437Zm6.5 0v8.124h4.875V2.438H6.5Z">
                                            </path>
                                        </svg> Learn more</a>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>What is a source?</h6>
                                    </div>
                                    <p>Sources track how leads arrive at your website and learn about your business. Leads
                                        can be associated with one or more sources (e.g., ‘direct,’ ‘google,’ ‘web beta
                                        signup,’ etc.).</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>What is a channel?</h6>
                                    </div>
                                    <p>Channels group your sources into broader categories. Report on these channels to
                                        understand where your traffic comes from and identify opportunities for growth.</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>Where do sources come from?</h6>
                                    </div>
                                    <p>Sources can be added manually to ‘Traditional’ or ‘Referral traffic’ while sources in
                                        all other channels are tracked automatically with Nutshell Analytics.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->

    </main>

    <!-- Add a new source Modal Start -->
    {{-- <div class="modal fade" id="AddsourceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialo">
            <div class="modal-content">
                <div class="modal-body">
                    <h1 class="modal-title fs-5 mb-2" id="exampleModalLabel">Add a new source</h1>
                    <form class="">
                        <div class="form-group mb-3">
                            <label for="sourceName" class="form-label">Source name</label>
                            <input type="text" class="form-control" id="sourceName" placeholder="Enter source name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="sourceType" class="form-label">Source type</label>
                            <select class="form-select" id="sourceType">
                                <option selected>Select source type</option>
                                <option value="1">Paid search</option>
                                <option value="2">Organic search</option>
                                <option value="3">Paid social </option>
                                <option value="4">Email </option>
                                <option value="5">Direct Traffic</option>
                                <option value="5">Traditional</option>
                                <option value="5">No channel</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Create source</button>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="modal fade" id="add_source" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Just remove modal-fullscreen from below class , to get a popup instead of full modal --}}
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add a new source</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">

                    <form class="company-form" action="{{ route('admin.settings.source.store') }}" method="post"
                        id="store_source">
                        @csrf


                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" placeholder="" name="name" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Channel</label>
                                    <select name="channel_id" id="channel_id" class="form-select">
                                        <option value="">-- Select Channel --</option>
                                        @foreach ($all_channels as $all_channel)
                                            <option value="{{ $all_channel->id }}">{{ $all_channel->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="AddSource">New Source</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add a new source Modal End -->
@endsection


@push('scripts')
    <script>
        // JavaScript to set selected channel dynamically
        document.addEventListener('DOMContentLoaded', function() {
            const addButtons = document.querySelectorAll('.btn-add-activity');
            const channelSelect = document.getElementById('channel_id');

            addButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const channelId = this.getAttribute('data-channel-id');
                    if (channelSelect) {
                        // channelSelect.value = channelId;
                        if (channelId) {
                            channelSelect.value = channelId;
                        } else {
                            // Otherwise, reset to default (empty)
                            channelSelect.value = '';
                        }
                    }
                });
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

         $("#store_source").validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please enter the source name."
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


        $('#store_source').submit(function(e) {
            e.preventDefault();

            if (!$('#store_source').valid()) {
                return; // Stop if validation fails
            }

            $.ajax({
                url: "{{ route('admin.settings.source.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert('Source added successfully!');
                    $('#add_source').modal('hide');
                    console.log(response);
                    location.reload();

                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                    toastr.error('Something went wrong while adding new source.');
                }
            });
        });



    </script>
@endpush
