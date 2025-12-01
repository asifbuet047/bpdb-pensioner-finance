<header>
    <style>
        .custom-border {
            border: 3px solid black !important;
        }

        .custom-border th,
        .custom-border td {
            border: 2px solid black !important;
        }
    </style>
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
                    <li class="nav-item scale-animate"><a class="nav-link" href="{{ route('home.page') }}">Home</a>
                    </li>

                    @if (request()->cookie('user_role') === '5')
                        <li class="nav-item scale-animate"><a class="nav-link" href="/pensioners/all">All Pensioner</a>
                        </li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/officers">All Officer</a></li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/offices">All Office</a></li>
                    @endif
                    @if (request()->cookie('user_role') === '4')
                        <li class="nav-item scale-animate"><a class="nav-link" href="/pensioners/all">All Pensioner</a>
                        </li>
                        <li class="nav-item scale-animate"><a class="nav-link" href="/offices">All Office</a></li>
                    @endif

                    @if (request()->hasCookie('user_id') && request()->hasCookie('user_role') && request()->hasCookie('user_name'))
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ request()->cookie('user_name') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-item">You are <span
                                        class="fw-bold">{{ $designation->description_english }}</span>
                                </li>
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
