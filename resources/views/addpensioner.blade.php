@extends('layouts.layout')

@section('title', 'Add Pensioner')

@section('content')

    <section class="py-5">
        <div class="container text-center">
            @if ($officer_role === 'super_admin')
                <h2 class="mb-4 fw-bold">Pensioner & User Management</h2>
            @else
                <h2 class="mb-4 fw-bold">Pensioner Management</h2>
            @endif


            <div class="row g-3 justify-content-center">
                <!-- Add Pensioner by ERP Button -->
                <div class="col-12 col-md-4 scale-animate">
                    <div class="info-box rounded shadow text-white"
                        style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                        <div>
                            <h3 class="mb-3">Add Pensioner by ERP</h3>
                            <a href="{{ route('add.pensioner.erp.section') }}"
                                class="text-white fw-bold text-decoration-none">
                                More info <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="icon fs-1 mt-3">
                            <i class="bi bi-person-fill-add"></i>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 scale-animate">
                    <div class="info-box rounded shadow text-white"
                        style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                        <div>
                            <h3 class="mb-3">Add Pensioner by Form</h3>
                            <a href="{{ route('add.pensioner.form.section') }}"
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
