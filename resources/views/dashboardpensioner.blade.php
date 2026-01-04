@extends('layouts.layout')

@section('title', 'Dashboard of Pensioner')

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center p-4">
                        @php
                            $avatarUrl =
                                'https://ui-avatars.com/api/?name=' .
                                urlencode($pensionerDetails->name) .
                                '&background=0D6EFD&color=fff';
                        @endphp

                        <img src="{{ $avatarUrl }}" alt="Profile" class="rounded-circle mb-3" width="130" height="130">

                        <h4 class="fw-bold mb-1">{{ $pensionerDetails->name }}</h4>
                        <p class="text-muted mb-2">ERP ID: {{ $pensionerDetails->erp_id }}</p>
                        <p class="text-secondary small">{{ $pensionerDetails->designation }}</p>
                        <p class="text-secondary small">{{ $pensionerDetails->office->officeName }}</p>

                        <div class="d-flex justify-content-center mt-3 gap-2">
                            <a href="{{ route('pensioner.pension.apply.form') }}" class="btn btn-primary btn-sm px-4">Apply
                                for Pension</a>
                            <form method="POST" action="">
                                @csrf
                                <button type="button" class="btn btn-outline-secondary btn-sm px-4"><a
                                        class="dropdown-item" href="{{ route('logout') }}">Logout</a></button>
                            </form>
                        </div>

                        <hr class="my-4">

                        <div class="text-start small">
                            <p class="mb-2"><strong>Bank:</strong> {{ $pensionerDetails->bank_name }}</p>
                            <p class="mb-2"><strong>Account No:</strong> {{ $pensionerDetails->account_number }}</p>
                            <p class="mb-2"><strong>Monthly Pension:</strong> ৳
                                {{ number_format($pensionerDetails->net_pension, 2) }}</p>
                            <p class="mb-0"><strong>Status:</strong>
                                <span class="badge bg-success">{{ $pensionerDetails->status }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">

                <!-- Stats Row -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body">
                                <div class="fs-4 fw-semibold mb-1">৳ {{ number_format($total_recevied, 2) }}</div>
                                <div class="text-muted small">Total Received</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body">
                                <div class="fs-5 fw-semibold mb-1">
                                    {{ \Carbon\Carbon::parse($last_payment_date)->format('M d, Y') }}</div>
                                <div class="text-muted small">Last Payment</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body">
                                <div class="fs-4 fw-semibold mb-1">0</div>
                                <div class="text-muted small">Pending Issues</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Details -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-2">
                        <h5 class="fw-semibold mb-0">Personal Details</h5>
                    </div>
                    <div class="card-body text-secondary small">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <strong>Name:</strong><br>{{ $pensionerDetails->name }}
                            </div>
                            <div class="col-md-6">
                                <strong>Date of Birth:</strong><br>{{ $pensionerDetails->birth_date }}
                            </div>
                            <div class="col-md-6">
                                <strong>NID / Passport:</strong><br>{{ $pensionerDetails->nid }}
                            </div>
                            <div class="col-md-6">
                                <strong>Contact:</strong><br>{{ $pensionerDetails->phone_number }}
                            </div>
                            <div class="col-12">
                                <strong>Address:</strong><br>Dhaka, Bangladesh
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Payments -->
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4 pb-2">
                        <h5 class="fw-semibold mb-0">Recent Payments</h5>
                        <a href="#" class="text-primary small text-decoration-none">View All</a>
                    </div>
                    <div class="card-body">
                        @foreach ($pensionerspensions as $pensionerspension)
                            <div
                                class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom">
                                <div>
                                    <div class="fw-semibold text-dark">৳
                                        {{ number_format($pensionerspension->total_pension_amount, 2) }}</div>
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($pensionerspension->created_at)->format('d M Y') }} ·
                                        {{ $pensionerspension->net_pension }}
                                    </div>
                                </div>
                                <span
                                    class="badge bg-light text-dark border">{{ ucfirst($pensionerspension->pension->status) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
