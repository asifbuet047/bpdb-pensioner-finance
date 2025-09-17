@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
    <section class="vh-100 py-5" style="background-color: #CEF3ED">
        <div class="container text-center">
            @if (request()->cookie('user_role') === 'SUPER_ADMIN')
                <h2 class="mb-4 fw-bold">Pensioner & User Management</h2>
            @else
                <h2 class="mb-4 fw-bold">Pensioner Management</h2>
            @endif


            @if (request()->cookie('user_role') === 'SUPER_ADMIN')
                <div class="row g-3 justify-content-center">
                    <!-- Add Pensioner Button -->
                    <div class="col-12 col-md-4">
                        <a href="{{ route('add.pensioner.section') }}"
                            class="btn btn-primary btn-lg w-100 shadow-lg text-white fw-bold">
                            Add Pensioner
                        </a>
                    </div>

                    <!-- View All Pensioner Button -->
                    <div class="col-12 col-md-4">
                        <a href="{{ route('show.pensioner.section') }}"
                            class="btn btn-primary btn-lg w-100 shadow-lg fw-bold">
                            View All Pensioners
                        </a>
                    </div>
                    <!-- View All officers Button conditional rendering-->
                    <div class="col-12 col-md-4">
                        <a href="{{ route('show.officers') }}" class="btn btn-primary btn-lg w-100 shadow-lg fw-bold">
                            View All Officers
                        </a>
                    </div>

                    <!-- View All Offices Button conditional rendering-->
                    <div class="col-12 col-md-4">
                        <a href="{{ route('show.offices') }}" class="btn btn-primary btn-lg w-100 shadow-lg fw-bold">
                            View All Offices
                        </a>
                    </div>
                </div>
            @else
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
                        <a href="{{ route('show.pensioner.section') }}"
                            class="btn btn-primary btn-lg w-100 shadow-lg fw-bold">
                            View All Pensioners
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection
