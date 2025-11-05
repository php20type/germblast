@extends('admin.includes.layout')

@section('title', 'Sales')

@section('content')


    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-2">
                    <div class="sidebar">
                        <ul class="list-inline">
                            <li>
                                <a class="nav-link d-inline-block w-100 {{ request()->routeIs('admin.sales.index') ? 'active' : '' }}"
                                    href="{{ route('admin.sales.index') }}">

                                    <svg width="18" height="17" viewBox="0 0 18 17" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3.34311 15.6821C2.2243 14.5352 1.46239 13.0739 1.15371 11.4831C0.84504 9.89222 1.00347 8.24327 1.60898 6.74474C2.21448 5.2462 3.23986 3.96538 4.55545 3.06425C5.87104 2.16311 7.41775 1.68213 9 1.68213C10.5822 1.68213 12.129 2.16311 13.4445 3.06425C14.7601 3.96538 15.7855 5.2462 16.391 6.74474C16.9965 8.24327 17.155 9.89222 16.8463 11.4831C16.5376 13.0739 15.7757 14.5352 14.6569 15.6821"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M12 7L9 10" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    Dashboard

                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">

                                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1 4.75C1 4.28587 1.18437 3.84075 1.51256 3.51256C1.84075 3.18437 2.28587 3 2.75 3H13.25C13.7141 3 14.1592 3.18437 14.4874 3.51256C14.8156 3.84075 15 4.28587 15 4.75V15.25C15 15.7141 14.8156 16.1592 14.4874 16.4874C14.1592 16.8156 13.7141 17 13.25 17H2.75C2.28587 17 1.84075 16.8156 1.51256 16.4874C1.18437 16.1592 1 15.7141 1 15.25V4.75Z"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M11 1V5" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M4 1V5" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M1 8H15" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M7 12H8" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M8 12V14" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    Scheduler
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M17 9C17 7.41775 16.5308 5.87103 15.6518 4.55544C14.7727 3.23985 13.5233 2.21447 12.0615 1.60897C10.5997 1.00347 8.99113 0.84504 7.43928 1.15372C5.88743 1.4624 4.46197 2.22433 3.34315 3.34315C2.22433 4.46197 1.4624 5.88743 1.15372 7.43928C0.84504 8.99113 1.00347 10.5997 1.60897 12.0615C2.21447 13.5233 3.23985 14.7727 4.55544 15.6518C5.87103 16.5308 7.41775 17 9 17"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M2 6H16" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M2 12H9" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M9 1C7.03942 3.39966 6 6.17144 6 9C6 11.8286 7.03942 14.6003 9 17"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M9 1C10.8849 3.40347 11.9212 6.16709 12 9" stroke="white" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M12 14.5C12 15.163 12.2634 15.7989 12.7322 16.2678C13.2011 16.7366 13.837 17 14.5 17C15.163 17 15.7989 16.7366 16.2678 16.2678C16.7366 15.7989 17 15.163 17 14.5C17 13.837 16.7366 13.2011 16.2678 12.7322C15.7989 12.2634 15.163 12 14.5 12C13.837 12 13.2011 12.2634 12.7322 12.7322C12.2634 13.2011 12 13.837 12 14.5Z"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M17 17L18 18" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>

                                    ProspectorIQ
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.2642 2.00603C16.1027 1.9856 15.9394 2.01734 15.7942 2.09733L12 4.17447V7.82657L15.7942 9.90371C15.9211 9.97318 16.062 10.006 16.2037 9.9991C16.3455 9.99218 16.4832 9.94575 16.604 9.86419C16.7247 9.78264 16.8245 9.66866 16.8938 9.53305C16.9631 9.39745 16.9996 9.2447 17 9.08929V2.91175C16.9998 2.68828 16.9247 2.47266 16.7891 2.30573C16.6535 2.13881 16.4667 2.03218 16.2642 2.00603Z"
                                            fill="white" />
                                        <path
                                            d="M2.78571 0C1.25821 0 0 1.16143 0 2.57143V9.42857C0 10.8386 1.25821 12 2.78571 12H10.2143C11.7418 12 13 10.8386 13 9.42857V2.57143C13 1.16143 11.7418 0 10.2143 0H2.78571Z"
                                            fill="white" />
                                    </svg>

                                    Meetings
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="14" height="18" viewBox="0 0 14 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7 0L7.10237 0.00629997C7.29769 0.0299915 7.47955 0.120671 7.61861 0.26371C7.75768 0.406749 7.84584 0.593805 7.86888 0.7947L7.875 0.9V4.5L7.87937 4.635C7.91069 5.06355 8.09004 5.46644 8.385 5.77083C8.67997 6.07521 9.07108 6.261 9.48763 6.2946L9.625 6.3H13.125L13.2274 6.3063C13.4227 6.32999 13.6046 6.42067 13.7436 6.56371C13.8827 6.70675 13.9708 6.89381 13.9939 7.0947L14 7.2V15.3C14 15.9887 13.7442 16.6514 13.2849 17.1524C12.8255 17.6535 12.1974 17.9551 11.529 17.9955L11.375 18H2.625C1.95544 18 1.31117 17.7369 0.824022 17.2644C0.336869 16.792 0.0436559 16.1459 0.0043751 15.4584L4.07789e-09 15.3V2.7C-3.7294e-05 2.01131 0.255785 1.34864 0.715123 0.847565C1.17446 0.346494 1.80259 0.0449032 2.471 0.0045001L2.625 0H7Z"
                                            fill="white" />
                                        <path d="M13 5H10.0008L10 1L13 5Z" fill="white" />
                                    </svg>

                                    Quotes
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="17" height="15" viewBox="0 0 17 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.45549 0.184573C8.18078 0.325129 7.95021 0.538788 7.78917 0.802008C7.62813 1.06523 7.54288 1.36779 7.54281 1.67637L7.54197 3.84366H3.35237C3.1301 3.84366 2.91692 3.93196 2.75975 4.08913C2.60258 4.24631 2.51428 4.45948 2.51428 4.68175V9.71028L2.52015 9.80833C2.54417 10.0122 2.64217 10.2002 2.79557 10.3366C2.94897 10.473 3.14709 10.5483 3.35237 10.5484L7.54197 10.5475L7.54281 12.7157C7.54288 13.0471 7.64122 13.3711 7.82541 13.6467C8.00959 13.9223 8.27135 14.1371 8.57759 14.2639C8.88382 14.3907 9.22079 14.4239 9.54589 14.3593C9.87099 14.2946 10.1696 14.1351 10.404 13.9007L15.9237 8.38107C16.2379 8.06674 16.4144 7.64048 16.4144 7.19601C16.4144 6.75155 16.2379 6.32529 15.9237 6.01096L10.404 0.491313C10.1696 0.256762 9.87093 0.0970072 9.54571 0.0322616C9.22049 -0.032484 8.88337 0.000688902 8.57701 0.127583L8.45549 0.184573Z"
                                            fill="white" />
                                        <path
                                            d="M0.838088 3.84375C1.04336 3.84378 1.24149 3.91914 1.39489 4.05555C1.54829 4.19195 1.64629 4.37992 1.67031 4.58378L1.67618 4.68184V9.71036C1.67594 9.92397 1.59414 10.1294 1.4475 10.2848C1.30086 10.4401 1.10045 10.5336 0.887204 10.5461C0.673959 10.5586 0.463982 10.4892 0.300176 10.3521C0.136369 10.215 0.0310961 10.0205 0.00586659 9.80842L0 9.71036V4.68184C0 4.45956 0.0882982 4.24639 0.24547 4.08922C0.402642 3.93205 0.615813 3.84375 0.838088 3.84375Z"
                                            fill="white" />
                                    </svg>

                                    Automation
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1 8C1 8.91925 1.18106 9.82951 1.53284 10.6788C1.88463 11.5281 2.40024 12.2997 3.05025 12.9497C3.70026 13.5998 4.47194 14.1154 5.32122 14.4672C6.1705 14.8189 7.08075 15 8 15C8.91925 15 9.82951 14.8189 10.6788 14.4672C11.5281 14.1154 12.2997 13.5998 12.9497 12.9497C13.5998 12.2997 14.1154 11.5281 14.4672 10.6788C14.8189 9.82951 15 8.91925 15 8C15 6.14348 14.2625 4.36301 12.9497 3.05025C11.637 1.7375 9.85652 1 8 1C6.14348 1 4.36301 1.7375 3.05025 3.05025C1.7375 4.36301 1 6.14348 1 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M4 8C4 8.52529 4.10346 9.04543 4.30448 9.53073C4.5055 10.016 4.80014 10.457 5.17157 10.8284C5.54301 11.1999 5.98396 11.4945 6.46927 11.6955C6.95457 11.8965 7.47471 12 8 12C8.52529 12 9.04543 11.8965 9.53073 11.6955C10.016 11.4945 10.457 11.1999 10.8284 10.8284C11.1999 10.457 11.4945 10.016 11.6955 9.53073C11.8965 9.04543 12 8.52529 12 8C12 6.93913 11.5786 5.92172 10.8284 5.17157C10.0783 4.42143 9.06087 4 8 4C6.93913 4 5.92172 4.42143 5.17157 5.17157C4.42143 5.92172 4 6.93913 4 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    Quotas
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1 8C1 8.91925 1.18106 9.82951 1.53284 10.6788C1.88463 11.5281 2.40024 12.2997 3.05025 12.9497C3.70026 13.5998 4.47194 14.1154 5.32122 14.4672C6.1705 14.8189 7.08075 15 8 15C8.91925 15 9.82951 14.8189 10.6788 14.4672C11.5281 14.1154 12.2997 13.5998 12.9497 12.9497C13.5998 12.2997 14.1154 11.5281 14.4672 10.6788C14.8189 9.82951 15 8.91925 15 8C15 6.14348 14.2625 4.36301 12.9497 3.05025C11.637 1.7375 9.85652 1 8 1C6.14348 1 4.36301 1.7375 3.05025 3.05025C1.7375 4.36301 1 6.14348 1 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M4 8C4 8.52529 4.10346 9.04543 4.30448 9.53073C4.5055 10.016 4.80014 10.457 5.17157 10.8284C5.54301 11.1999 5.98396 11.4945 6.46927 11.6955C6.95457 11.8965 7.47471 12 8 12C8.52529 12 9.04543 11.8965 9.53073 11.6955C10.016 11.4945 10.457 11.1999 10.8284 10.8284C11.1999 10.457 11.4945 10.016 11.6955 9.53073C11.8965 9.04543 12 8.52529 12 8C12 6.93913 11.5786 5.92172 10.8284 5.17157C10.0783 4.42143 9.06087 4 8 4C6.93913 4 5.92172 4.42143 5.17157 5.17157C4.42143 5.92172 4 6.93913 4 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    Contract Exception Report
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1 8C1 8.91925 1.18106 9.82951 1.53284 10.6788C1.88463 11.5281 2.40024 12.2997 3.05025 12.9497C3.70026 13.5998 4.47194 14.1154 5.32122 14.4672C6.1705 14.8189 7.08075 15 8 15C8.91925 15 9.82951 14.8189 10.6788 14.4672C11.5281 14.1154 12.2997 13.5998 12.9497 12.9497C13.5998 12.2997 14.1154 11.5281 14.4672 10.6788C14.8189 9.82951 15 8.91925 15 8C15 6.14348 14.2625 4.36301 12.9497 3.05025C11.637 1.7375 9.85652 1 8 1C6.14348 1 4.36301 1.7375 3.05025 3.05025C1.7375 4.36301 1 6.14348 1 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M4 8C4 8.52529 4.10346 9.04543 4.30448 9.53073C4.5055 10.016 4.80014 10.457 5.17157 10.8284C5.54301 11.1999 5.98396 11.4945 6.46927 11.6955C6.95457 11.8965 7.47471 12 8 12C8.52529 12 9.04543 11.8965 9.53073 11.6955C10.016 11.4945 10.457 11.1999 10.8284 10.8284C11.1999 10.457 11.4945 10.016 11.6955 9.53073C11.8965 9.04543 12 8.52529 12 8C12 6.93913 11.5786 5.92172 10.8284 5.17157C10.0783 4.42143 9.06087 4 8 4C6.93913 4 5.92172 4.42143 5.17157 5.17157C4.42143 5.92172 4 6.93913 4 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    Equipement Loan
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1 8C1 8.91925 1.18106 9.82951 1.53284 10.6788C1.88463 11.5281 2.40024 12.2997 3.05025 12.9497C3.70026 13.5998 4.47194 14.1154 5.32122 14.4672C6.1705 14.8189 7.08075 15 8 15C8.91925 15 9.82951 14.8189 10.6788 14.4672C11.5281 14.1154 12.2997 13.5998 12.9497 12.9497C13.5998 12.2997 14.1154 11.5281 14.4672 10.6788C14.8189 9.82951 15 8.91925 15 8C15 6.14348 14.2625 4.36301 12.9497 3.05025C11.637 1.7375 9.85652 1 8 1C6.14348 1 4.36301 1.7375 3.05025 3.05025C1.7375 4.36301 1 6.14348 1 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M4 8C4 8.52529 4.10346 9.04543 4.30448 9.53073C4.5055 10.016 4.80014 10.457 5.17157 10.8284C5.54301 11.1999 5.98396 11.4945 6.46927 11.6955C6.95457 11.8965 7.47471 12 8 12C8.52529 12 9.04543 11.8965 9.53073 11.6955C10.016 11.4945 10.457 11.1999 10.8284 10.8284C11.1999 10.457 11.4945 10.016 11.6955 9.53073C11.8965 9.04543 12 8.52529 12 8C12 6.93913 11.5786 5.92172 10.8284 5.17157C10.0783 4.42143 9.06087 4 8 4C6.93913 4 5.92172 4.42143 5.17157 5.17157C4.42143 5.92172 4 6.93913 4 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    Product List
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1 8C1 8.91925 1.18106 9.82951 1.53284 10.6788C1.88463 11.5281 2.40024 12.2997 3.05025 12.9497C3.70026 13.5998 4.47194 14.1154 5.32122 14.4672C6.1705 14.8189 7.08075 15 8 15C8.91925 15 9.82951 14.8189 10.6788 14.4672C11.5281 14.1154 12.2997 13.5998 12.9497 12.9497C13.5998 12.2997 14.1154 11.5281 14.4672 10.6788C14.8189 9.82951 15 8.91925 15 8C15 6.14348 14.2625 4.36301 12.9497 3.05025C11.637 1.7375 9.85652 1 8 1C6.14348 1 4.36301 1.7375 3.05025 3.05025C1.7375 4.36301 1 6.14348 1 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M4 8C4 8.52529 4.10346 9.04543 4.30448 9.53073C4.5055 10.016 4.80014 10.457 5.17157 10.8284C5.54301 11.1999 5.98396 11.4945 6.46927 11.6955C6.95457 11.8965 7.47471 12 8 12C8.52529 12 9.04543 11.8965 9.53073 11.6955C10.016 11.4945 10.457 11.1999 10.8284 10.8284C11.1999 10.457 11.4945 10.016 11.6955 9.53073C11.8965 9.04543 12 8.52529 12 8C12 6.93913 11.5786 5.92172 10.8284 5.17157C10.0783 4.42143 9.06087 4 8 4C6.93913 4 5.92172 4.42143 5.17157 5.17157C4.42143 5.92172 4 6.93913 4 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    Purchasing Coop
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1 8C1 8.91925 1.18106 9.82951 1.53284 10.6788C1.88463 11.5281 2.40024 12.2997 3.05025 12.9497C3.70026 13.5998 4.47194 14.1154 5.32122 14.4672C6.1705 14.8189 7.08075 15 8 15C8.91925 15 9.82951 14.8189 10.6788 14.4672C11.5281 14.1154 12.2997 13.5998 12.9497 12.9497C13.5998 12.2997 14.1154 11.5281 14.4672 10.6788C14.8189 9.82951 15 8.91925 15 8C15 6.14348 14.2625 4.36301 12.9497 3.05025C11.637 1.7375 9.85652 1 8 1C6.14348 1 4.36301 1.7375 3.05025 3.05025C1.7375 4.36301 1 6.14348 1 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M4 8C4 8.52529 4.10346 9.04543 4.30448 9.53073C4.5055 10.016 4.80014 10.457 5.17157 10.8284C5.54301 11.1999 5.98396 11.4945 6.46927 11.6955C6.95457 11.8965 7.47471 12 8 12C8.52529 12 9.04543 11.8965 9.53073 11.6955C10.016 11.4945 10.457 11.1999 10.8284 10.8284C11.1999 10.457 11.4945 10.016 11.6955 9.53073C11.8965 9.04543 12 8.52529 12 8C12 6.93913 11.5786 5.92172 10.8284 5.17157C10.0783 4.42143 9.06087 4 8 4C6.93913 4 5.92172 4.42143 5.17157 5.17157C4.42143 5.92172 4 6.93913 4 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    Reference Lists
                                </a>
                            </li>
                            <li>
                                <a class="nav-link d-inline-block w-100" href="#">


                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1 8C1 8.91925 1.18106 9.82951 1.53284 10.6788C1.88463 11.5281 2.40024 12.2997 3.05025 12.9497C3.70026 13.5998 4.47194 14.1154 5.32122 14.4672C6.1705 14.8189 7.08075 15 8 15C8.91925 15 9.82951 14.8189 10.6788 14.4672C11.5281 14.1154 12.2997 13.5998 12.9497 12.9497C13.5998 12.2997 14.1154 11.5281 14.4672 10.6788C14.8189 9.82951 15 8.91925 15 8C15 6.14348 14.2625 4.36301 12.9497 3.05025C11.637 1.7375 9.85652 1 8 1C6.14348 1 4.36301 1.7375 3.05025 3.05025C1.7375 4.36301 1 6.14348 1 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M4 8C4 8.52529 4.10346 9.04543 4.30448 9.53073C4.5055 10.016 4.80014 10.457 5.17157 10.8284C5.54301 11.1999 5.98396 11.4945 6.46927 11.6955C6.95457 11.8965 7.47471 12 8 12C8.52529 12 9.04543 11.8965 9.53073 11.6955C10.016 11.4945 10.457 11.1999 10.8284 10.8284C11.1999 10.457 11.4945 10.016 11.6955 9.53073C11.8965 9.04543 12 8.52529 12 8C12 6.93913 11.5786 5.92172 10.8284 5.17157C10.0783 4.42143 9.06087 4 8 4C6.93913 4 5.92172 4.42143 5.17157 5.17157C4.42143 5.92172 4 6.93913 4 8Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    Video Library
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="sales-dashboard">
                        <div class="dashboard-header section-card">
                            <div class="container-fluid">
                                <h1 class="display-6 mb-2 fw-bold">DASHBOARD</h1>
                                <p class="text-muted">Add cards to track the metrics, leads and reports that
                                    matter most to you</p>
                            </div>
                        </div>

                        <!-- Sales Metrics Row -->
                        <div class="section-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="section-title">SALES METRICS</h2>
                                    <p class="section-subtitle">Metrics - Month - to - date</p>
                                </div>
                                <div class="info-icon d-none">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#SalesMetricsModal"><i
                                            class="fa-regular fa-gear"></i></a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="metric-card new-lead" id="newLeadCard">
                                        <h3>NEW LEAD</h3>
                                        <div class="metric-value green">{{ $newLeadsThisMonth }}</div>
                                        {{-- <div class="metric-change">Down 14% From 7 This Time Last Month</div> --}}
                                        <div class="metric-change">{{ $newLeadsChange }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric-card open-leads" id="openLeadCard">
                                        <h3>OPEN LEADS</h3>
                                        <div class="metric-value blue">{{ $openLeadsThisMonth }}</div>
                                        {{-- <div class="metric-change">Down 6% From $5.48m This Time Last Month</div> --}}
                                        <div class="metric-change">{{ $openLeadsChange }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric-card sales" id="saleLeadCard">
                                        <h3>SALES</h3>
                                        <div class="metric-value red">{{ $salesLeadsThisMonth }}</div>
                                        {{-- <div class="metric-change">Down 75% From $66.2k This Time Last Month</div> --}}
                                        <div class="metric-change">{{ $salesLeadsChange }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lead Summary and Pipeline Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="section-card">
                                    <div class="section-header">
                                        <div>
                                            <h3 class="section-title">LEAD SUMMARY</h3>
                                            <p class="section-subtitle">List Summary</p>
                                        </div>
                                        <div class="info-icon d-none">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#LeadSummaryModal"><i class="fa-regular fa-gear"></i></a>
                                        </div>
                                    </div>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Lead Type</th>
                                                <th>Count</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.leads.index') }}">All Leads</a>
                                                </td>
                                                <td>{{ $allLeadsCount }}</td>
                                                <td>${{ $allLeadsValueFormatted }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.leads.my_leads', auth()->id()) }}">My
                                                        Leads</a>
                                                </td>
                                                <td>{{ $myLeadsCount }}</td>
                                                <td>${{ $myLeadsValueFormatted }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.leads.added_this_week') }}">Added this
                                                        week</a>
                                                </td>
                                                <td>{{ $addedThisWeekCount }}</td>
                                                {{-- <td>$8.99k</td> --}}
                                                <td>${{ $addedThisWeekValueFormatted }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.leads.closing_this_week') }}">Closing this
                                                        week</a>
                                                </td>
                                                <td>{{ $closingThisWeekCount }}</td>
                                                <td>${{ $closingThisWeekValueFormatted }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.leads.hot_leads') }}">Hot leads</a>
                                                </td>
                                                <td>{{ $hotLeadsCount }}</td>
                                                <td>${{ $hotLeadsValueFormatted }}</td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="section-card">
                                    <div class="section-header">
                                        <div>
                                            <h3 class="section-title">PIPELINE</h3>
                                            <p class="section-subtitle">Default Pipeline by stage</p>
                                        </div>
                                        <div class="info-icon d-none">
                                            <a href="#EditPipelineModal" data-bs-toggle="modal"
                                                data-bs-target="#EditPipelineModal"><i class="fa-regular fa-gear"></i></a>
                                        </div>
                                    </div>

                                    <div class="pipeline-card">
                                        <div class="company-form">
                                            <div class="pipeline-stages">
                                                <!-- Stage 1: Int. GB Presentation -->
                                                <div class="pipeline-stage stage-1" data-lead-stage="1">
                                                    <div class="stage-info">
                                                        <div class="stage-name">Int. GB Presentation</div>
                                                        <div class="stage-metrics">
                                                            <span class="leads-count">{{ $gbPresentationCount }}
                                                                leads</span>
                                                            <span
                                                                class="revenue-amount">${{ $gbPresentationCountValueFormatted }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"></div>
                                                    </div>
                                                </div>

                                                <!-- Stage 2: Site Survey -->
                                                <div class="pipeline-stage stage-2" data-lead-stage="2">
                                                    <div class="stage-info">
                                                        <div class="stage-name">Site Survey</div>
                                                        <div class="stage-metrics">
                                                            <span class="leads-count">{{ $siteSurveyCount }} leads</span>
                                                            <span
                                                                class="revenue-amount">${{ $siteSurveyCountValueFormatted }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"></div>
                                                    </div>
                                                </div>

                                                <!-- Stage 3: Proposal Approval -->
                                                <div class="pipeline-stage stage-3" data-lead-stage="3">
                                                    <div class="stage-info">
                                                        <div class="stage-name">Proposal Approval</div>
                                                        <div class="stage-metrics">
                                                            <span class="leads-count">{{ $proposalApprovalCount }}
                                                                leads</span>
                                                            <span
                                                                class="revenue-amount">${{ $proposalApprovalCountValueFormatted }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"></div>
                                                    </div>
                                                </div>

                                                <!-- Stage 4: Proposal Pres. -->
                                                <div class="pipeline-stage stage-4" data-lead-stage="4">
                                                    <div class="stage-info">
                                                        <div class="stage-name">Proposal Pres.</div>
                                                        <div class="stage-metrics">
                                                            <span class="leads-count">{{ $proposalPresentationCount }}
                                                                leads</span>
                                                            <span
                                                                class="revenue-amount">${{ $proposalPresentationCountValueFormatted }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"></div>
                                                    </div>
                                                </div>

                                                <!-- Stage 5: Rec. Signed Proposal -->
                                                <div class="pipeline-stage stage-5" data-lead-stage="5">
                                                    <div class="stage-info">
                                                        <div class="stage-name">Rec. Signed Proposal</div>
                                                        <div class="stage-metrics">
                                                            <span class="leads-count">{{ $signedProposalCount }}
                                                                leads</span>
                                                            <span
                                                                class="revenue-amount">${{ $signedProposalCountValueFormatted }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add Card Section -->
                        <div class="section-card d-none">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="section-title">ADD A CARD</h3>
                                    <div class="add-card-area" onclick="addCard()">
                                        <i class="fas fa-plus add-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Activities Section -->
                        <div class="row">
                            <div class="col-12">
                                <div class="section-card">
                                    <!-- Bootstrap Nav Tabs -->
                                    <ul class="nav nav-tabs" id="activityTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="activities-tab" data-bs-toggle="tab"
                                                data-bs-target="#activities" type="button" role="tab"
                                                aria-controls="activities" aria-selected="true">ACTIVITIES</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="todo-tab" data-bs-toggle="tab"
                                                data-bs-target="#todo" type="button" role="tab"
                                                aria-controls="todo" aria-selected="false">TO DO</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="timeline-tab" data-bs-toggle="tab"
                                                data-bs-target="#timeline" type="button" role="tab"
                                                aria-controls="timeline" aria-selected="false">TIMELINE</button>
                                        </li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content pt-2" id="activityTabsContent">
                                        <!-- ACTIVITIES TAB -->
                                        <div class="tab-pane fade show active" id="activities" role="tabpanel"
                                            aria-labelledby="activities-tab">
                                            <div class="filter-section mb-3">
                                                <div class="row g-2 align-items-center">
                                                    <!-- Filter Range -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange" id="filter-range"
                                                            name="filter_range">
                                                            <option value="all">All Entries</option>
                                                            <option value="7">Last 7 Days</option>
                                                            <option value="30">Last 30 Days</option>
                                                            <option value="90">Last 90 Days</option>
                                                        </select>
                                                    </div>

                                                    <!-- Activity Type -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange" id="filter-activity"
                                                            name="activity_type_id">
                                                            <option value="all">All Activity Types</option>
                                                            @foreach ($activitytypes as $activitytype)
                                                                <option value="{{ $activitytype->id }}">
                                                                    {{ $activitytype->type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange" id="filter-status"
                                                            name="status">
                                                            <option value="all">All Status</option>
                                                            <option value="logged">Logged</option>
                                                            <option value="scheduled">Scheduled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="timeline-container">
                                                <div class="timeline position-relative" id="allActivitiesContainer">
                                                    @foreach ($allactivities as $item)
                                                        <div class="timeline-item">
                                                            {{-- <div class="timeline-icon">
                                                                    <i class="{{ $item->activityType->icon }}"></i>
                                                                </div> --}}
                                                            <div class="timeline-content">
                                                                <div class="timeline-header">
                                                                    <div class="timestamp">
                                                                        {{-- {{ \Carbon\Carbon::parse($item->created_at)->format('g:i A \o\n M j, Y') }} --}}
                                                                        {{ \Carbon\Carbon::parse($item->end_time)->format('g:i A') ?? 'N/A' }}
                                                                        on
                                                                        {{ \Carbon\Carbon::parse($item->date)->format('M j, Y') }}

                                                                    </div>
                                                                </div>

                                                                <div class="timeline-body">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-8">
                                                                            <p class="mb-0">
                                                                                <span class="author-link">
                                                                                    {{ $item->creator->name ?? 'N/A' }}
                                                                                </span>
                                                                                logged an activity with
                                                                                <span class="organization">
                                                                                    {{ $item->participant_names }}
                                                                                </span>
                                                                            </p>
                                                                        </div>

                                                                        <div class="col-4 text-end">
                                                                            <button
                                                                                class="btn btn-sm btn-outline-primary me-1 add-comment-btn"
                                                                                title="Add Comment" data-type="Activity"
                                                                                data-id="{{ $item->id }}">
                                                                                <i class="fas fa-comment"></i>
                                                                            </button>
                                                                            <button
                                                                                class="btn btn-sm btn-outline-danger delete-activity-btn"
                                                                                title="Delete Activity"
                                                                                data-type="Activity"
                                                                                data-id="{{ $item->id }}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="activity-details">
                                                                        <div class="row">
                                                                            <div class="col-10">
                                                                                <div class="activity-label mb-0">
                                                                                    {{ $item->activityType->type ?? 'N/A' }}
                                                                                </div>
                                                                                <div class="activity-description">
                                                                                    <div class="text-muted mb-2">
                                                                                        <span><i
                                                                                                class="fas fa-pen-to-square text-primary me-1"></i></span>
                                                                                        {{ $item->note }}
                                                                                    </div>
                                                                                    <div class="text-muted">
                                                                                        <span><i
                                                                                                class="fas fa-file-alt text-warning me-1"></i></span>
                                                                                        {{ $item->description }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-2">
                                                                                <div class="activity-badges">
                                                                                    <span
                                                                                        class="activity-badge badge-cc">JB</span>
                                                                                    <span
                                                                                        class="activity-badge badge-cc">TC</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    @if ($item->comments->isNotEmpty())
                                                                        <div class="comment-box d-flex flex-column">
                                                                            @foreach ($item->comments as $comment)
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center mb-2">
                                                                                    <div>
                                                                                        <span class="comment-avatar">
                                                                                            {{ strtoupper(substr($comment->creator->name ?? 'N/A', 0, 2)) }}
                                                                                        </span>
                                                                                        <span
                                                                                            class="comment-text">{{ $comment->comment }}</span>
                                                                                    </div>
                                                                                    <span
                                                                                        class="btn btn-sm delete-comment-btn"
                                                                                        data-id="{{ $comment->id }}"
                                                                                        data-type="Activity">
                                                                                        <i class="fas fa-times"></i>
                                                                                    </span>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif

                                                                    <div class="mt-3 d-none add-comment"
                                                                        data-id="{{ $item->id }}"
                                                                        data-type="Activity">
                                                                        <textarea id="activity-comment-textarea" name="comment_text" class="form-textarea"
                                                                            placeholder="Write a comment…"data-tribute="true" style="width:100%"></textarea>

                                                                        <button
                                                                            class="mt-3 btn btn-sm btn-outline-success add-comment-submit"
                                                                            title="">
                                                                            Add Comment
                                                                        </button>
                                                                        <button
                                                                            class="mt-3 btn btn-sm btn-outline-danger comment-cancel"
                                                                            title="Close">
                                                                            Close
                                                                        </button>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>

                                        </div>

                                        <!-- TO DO TAB -->
                                        <div class="tab-pane fade" id="todo" role="tabpanel"
                                            aria-labelledby="todo-tab">

                                            <div class="filter-section mb-3">
                                                <div class="row g-2 align-items-center">
                                                    <!-- Filter Range -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange" id="filter-task-range"
                                                            name="filter_range">
                                                            <option value="all">All Entries</option>
                                                            <option value="7">Last 7 Days</option>
                                                            <option value="30">Last 30 Days</option>
                                                            <option value="90">Last 90 Days</option>
                                                        </select>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange"
                                                            id="filter-task-status" name="status">
                                                            <option value="all">All Status</option>
                                                            <option value="completed">Completed</option>
                                                            <option value="uncompleted">Uncompleted</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="pendingTasksContainer">

                                                @foreach ($alltasks as $task)
                                                    <div class="task-section mt-2">
                                                        <div class="company-list mb-3 border rounded p-3">
                                                            <div class="row align-items-start">
                                                                <div class="col-md-6">
                                                                    <div class="company-name">
                                                                        <p><strong>{{ $task->title ?? 'N/A' }}</strong></p>
                                                                        <p class="text-secondary">
                                                                            Due
                                                                            {{ \Carbon\Carbon::parse($task->due_time)->format('M d, \a\t g:i a') }}
                                                                        </p>
                                                                        <p class="text-warning">
                                                                            {{ $task->assignee_name ?? 'N/A' }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 d-flex justify-content-end">
                                                                    <div class="d-flex gap-2">
                                                                        <!-- Completed -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-success mark-complete-btn"
                                                                            title="Mark as Completed"
                                                                            data-id="{{ $task->id }}">
                                                                            <i class="fas fa-check"></i>
                                                                        </button>

                                                                        <!-- Edit -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-primary toggleEditTask"
                                                                            data-id="{{ $task->id }}"
                                                                            data-title="{{ $task->title }}"
                                                                            data-due="{{ $task->due_time }}"
                                                                            data-user="{{ $task->assignee_id }}"
                                                                            data-description="{{ $task->description }}"
                                                                            title="Edit Task">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-secondary delete-task-btn"
                                                                            title="Delete Task"
                                                                            data-id="{{ $task->id }}">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <div
                                                                        class="email-preview border rounded p-3 text-secondary">
                                                                        {{ $task->description ?? 'N/A' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                </div>

                                        </div>

                                        <!-- TIMELINE TAB -->
                                        <div class="tab-pane fade" id="timeline" role="tabpanel"
                                            aria-labelledby="timeline-tab">

                                            <div class="filter-section mb-3">
                                                <div class="row g-2 align-items-center">
                                                    <!-- Filter Range -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange"
                                                            id="filter-timeline-range" name="filter_range">
                                                            <option value="all">All Entries</option>
                                                            <option value="7">Last 7 Days</option>
                                                            <option value="30">Last 30 Days</option>
                                                            <option value="90">Last 90 Days</option>
                                                        </select>
                                                    </div>

                                                    <!-- Activity Type -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange"
                                                            id="filter-timeline-activity" name="activity_type_id">
                                                            <option value="all">All Activity Types</option>
                                                            @foreach ($activitytypes as $activitytype)
                                                                <option value="{{ $activitytype->id }}">
                                                                    {{ $activitytype->type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange"
                                                            id="filter-timeline-status" name="status">
                                                            <option value="all">All Status</option>
                                                            <option value="logged">Logged</option>
                                                            <option value="scheduled">Scheduled</option>
                                                        </select>
                                                    </div>

                                                    <!-- Type -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange"
                                                            id="filter-timeline-type" name="type">
                                                            <option value="all">All Types</option>
                                                            <option value="activities">Activities</option>
                                                            <option value="notes">Notes</option>
                                                            <option value="updates">Updates</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Timeline -->
                                            <div class="timeline-container">
                                                <div class="timeline position-relative" id="timelineContainer">
                                                    @foreach ($timeline as $item)
                                                        @if ($item->type === 'activity')
                                                            <div class="timeline-item">
                                                                {{-- <div class="timeline-icon">
                                                                    <i class="{{ $item->activityType->icon }}"></i>
                                                                </div> --}}
                                                                <div class="timeline-content">
                                                                    <div class="timeline-header">
                                                                        <div class="timestamp">
                                                                            {{-- {{ \Carbon\Carbon::parse($item->created_at)->format('g:i A \o\n M j, Y') }} --}}
                                                                            {{ \Carbon\Carbon::parse($item->end_time)->format('g:i A') ?? 'N/A' }}
                                                                            on
                                                                            {{ \Carbon\Carbon::parse($item->date)->format('M j, Y') }}

                                                                        </div>
                                                                    </div>

                                                                    <div class="timeline-body">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-8">
                                                                                <p class="mb-0">
                                                                                    <span class="author-link">
                                                                                        {{ $item->creator->name ?? 'N/A' }}
                                                                                    </span>
                                                                                    logged an activity with
                                                                                    <span class="organization">
                                                                                        {{ $item->participant_names }}
                                                                                    </span>
                                                                                </p>
                                                                            </div>

                                                                            <div class="col-4 text-end">
                                                                                <button
                                                                                    class="btn btn-sm btn-outline-primary me-1 add-comment-btn"
                                                                                    title="Add Comment"
                                                                                    data-type="Activity"
                                                                                    data-id="{{ $item->id }}">
                                                                                    <i class="fas fa-comment"></i>
                                                                                </button>
                                                                                <button
                                                                                    class="btn btn-sm btn-outline-danger delete-activity-btn"
                                                                                    title="Delete Activity"
                                                                                    data-type="Activity"
                                                                                    data-id="{{ $item->id }}">
                                                                                    <i class="fas fa-times"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                        <div class="activity-details">
                                                                            <div class="row">
                                                                                <div class="col-10">
                                                                                    <div class="activity-label mb-0">
                                                                                        {{ $item->activityType->type ?? 'N/A' }}
                                                                                    </div>
                                                                                    <div class="activity-description">
                                                                                        <div class="text-muted mb-2">
                                                                                            <span><i
                                                                                                    class="fas fa-pen-to-square text-primary me-1"></i></span>
                                                                                            {{ $item->note }}
                                                                                        </div>
                                                                                        <div class="text-muted">
                                                                                            <span><i
                                                                                                    class="fas fa-file-alt text-warning me-1"></i></span>
                                                                                            {{ $item->description }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <div class="activity-badges">
                                                                                        <span
                                                                                            class="activity-badge badge-cc">JB</span>
                                                                                        <span
                                                                                            class="activity-badge badge-cc">TC</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        @if ($item->comments->isNotEmpty())
                                                                            <div class="comment-box d-flex flex-column">
                                                                                @foreach ($item->comments as $comment)
                                                                                    <div
                                                                                        class="d-flex justify-content-between align-items-center mb-2">
                                                                                        <div>
                                                                                            <span class="comment-avatar">
                                                                                                {{ strtoupper(substr($comment->creator->name ?? 'N/A', 0, 2)) }}
                                                                                            </span>
                                                                                            <span
                                                                                                class="comment-text">{{ $comment->comment }}</span>
                                                                                        </div>
                                                                                        <span
                                                                                            class="btn btn-sm delete-comment-btn"
                                                                                            data-id="{{ $comment->id }}"
                                                                                            data-type="Activity">
                                                                                            <i class="fas fa-times"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif

                                                                        <div class="mt-3 d-none add-comment"
                                                                            data-id="{{ $item->id }}"
                                                                            data-type="Activity">
                                                                            <textarea id="activity-comment-textarea" name="comment_text" class="form-textarea"
                                                                                placeholder="Write a comment…"data-tribute="true" style="width:100%"></textarea>

                                                                            <button
                                                                                class="mt-3 btn btn-sm btn-outline-success add-comment-submit"
                                                                                title="">
                                                                                Add Comment
                                                                            </button>
                                                                            <button
                                                                                class="mt-3 btn btn-sm btn-outline-danger comment-cancel"
                                                                                title="Close">
                                                                                Close
                                                                            </button>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        @elseif ($item->type === 'note')
                                                            <div class="timeline-item">
                                                                {{-- <div class="timeline-icon">
                                                                    <i class="fas fa-sticky-note"></i>
                                                                </div> --}}
                                                                <div class="timeline-content">
                                                                    <div class="timeline-header">
                                                                        <div class="timestamp">
                                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('g:i A \o\n M j, Y') }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="timeline-body">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-8">
                                                                                <p class="mb-0">
                                                                                    <span class="author-link">
                                                                                        {{ $item->creator->name ?? 'N/A' }}
                                                                                    </span>
                                                                                    wrote a note on
                                                                                    <span class="organization">
                                                                                        {{ $item->owner->name }}
                                                                                    </span>
                                                                                </p>
                                                                            </div>

                                                                            <div class="col-4 text-end">
                                                                                <button
                                                                                    class="btn btn-sm btn-outline-primary me-1 add-comment-btn"
                                                                                    title="Add Comment" data-type="Note"
                                                                                    data-id="{{ $item->id }}">
                                                                                    <i class="fas fa-comment"></i>
                                                                                </button>
                                                                                <button
                                                                                    class="btn btn-sm btn-outline-danger delete-note-btn"
                                                                                    title="Delete Note" data-type="Note"
                                                                                    data-id="{{ $item->id }}">
                                                                                    <i class="fas fa-times"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>


                                                                        <div class="activity-details">
                                                                            <div class="row">
                                                                                <div class="col-10">
                                                                                    <div class="activity-description">
                                                                                        <div class="text-muted mb-2">
                                                                                            <span><i
                                                                                                    class="fas fa-pen-to-square text-primary me-1"></i></span>
                                                                                            {{ $item->note }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <div class="activity-badges">
                                                                                        <span
                                                                                            class="activity-badge badge-cc">JB</span>
                                                                                        <span
                                                                                            class="activity-badge badge-cc">TC</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        @if ($item->comments->isNotEmpty())
                                                                            <div class="comment-box d-flex flex-column">
                                                                                @foreach ($item->comments as $comment)
                                                                                    <div
                                                                                        class="d-flex justify-content-between align-items-center mb-2">
                                                                                        <div>
                                                                                            <span class="comment-avatar">
                                                                                                {{ strtoupper(substr($comment->creator->name ?? 'N/A', 0, 2)) }}
                                                                                            </span>
                                                                                            <span
                                                                                                class="comment-text">{{ $comment->comment }}</span>
                                                                                        </div>
                                                                                        <span
                                                                                            class="btn btn-sm delete-comment-btn"
                                                                                            data-id="{{ $comment->id }}"
                                                                                            data-type="Activity">
                                                                                            <i class="fas fa-times"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif

                                                                        <div class="mt-3 d-none add-comment"
                                                                            data-id="{{ $item->id }}"
                                                                            data-type="Note">
                                                                            <textarea id="note-comment-textarea" name="comment_text" class="form-textarea"
                                                                                placeholder="Write a comment…"data-tribute="true" style="width:100%"></textarea>

                                                                            <button
                                                                                class="mt-3 btn btn-sm btn-outline-success add-comment-submit"
                                                                                title="">
                                                                                Add Comment
                                                                            </button>
                                                                            <button
                                                                                class="mt-3 btn btn-sm btn-outline-danger comment-cancel"
                                                                                title="Close">
                                                                                Close
                                                                            </button>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        @elseif ($item->type === 'timeline')
                                                            <div class="timeline-item">
                                                                {{-- <div class="timeline-icon">
                                                                    <i class="fas fa-angle-double-right"></i>
                                                                </div> --}}
                                                                <div class="timeline-content">
                                                                    <div class="timeline-header">
                                                                        <div class="timestamp">
                                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('g:i A \o\n M j, Y') }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="timeline-body">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-12">
                                                                                <p class="mb-0">
                                                                                    <span class="author-link">
                                                                                        {{ $item->creator->name ?? 'N/A' }}
                                                                                    </span>
                                                                                    {{ $item->description ?? 'N/A' }}
                                                                                </p>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        @elseif ($item->type === 'milestone')
                                                            <div class="timeline-item milestone">
                                                                {{-- <div class="timeline-icon">
                                                                    <i class="fa-brands fa-web-awesome"></i>
                                                                </div> --}}
                                                                <strong>🎉 {{ $item->title }}</strong>
                                                                <span
                                                                    class="text-muted">{{ $item->timestamp->format('M d, Y') }}</span>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->


        <!-- Add Sales Metrics Modal Start -->
        <div class="modal fade" id="SalesMetricsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Edit Sales metrics card</h1>
                        <div>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                    </div>
                    <div class="modal-body">
                        <form class="company-form">
                            <div class="form-group mb-3">
                                <label for="cardTitle" class="form-label">Name OF card *</label>
                                <input type="text" class="form-control" id="cardTitle" placeholder="Sales metrics"
                                    value="Sales metrics">
                            </div>
                            <div class="filter-tags mt-3 d-flex flex-wrap gap-3">
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Date Range</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Assignee</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Tags</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Sources</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Products</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Territory</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="preview-section">
                                <div class="preview-header">Preview</div>

                                <!-- Metric Cards -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="metric-card new-lead">
                                            <div class="metric-title">New Lead</div>
                                            <div class="metric-value">6</div>
                                            <p class="metric-change">Down 14% From 7 This Time Last Month</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="metric-card open-leads">
                                            <div class="metric-title">My Open Leads</div>
                                            <div class="metric-value">$5.17M</div>
                                            <p class="metric-change">Down 6% From $5.48m This Time Last Month</p>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="metric-card sales">
                                            <div class="metric-title">Sales</div>
                                            <div class="metric-value">$16.4K</div>
                                            <p class="metric-change">Down 75% From $66.2k This Time Last Month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Create lead</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Sales Metrics Modal Start -->

        <!-- Edit pipeline Modal Start -->
        <div class="modal fade" id="EditPipelineModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Edit Pipeline card</h1>
                        <div>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                    </div>
                    <div class="modal-body">
                        <form class="company-form">
                            <div class="form-group mb-3">
                                <label for="cardTitle" class="form-label">Name OF card *</label>
                                <input type="text" class="form-control" id="cardTitle" placeholder="Pipeline"
                                    value="Pipeline">
                            </div>
                            <div class="filter-tags mt-3 d-flex flex-wrap gap-3">
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Assignee</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Tags</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Sources</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Products</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Territory</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="form-check filter-tag">
                                    <input class="form-check-input" type="checkbox" id="hotLead">
                                    <label class="form-check-label" for="hotLead">Hot leads only</label>
                                </div>
                            </div>

                            <div class="pipeline-card">
                                <div class="pipeline-header">
                                    <h2 class="section-title">Pipeline</h2>
                                    <p class="pipeline-subtitle">Default Pipeline by stage </p>
                                </div>

                                <div class="pipeline-stages">
                                    <!-- Stage 1: Int. GB Presentation -->
                                    <div class="pipeline-stage stage-1">
                                        <div class="stage-info">
                                            <div class="stage-name">Int. GB Presentation</div>
                                            <div class="stage-metrics">
                                                <span class="leads-count">104 leads</span>
                                                <span class="revenue-amount">$976k</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>

                                    <!-- Stage 2: Site Survey -->
                                    <div class="pipeline-stage stage-2">
                                        <div class="stage-info">
                                            <div class="stage-name">Site Survey</div>
                                            <div class="stage-metrics">
                                                <span class="leads-count">44 leads</span>
                                                <span class="revenue-amount">$286k</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>

                                    <!-- Stage 3: Proposal Approval -->
                                    <div class="pipeline-stage stage-3">
                                        <div class="stage-info">
                                            <div class="stage-name">Proposal Approval</div>
                                            <div class="stage-metrics">
                                                <span class="leads-count">106 leads</span>
                                                <span class="revenue-amount">$2.34m</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>

                                    <!-- Stage 4: Proposal Pres. -->
                                    <div class="pipeline-stage stage-4">
                                        <div class="stage-info">
                                            <div class="stage-name">Proposal Pres.</div>
                                            <div class="stage-metrics">
                                                <span class="leads-count">64 leads</span>
                                                <span class="revenue-amount">$1.56m</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>

                                    <!-- Stage 5: Rec. Signed Proposal -->
                                    <div class="pipeline-stage stage-5">
                                        <div class="stage-info">
                                            <div class="stage-name">Rec. Signed Proposal</div>
                                            <div class="stage-metrics">
                                                <span class="leads-count">3 leads</span>
                                                <span class="revenue-amount">$8.03k</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit pipeline Modal End -->

        <!-- Add LeadSummaryModal Modal Start -->
        <div class="modal fade" id="LeadSummaryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h1 class="modal-title" id="exampleModalLabel">Edit Leads Summary card</h1>
                        </div>
                        <div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                    </div>
                    <div class="modal-body">
                        <div class="customize-fields">
                            <form class="company-form">
                                <div class="form-group mb-3">
                                    <label for="lead-title" class="mb-2">Name OF card *</label>
                                    <input type="text" class="form-control" id="lead-title"
                                        placeholder="Leads Summary">
                                </div>
                                <div class="form-group">
                                    <div class="section-title">NUTSHELL FIELDS</div>
                                    <div class="fields-grid">
                                        <div>
                                            <!-- Field checkboxes (left column) -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="my-lead" checked>
                                                <label class="form-check-label" for="my-lead">My leads</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="Addedthisweek"
                                                    checked><label class="form-check-label" for="Addedthisweek">Added this
                                                    week</label>
                                            </div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="closing"><label class="form-check-label" for="closing">Closing
                                                    this
                                                    week </label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="lead" checked><label class="form-check-label"
                                                    for="lead">All leads
                                                </label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="watching"><label class="form-check-label" for="watching">Leads
                                                    I'm
                                                    watching</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="open-leads"><label class="form-check-label" for="open-leads">My
                                                    open
                                                    leads </label>
                                            </div>
                                        </div>
                                        <div>
                                            <!-- Field checkboxes (right column) -->
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="hot-leads" checked><label class="form-check-label"
                                                    for="hot-leads">Hot leads </label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="all-companies"><label class="form-check-label"
                                                    for="all-companies">All companies</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="my-companies " checked><label class="form-check-label"
                                                    for="my-companies ">My companies </label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="all-people" checked><label class="form-check-label"
                                                    for="all-people">All people
                                                    number</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="my-people"><label class="form-check-label" for="my-people">My
                                                    people
                                                    to</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="marketing-contacts"><label class="form-check-label"
                                                    for="marketing-contacts">Marketing contacts</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <div class="section-title mb-1">Lead Summary</div>
                                    <p class="text-gray mb-2">List Summary </p>
                                    <table class="table table-strip">
                                        <tbody>
                                            <tr>
                                                <td>My leads</td>
                                                <td>7</td>
                                                <td>$12k</td>
                                            </tr>
                                            <tr>
                                                <td>Added this week</td>
                                                <td>6</td>
                                                <td>$8.99k</td>
                                            </tr>
                                            <tr>
                                                <td>Closing this week</td>
                                                <td>0</td>
                                                <td>$0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">SAVE & UPDATE</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add AddCustomizefields Modal End -->

    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            function fetchFilteredAllActivities() {
                let filters = {
                    filter_range: $('#filter-range').val(),
                    activity_type_id: $('#filter-activity').val(),
                    status: $('#filter-status').val(),
                    section: 'logged_activities'
                };

                $.ajax({
                    url: "{{ route('admin.sales.index') }}",
                    method: "GET",
                    data: filters,
                    success: function(response) {
                        $('#allActivitiesContainer').html(response.activity_html);
                    },
                    error: function() {
                        alert('Error fetching filtered activities.');
                    }
                });
            }

            $('#filter-range, #filter-activity, #filter-status')
                .on('change', fetchFilteredAllActivities);

            function fetchFilteredTimeline() {
                console.log("Timeline filtered function called");
                let filters = {
                    filter_range: $('#filter-timeline-range').val(),
                    activity_type_id: $('#filter-timeline-activity').val(),
                    status: $('#filter-timeline-status').val(),
                    type: $('#filter-timeline-type').val(),
                    section: 'timeline'
                };

                $.ajax({
                    url: "{{ route('admin.sales.index') }}",
                    method: "GET",
                    data: filters,
                    success: function(response) {
                        $('#timelineContainer').html(response.timeline_html);
                    },
                    error: function() {
                        alert('Error fetching filtered timeline.');
                    }
                });
            }

            $('#filter-timeline-range, #filter-timeline-activity, #filter-timeline-status, #filter-timeline-type')
                .on('change', fetchFilteredTimeline);

            function fetchFilteredTask() {
                console.log("Task filtered function called");

                let filters = {
                    filter_range: $('#filter-task-range').val(),
                    status: $('#filter-task-status').val(),
                    section: 'task'
                };

                $.ajax({
                    url: "{{ route('admin.sales.index') }}", // confirm this route hits your main controller
                    method: "GET",
                    data: filters,
                    success: function(response) {
                        $('#pendingTasksContainer').html(response.task_html);
                    },
                    error: function() {
                        alert('Error fetching filtered task.');
                    }
                });
            }

            $('#filter-task-range, #filter-task-status').on('change', fetchFilteredTask);

        });


        // ==============================
        // Delete Activity
        // ==============================
        $(document).on('click', '.delete-activity-btn', function() {
            var activityId = $(this).data('id'); // get task ID from button

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this activity?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/delete_activity/" + activityId,
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message ||
                                    "Activity deleted successfully.",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(function() {
                                location.reload(); // reload after deletion
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message ||
                                    'Something went wrong.'
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });

        // ==============================
        // Adding the comment
        // ==============================
        $(document).on('click', '.add-comment-submit', function() {
            let commentBox = $(this).closest('.add-comment');
            let type = commentBox.data('type'); // Activity or Note
            let id = commentBox.data('id'); // Item ID
            let commentText = commentBox.find('textarea[name="comment_text"]').val();

            if (!commentText.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Comment',
                    text: 'Please enter a comment before submitting.'
                });
                return;
            }

            // Determine URL based on type (like delete)
            let url = '';
            if (type === 'Activity') {
                url = '/admin/activity/add_comment/' + id;
            } else {
                url = '/admin/note/add_comment/' + id;
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    comment: commentText
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message ||
                            'Something went wrong while adding the comment.'
                    });
                }
            });
        });


        // ==============================
        // Removing the comment
        // ==============================
        $(document).on('click', '.delete-comment-btn', function() {
            var commentId = $(this).data('id');
            var type = $(this).data('type'); // Activity or Note
            var url = '';

            // Determine URL based on type
            if (type === "Activity") {
                url = "/admin/activity/delete_comment/" + commentId;
            } else {
                url = "/admin/note/delete_comment/" + commentId;
            }

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to remove this comment?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Removed",
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location
                                    .reload(); // reload to update comment list
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: xhr.responseJSON?.message ||
                                    "Something went wrong."
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });


        // ==============================
        // Activity and note Comment box toggle functionality
        // ==============================
        $('.add-comment-btn').click(function() {
            // Find the nearest comment box relative to this button
            $(this).closest('.timeline-item').find('.add-comment').toggleClass('d-none');
        });

        $('.comment-cancel').click(function() {
            const $commentBox = $(this).closest('.add-comment');
            $commentBox.addClass('d-none');
            $commentBox.find('textarea').val(''); // Clear the textarea content
        });

        // Close button functionality
        document.querySelector('.btn-close').addEventListener('click', function() {
            console.log('Modal would close');
        });

        // Checkbox interaction for Choose Fields tab
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                console.log(`${this.id} is now ${this.checked ? 'checked' : 'unchecked'}`);
            });
        });

        // Field checkbox interaction for Re-order Fields tab
        document.querySelectorAll('.field-checkbox').forEach(checkbox => {
            checkbox.addEventListener('click', function() {
                this.classList.toggle('checked');
                if (this.classList.contains('checked')) {
                    this.innerHTML = '<i class="fas fa-check"></i>';
                } else {
                    this.innerHTML = '';
                }
            });
        });

        // Drag and drop functionality
        let draggedElement = null;

        document.querySelectorAll('.reorderable-fields .field-item').forEach(item => {
            item.addEventListener('dragstart', function(e) {
                draggedElement = this;
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
            });

            item.addEventListener('dragend', function(e) {
                this.classList.remove('dragging');
                draggedElement = null;
            });

            item.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
            });

            item.addEventListener('drop', function(e) {
                e.preventDefault();
                if (draggedElement && draggedElement !== this) {
                    const container = this.parentNode;
                    const afterElement = getDragAfterElement(container, e.clientY);
                    if (afterElement == null) {
                        container.appendChild(draggedElement);
                    } else {
                        container.insertBefore(draggedElement, afterElement);
                    }
                }
            });
        });

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.field-item:not(.dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return {
                        offset: offset,
                        element: child
                    };
                } else {
                    return closest;
                }
            }, {
                offset: Number.NEGATIVE_INFINITY
            }).element;
        }

        // Redirecting user to index page of leads with attached filters
        $('.pipeline-stage').on('click', function() {
            const stageId = $(this).data('lead-stage');
            sessionStorage.setItem('selectedLeadStage', stageId);
            window.location.href = "{{ route('admin.leads.index') }}";
        });

        // When user clicks on "NEW LEAD" metric card
        $('#newLeadCard').on('click', function() {
            sessionStorage.setItem('lead_filters', JSON.stringify({
                month_to_date: true,
            }));
            window.location.href = "{{ route('admin.leads.index') }}";
        });

        // Handle "OPEN LEADS" card click
        $('#openLeadCard').on('click', function() {
            // Save both filters (Month-to-Date + Open status)
            sessionStorage.setItem('lead_filters', JSON.stringify({
                month_to_date: true,
                leads_status: ['open']
            }));
            window.location.href = "{{ route('admin.leads.index') }}";
        });

        // Handle "SALE LEADS" card click
        $('#saleLeadCard').on('click', function() {
            // Save both filters (Month-to-Date + Open status)
            sessionStorage.setItem('lead_filters', JSON.stringify({
                month_to_date: true,
                leads_status: ['won']
            }));
            window.location.href = "{{ route('admin.leads.index') }}";
        });
    </script>
@endpush
