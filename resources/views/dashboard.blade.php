@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
    <section class="vh-100 py-5" style="background-color: #CEF3ED">
        <div class="container text-center">
            <h2 class="mb-4 fw-bold">Pensioner Management</h2>

            <div class="row g-3 justify-content-center">
                <!-- Add Pensioner Button -->
                <div class="col-12 col-md-6">
                    <a href="{{ route('add.pensioner.section') }}"
                        class="btn btn-primary btn-lg w-100 shadow-lg text-white fw-bold">
                        Add Pensioner
                    </a>
                </div>

                <!-- View All Pensioner Button -->
                <div class="col-12 col-md-6">
                    <a href="{{ route('show.pensioner.section') }}" class="btn btn-primary btn-lg w-100 shadow-lg fw-bold">
                        View All Pensioners
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
