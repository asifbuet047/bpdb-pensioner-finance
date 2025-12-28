<header>
    <nav class="navbar navbar-expand-lg navbar-light py-3 custom-border" style="background-color: #A2E8DD">
        <div class="container">

            <a class="navbar-brand fw-bolder" href="{{ route('home.page') }}">
                BPDB Pensioner Management App
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-bold align-items-center">

                    @if (isset($user_type))

                        {{-- Notification --}}
                        <li class="nav-item">
                            <div id="notification"></div>
                        </li>

                        {{-- Home --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home.page') }}">Home</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="/pensioners/all">Workflow</a></li>
                        {{-- User Dropdown --}}
                        @if (isset($pensionerDetails->name))
                            <li class="nav-item dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $pensionerDetails->name }}
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">

                                    <li class="dropdown-item">
                                        You are <span class="fw-bold">{{ $pensionerDetails->designation }}</span>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="dropdown-item">
                                        Last Unit Office <span
                                            class="fw-bold">{{ $pensionerDetails->office->name_in_english }}</span>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="dropdown-item">
                                        RAO office <span
                                            class="fw-bold">{{ $paymentOfficeDetails->name_in_english }}</span>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login.page', ['type' => 'officer']) }}">
                                    Login
                                </a>
                            </li>
                        @endif
                    @else
                        {{-- Notification --}}
                        <li class="nav-item">
                            <div id="notification"></div>
                        </li>

                        {{-- Home --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home.page') }}">Home</a>
                        </li>

                        {{-- Role-based menus --}}
                        @if (isset($officer_role) && in_array($officer_role, ['super_admin', 'admin']))
                            <li class="nav-item"><a class="nav-link" href="/pensioners/all">All Pensioners</a></li>
                            <li class="nav-item"><a class="nav-link" href="/officers">All Officers</a></li>
                            <li class="nav-item"><a class="nav-link" href="/offices">All Offices</a></li>
                        @endif

                        @if (isset($officer_role) && in_array($officer_role, ['approver', 'certifier', 'initiator']))
                            <li class="nav-item"><a class="nav-link" href="/pensioners/all">All Pensioners</a></li>
                            <li class="nav-item"><a class="nav-link" href="/offices">All Offices</a></li>
                            <li class="nav-item"><a class="nav-link" href="/officers">All Officers</a></li>
                        @endif

                        {{-- User Dropdown --}}
                        @if (isset($officer_name))
                            <li class="nav-item dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $officer_name }}
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">

                                    <li class="dropdown-item">
                                        You are <span class="fw-bold">{{ $officer_designation }}</span>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="dropdown-item">
                                        Office <span class="fw-bold">{{ $officer_office }}</span>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="dropdown-item">
                                        Role <span class="fw-bold">{{ strtoupper($officer_role) }}</span>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login.page', ['type' => 'officer']) }}">
                                    Login
                                </a>
                            </li>
                        @endif
                    @endif

                </ul>
            </div>
        </div>
    </nav>
</header>
