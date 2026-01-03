@extends('layouts.layout')

@section('title', 'All Pensioners')

@section('content')

    <section class="py-5">
        <div class="container text-center">

            <h2 class="mb-4 fw-bold">List all Pension's Status</h2>

            <div class="row g-3 justify-content-center">
                @if ($officer_role === 'initiator')
                    <!-- Floated Pensioners card -->
                    <div class="col-12 col-md-4 scale-animate">
                        <div class="info-box rounded shadow text-white"
                            style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                            <div>
                                <h3>{{ $floatedPensionsCount }} pending tasks</h3>
                                <h3 class="mb-3">Show all</h3>
                                <a href="{{ route('show.all.generated.pensions') }}"
                                    class="text-white fw-bold text-decoration-none">
                                    More info <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="icon fs-1 mt-3">
                                <i class="bi bi-person-fill-add"></i>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($officer_role === 'certifier')
                    <!-- Initiated Pensioners card -->
                    <div class="col-12 col-md-4 scale-animate">
                        <div class="info-box rounded shadow text-white"
                            style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                            <div>
                                <h3>{{ $initiatedPensionsCount }} pending tasks</h3>
                                <h3 class="mb-3">Show all</h3>
                                <a href="{{ route('show.all.generated.pensions') }}"
                                    class="text-white fw-bold text-decoration-none">
                                    More info <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="icon fs-1 mt-3">
                                <i class="bi bi-person-fill-add"></i>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($officer_role === 'approver')
                    <!-- Certified Pensioners card -->
                    <div class="col-12 col-md-4 scale-animate">
                        <div class="info-box rounded shadow text-white"
                            style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                            <div>
                                <h3>{{ $certifiedPensionsCount }} pending tasks</h3>
                                <h3 class="mb-3">Show all</h3>
                                <a href="{{ route('show.all.generated.pensions') }}"
                                    class="text-white fw-bold text-decoration-none">
                                    More info <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="icon fs-1 mt-3">
                                <i class="bi bi-person-fill-add"></i>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Approved Pensioners -->
                <div class="col-12 col-md-4 scale-animate">
                    <div class="info-box rounded shadow text-white"
                        style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                        <div>
                            <h3>{{ $approvedPensionsCount }} Months Approved Pensions</h3>
                            <h3 class="mb-3">Show all Approved Pensions</h3>
                            <a href="{{ route('show.all.generated.pensions', ['type' => 'approved', 'action' => 'false']) }}"
                                class="text-white fw-bold text-decoration-none">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="icon fs-1 mt-3">
                            <i class="bi bi-person-fill-add"></i>
                        </div>
                    </div>
                </div>

                @if ($officer_role === 'initiator')
                    <!-- Initiate Invoice -->
                    <div class="col-12 col-md-4 scale-animate">
                        <div class="info-box rounded shadow text-white"
                            style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                            <div>
                                <h3 class="mb-3">Print Invoice</h3>
                                <a href="{{ route('show.all.generated.pensions', ['type' => 'approved', 'action' => 'false', 'print' => 'true']) }}"
                                    class="text-white fw-bold text-decoration-none">
                                    More info <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="icon fs-1 mt-3">
                                <i class="bi bi-person-fill-add"></i>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
