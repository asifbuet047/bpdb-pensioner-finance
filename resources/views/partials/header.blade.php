<header>
    <nav class="navbar navbar-expand-lg navbar-light py-3 custom-border" style="background-color: #A2E8DD">
        <div class="container">
            <a class="navbar-brand fw-bolder" href="{{ route('home.page') }}">BPDB
                Pensioner Management App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-bold">
                    <li class="nav-item scale-animate list-unstyled d-flex justify-content-center align-items-center">
                        <div id="react-app"></div>
                    </li>
                    <li class="nav-item scale-animate"><a class="nav-link" href="{{ route('home.page') }}">Home</a>
                    </li>

                    @if (isset($officer_role) && $officer_role === 'super_admin')
                        <li class="nav-item scale-animate"><a class="nav-link" href="/pensioners/all">All Pensioner</a>
                        </li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/officers">All Officer</a></li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/offices">All Office</a></li>
                    @endif
                    @if (isset($officer_role) && $officer_role === 'admin')
                        <li class="nav-item scale-animate"><a class="nav-link" href="/pensioners/all">All Pensioner</a>
                        </li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/officers">All Officer</a></li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/offices">All Office</a></li>
                    @endif
                    @if (isset($officer_role) && $officer_role === 'approver')
                        <li class="nav-item scale-animate"><a class="nav-link" href="/pensioners/all">All Pensioners</a>
                        </li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/offices">All Offices</a></li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/offices">All Officers</a></li>
                    @endif
                    @if (isset($officer_role) && $officer_role === 'certifier')
                        <li class="nav-item scale-animate"><a class="nav-link" href="/pensioners/all">All Pensioners</a>
                        </li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/offices">All Offices</a></li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/offices">All Officers</a></li>
                    @endif
                    @if (isset($officer_role) && $officer_role === 'initiator')
                        <li class="nav-item scale-animate"><a class="nav-link" href="/pensioners/all">All Pensioners</a>
                        </li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/offices">All Offices</a></li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/offices">All Officers</a></li>
                    @endif

                    @if (isset($officer_name))
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $officer_name }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-item">You are <span
                                        class="fw-bold">{{ $officer_designation }}</span>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-item">Your office <span class="fw-bold">{{ $officer_office }}</span>
                                </li>
                                <li class="dropdown-divider"></li>
                                @if ($officer_role === 'super_admin')
                                    <li class="dropdown-item">Your role is <span
                                            class="fw-bold">{{ 'SUPER ADMIN' }}</span>
                                    </li>
                                @endif
                                @if ($officer_role === 'admin')
                                    <li class="dropdown-item">Your role <span class="fw-bold">{{ 'ADMIN' }}</span>
                                    </li>
                                @endif
                                @if ($officer_role === 'approver')
                                    <li class="dropdown-item">Your role <span class="fw-bold">{{ 'APPROVER' }}</span>
                                    </li>
                                @endif
                                @if ($officer_role === 'certifier')
                                    <li class="dropdown-item">Your role <span class="fw-bold">{{ 'CERTIFIER' }}</span>
                                    </li>
                                @endif
                                @if ($officer_role === 'initiator')
                                    <li class="dropdown-item">Your role <span class="fw-bold">{{ 'INITIATOR' }}</span>
                                    </li>
                                @endif
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                            </ul>
                        </div>
                        </a>
                    @else
                        <li class="nav-item scale-animate"><a class="nav-link"
                                href="{{ route('login.page', ['type' => 'officer']) }}">Login</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
