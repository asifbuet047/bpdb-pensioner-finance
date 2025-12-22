@extends('layouts.layout')

@section('title', 'Add Pensioner')

@section('content')

    <section class="py-5">
        <div class="container text-center">

            <h2 class="mb-4 fw-bold">List all Pensioner's Status</h2>

            <div class="row g-3 justify-content-center">
                <!-- Initiated Pensioners -->
                <div class="col-12 col-md-4 scale-animate">
                    <div class="info-box rounded shadow text-white"
                        style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                        <div>
                            <h3>{{ $initiatedPensionersCount }} pensioners</h3>
                            <h3 class="mb-3">All Initiated Pensioners</h3>
                            <a href="{{ route('show.pensioner.section', ['type' => 'initiated']) }}"
                                class="text-white fw-bold text-decoration-none">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="icon fs-1 mt-3">
                            <i class="bi bi-person-fill-add"></i>
                        </div>
                    </div>
                </div>


                <!-- Certified Pensioners -->
                <div class="col-12 col-md-4 scale-animate">
                    <div class="info-box rounded shadow text-white"
                        style="background: linear-gradient(135deg, #ff7e5f, #feb47b);">
                        <div>
                            <h3>{{ $certifiedPensionersCount }} pensioners</h3>
                            <h3 class="mb-3">All Certified Pensioners</h3>
                            <a href="{{ route('show.pensioner.section', ['type' => 'certified']) }}"
                                class="text-white fw-bold text-decoration-none">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="icon fs-1 mt-3">
                            <i class="bi bi-person-fill-add"></i>
                        </div>
                    </div>
                </div>


                <!-- Approved Pensioners -->
                <div class="col-12 col-md-4 scale-animate">
                    <div class="info-box rounded shadow text-white"
                        style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                        <div>
                            <h3>{{ $approvedPensionersCount }} pensioners</h3>
                            <h3 class="mb-3">All Approved Pensioners</h3>
                            <a href="{{ route('show.pensioner.section', ['type' => 'approved']) }}"
                                class="text-white fw-bold text-decoration-none">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="icon fs-1 mt-3">
                            <i class="bi bi-person-fill-add"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
