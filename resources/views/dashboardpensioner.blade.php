@extends('layouts.layout')

@section('title', 'Dashboard of Pensioner')

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center p-4">
                        @php
                            $pensioner = (object) [
                                'name' => 'Md. Asifuzzaman',
                                'erp_id' => 'PEN-1023',
                                'designation' => 'Retired Executive Engineer',
                                'bank_name' => 'Sonali Bank Ltd.',
                                'account_no' => '1234567890',
                                'monthly_amount' => 34500.75,
                                'is_active' => true,
                            ];
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
                            <a href="#" class="btn btn-primary btn-sm px-4">Edit Profile</a>
                            <form method="POST" action="#">
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
                                {{ number_format($pensionerDetails->basic_salary, 2) }}</p>
                            <p class="mb-0"><strong>Status:</strong>
                                <span class="badge bg-success">Active</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                @php
                    $recentPayments = collect([
                        (object) [
                            'amount' => $pensionerDetails->basic_salary,
                            'date' => '2025-09-01',
                            'description' => 'September 2025 Pension',
                            'status' => 'completed',
                        ],
                        (object) [
                            'amount' => $pensionerDetails->basic_salary,
                            'date' => '2025-08-01',
                            'description' => 'August 2025 Pension',
                            'status' => 'completed',
                        ],
                        (object) [
                            'amount' => $pensionerDetails->basic_salary,
                            'date' => '2025-07-01',
                            'description' => 'July 2025 Pension',
                            'status' => 'completed',
                        ],
                    ]);
                @endphp

                <!-- Stats Row -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body">
                                <div class="fs-4 fw-semibold mb-1">৳ {{ number_format(103500, 2) }}</div>
                                <div class="text-muted small">Total Received</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body">
                                <div class="fs-5 fw-semibold mb-1">Sep 01, 2025</div>
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
                                <strong>Date of Birth:</strong><br>12 Jan, 1958
                            </div>
                            <div class="col-md-6">
                                <strong>NID / Passport:</strong><br>1234567890123
                            </div>
                            <div class="col-md-6">
                                <strong>Contact:</strong><br>+8801712345678
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
                        @foreach ($recentPayments as $payment)
                            <div
                                class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom">
                                <div>
                                    <div class="fw-semibold text-dark">৳ {{ number_format($payment->amount, 2) }}</div>
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($payment->date)->format('d M Y') }} ·
                                        {{ $payment->description }}
                                    </div>
                                </div>
                                <span class="badge bg-light text-dark border">{{ ucfirst($payment->status) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
