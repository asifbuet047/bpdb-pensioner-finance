@extends('layouts.layout')

@section('title', 'Access Denied')

@section('content')

    <section class="py-5">
        <div class="container text-center scale-animate-infinite">
            <h1 class="mb-4 fw-bold">Access Denied</h1>
            <h3 class="mb-4 fw-bold">You don't have permission please contact with admin</h3>
            <div class="row g-3 justify-content-center">
                <!-- Show Acess Denied Warning -->
                <div class="col-12 col-md-4">
                    <div class="info-box rounded shadow text-white"
                        style="background: linear-gradient(135deg, #8e0e00, #1f1c18);">
                        <div>
                            <h3 class="mb-3">Home page</h3>
                            <a href="{{ route('home.page') }}" class="text-white fw-bold text-decoration-none">
                                More info <i class="bi bi-house-door"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    </section>

@endsection
