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
            <a class="navbar-brand fw-bolder" href="/">BPDB Pensioner Management App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-bold">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pensioners">All Pensioner</a></li>
                    <li class="nav-item"><a class="nav-link" href="/officers">All Officer</a></li>
                    @if (request()->hasCookie('user_token'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login.page') }}">Login</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
