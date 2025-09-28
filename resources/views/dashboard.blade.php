@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
    <section class="py-5">
        <div class="container text-center">
            @if (request()->cookie('user_role') === 'SUPER_ADMIN')
                <h2 class="mb-4 fw-bold">Pensioner & User Management</h2>
            @else
                <h2 class="mb-4 fw-bold">Pensioner Management</h2>
            @endif


            @if (request()->cookie('user_role') === 'SUPER_ADMIN')
                <div class="row g-3 justify-content-center">
                    <!-- Add Pensioner Button -->
                    <div class="col-12 col-md-4 scale-animate">
                        <div class="info-box">
                            <div>
                                <h3>Add Pensioner</h3>
                                <a href="{{ route('add.pensioner.section') }}">More info <i class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="icon"><i class="bi bi-person-fill-add"></i></div>
                        </div>
                    </div>

                    <!-- View All Pensioner Button -->
                    <div class="col-12 col-md-4 scale-animate">
                        <div class="info-box">
                            <div>
                                <h3>{{ $pensionerCount }} pensioner</h3>
                                <h3>View All Pensioners</h3>
                                <a href="{{ route('show.pensioner.section') }}">More info <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="icon"><i class="bi bi-people-fill"></i></div>
                        </div>
                    </div>
                    <!-- View All officers Button conditional rendering-->
                    <div class="col-12 col-md-4 scale-animate">
                        <div class="info-box">
                            <div>
                                <h3>{{ $officerCount }} officer</h3>
                                <h3>View All Officers</h3>
                                <a href="{{ route('show.officers') }}">More info <i class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="icon"><i class="bi bi-person-arms-up"></i></div>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-3 justify-content-center">
                    <!-- View All Offices Button conditional rendering-->
                    <div class="col-12 col-md-6 scale-animate">
                        <div class="info-box">
                            <div>
                                <h3>{{ $officeCount }} office</h3>
                                <h3>View All Offices</h3>
                                <a href="{{ route('show.offices') }}">More info <i class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="icon"><i class="bi bi-building"></i></div>
                        </div>
                    </div>

                    <!-- View Add Office Button conditional rendering-->
                    <div class="col-12 col-md-6 scale-animate">
                        <div class="info-box">
                            <div>
                                <h3>Add New Office</h3>
                                <a href="{{ route('add.office.section') }}">More info <i class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="icon"><i class="bi bi-building-add"></i></div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row g-3 justify-content-center">
                    <!-- Add Pensioner Button -->
                    <div class="col-12 col-md-4 scale-animate">
                        <div class="info-box">
                            <div>
                                <h3>Add Pensioner</h3>
                                <a href="{{ route('add.pensioner.section') }}">More info <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="icon"><i class="bi bi-person-fill-add"></i></div>
                        </div>
                    </div>

                    <!-- View All Pensioner Button -->
                    <div class="col-12 col-md-4 scale-animate">
                        <div class="info-box">
                            <div>
                                <h3>{{ $pensionerCount }} pensioner</h3>
                                <h3>View All Pensioners</h3>
                                <a href="{{ route('show.pensioner.section') }}">More info <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="icon"><i class="bi bi-people-fill"></i></div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection
