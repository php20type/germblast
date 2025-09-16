@extends('admin.includes.layout')

@section('title', 'Peoples')

@section('content')


    <main class="app-wrapper">


        <!-- All Companies Section start  -->
        <div class="companies-section my-4">
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    @include('admin.peoples.sidebar')

                    <!-- Main Content -->
                    <div class="col-md-10 p-0">
                        <div class="main-content">
                            <!-- Header -->
                            <div class="heading-area-sec">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">1st Drip Sequence Healthcare Texas <i
                                            class="fas fa-thumbtack pinned-icon"></i></h3>
                                    <p class="text-muted mb-0">Created by Brennan Baxter on November 3rd, 2023</p>
                                </div>
                                <button class="btn btn-export">EXPORT</button>
                            </div>

                            <!-- Filter Section -->
                            <div class="filter-section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center position-relative">
                                            <div class="search-form">
                                                <input type="search" class="form-control" placeholder=""
                                                    aria-label="Search">
                                            </div>
                                            <span class="company-count">8 people found</span>

                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="d-flex align-items-center justify-content-end dropdown">
                                            <div class="me-2">
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>All Menbers</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary me-2"><img src="img/icons/filter.svg"
                                                    alt="" /></button>
                                            <button class="btn btn-primary"><img src="img/icons/bar.svg"
                                                    alt="" /></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <div class="table-container mt-3">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="checkbox-cell">
                                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                                </th>
                                                <th>
                                                    <img src="img/icons/down-vector.svg" alt="" /> Person name </i>
                                                </th>
                                                <th>
                                                    <img src="img/icons/down-vector.svg" alt="" /> Last contact </i>
                                                </th>
                                                <th>
                                                    <img src="img/icons/down-vector.svg" alt="" /> Email </i>
                                                </th>
                                                <th>
                                                    <img src="img/icons/down-vector.svg" alt="" /> Phone </i>
                                                </th>
                                                <th>
                                                    <img src="img/icons/down-vector.svg" alt="" /> Address </i>
                                                </th>
                                                <th>
                                                    <img src="img/icons/down-vector.svg" alt="" /> Tags </i>
                                                </th>
                                                <th>
                                                    <img src="img/icons/down-vector.svg" alt="" /> Marketing status
                                                    </i>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="form-check-input row-checkbox">
                                                </td>
                                                <td>
                                                    <div class="company-details">Unnamed perЗАНТ</div>
                                                    <div class="company-name">East Central 150...</div>
                                                </td>
                                                <td>30 November 2017 </td>
                                                <td>apedrosa@chcitache.org </td>
                                                <td>4405656565</td>
                                                <td>California Us</td>
                                                <td></td>
                                                <td>
                                                    <div class="email-status">No email address</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="form-check-input row-checkbox">
                                                </td>
                                                <td>
                                                    <div class="company-details">Unnamed person</div>
                                                    <div class="company-name">East Central ISD...</div>
                                                </td>
                                                <td>29 October 2019 </td>
                                                <td>apedrosa@chcitache.org </td>
                                                <td>7405656565</td>
                                                <td>Texas, US </td>
                                                <td></td>
                                                <td>
                                                    <div class="email-status">No email address</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="form-check-input row-checkbox">
                                                </td>
                                                <td>
                                                    <div class="company-details">Unnamed perso00</div>
                                                    <div class="company-name">Community Health...</div>
                                                </td>
                                                <td>14 November 2024 </td>
                                                <td>apedrosa@chcitache.org </td>
                                                <td>4405656565</td>
                                                <td>California Us</td>
                                                <td></td>
                                                <td>
                                                    <div class="email-status">No email address</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="form-check-input row-checkbox">
                                                </td>
                                                <td>
                                                    <div class="company-details">Unnamed perЗАНТ</div>
                                                    <div class="company-name">East Central 150...</div>
                                                </td>
                                                <td>30 November 2017 </td>
                                                <td>apedrosa@chcitache.org </td>
                                                <td>4405656565</td>
                                                <td>California Us</td>
                                                <td></td>
                                                <td>
                                                    <div class="email-status">No email address</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="form-check-input row-checkbox">
                                                </td>
                                                <td>
                                                    <div class="company-details">Unnamed person</div>
                                                    <div class="company-name">East Central ISD...</div>
                                                </td>
                                                <td>29 October 2019 </td>
                                                <td>apedrosa@chcitache.org </td>
                                                <td>7405656565</td>
                                                <td>Texas, US </td>
                                                <td></td>
                                                <td>
                                                    <div class="email-status">No email address</div>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" class="form-check-input row-checkbox">
                                                </td>
                                                <td>
                                                    <div class="company-details">Unnamed perso00</div>
                                                    <div class="company-name">Community Health...</div>
                                                </td>
                                                <td>14 November 2024 </td>
                                                <td>apedrosa@chcitache.org </td>
                                                <td>4405656565</td>
                                                <td>California Us</td>
                                                <td></td>
                                                <td>
                                                    <div class="email-status">No email address</div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <div class="pagination-container">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination pagination-custom justify-content-center">
                                                <li class="page-item">
                                                    <a class="page-link" href="#" aria-label="Previous">
                                                        <span aria-hidden="true">← Previous</span>
                                                    </a>
                                                </li>
                                                <li class="page-item active"><a class="page-link" href="#">1</a>
                                                </li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">...</a></li>
                                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#" aria-label="Next">
                                                        <span aria-hidden="true">Next →</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Bar -->
                            <div class="action-bar" id="actionBar">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="me-3"><strong id="selectedCount">1</strong> Selected</span>
                                    <button class="btn btn-edit btn-action">EDIT</button>
                                    <button class="btn btn-merge btn-action">MERGE</button>
                                    <button class="btn btn-add-audience btn-action">ADD TO AUDIENCE</button>
                                    <button class="btn btn-delete btn-action">DELETE</button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- All Companies Section End  -->


    </main>

@endsection
