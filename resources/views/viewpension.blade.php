@extends('layouts.layout')

@section('title', 'All Pensioner')

@php
    $months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ];
@endphp

@section('content')
    <section class="container-fluid py-5">

        <h1 class="mb-3 text-center fw-bold text-primary">All Pensions</h1>
        <h5 class="mb-4 text-center text-secondary">
            Total number of Pension: {{ $pensions->total() }}
        </h5>

        <div class="table-responsive shadow rounded p-3 bg-white">
            <table class="table table-hover align-middle text-center custom-border">
                <thead class="table-primary fw-bolder">
                    <tr>
                        <th>No</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Total Net Pension</th>
                        <th>Total Medical Allowance</th>
                        <th>Total Special Allowance</th>
                        <th>Total Festival Bonus</th>
                        <th>Total Bangla New Year Bonus</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        @if (!isset($just_view))
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pensions as $index => $pension)
                        @php
                            $totalAmount =
                                $pension->sum_of_net_pension +
                                $pension->sum_of_medical_allowance +
                                $pension->sum_of_special_allowance +
                                $pension->sum_of_festival_bonus +
                                $pension->sum_of_bangla_new_year_bonus;
                        @endphp

                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }} fw-semibold">
                            <!-- Serial with pagination -->
                            <td>{{ $pensions->firstItem() + $index }}</td>

                            <td>{{ $months[$pension->month] }}</td>
                            <td>{{ $pension->year }}</td>
                            <td>{{ number_format($pension->sum_of_net_pension, 2) }}</td>
                            <td>{{ number_format($pension->sum_of_medical_allowance, 2) }}</td>
                            <td>{{ number_format($pension->sum_of_special_allowance, 2) }}</td>
                            <td>{{ number_format($pension->sum_of_festival_bonus, 2) }}</td>
                            <td>{{ number_format($pension->sum_of_bangla_new_year_bonus, 2) }}</td>
                            <td>{{ number_format($totalAmount, 2) }}</td>

                            <!-- Status -->
                            <td>
                                @switch($officer_role)
                                    @case('initiator')
                                        {{ $pension->status === 'floated'
                                            ? 'Pending'
                                            : ($pension->status === 'initiated'
                                                ? 'On Certifier Desk'
                                                : ($pension->status === 'certified'
                                                    ? 'On Approver Desk'
                                                    : ($pension->status === 'approved'
                                                        ? 'Approved'
                                                        : ''))) }}
                                    @break

                                    @case('certifier')
                                        {{ $pension->status === 'floated'
                                            ? 'On Initiator Desk'
                                            : ($pension->status === 'initiated'
                                                ? 'Pending'
                                                : ($pension->status === 'certified'
                                                    ? 'On Approver Desk'
                                                    : ($pension->status === 'approved'
                                                        ? 'Approved'
                                                        : ''))) }}
                                    @break

                                    @case('approver')
                                        {{ $pension->status === 'floated'
                                            ? 'On Initiator Desk'
                                            : ($pension->status === 'initiated'
                                                ? 'On Certifier Desk'
                                                : ($pension->status === 'certified'
                                                    ? 'Pending'
                                                    : ($pension->status === 'approved'
                                                        ? 'Approved'
                                                        : ''))) }}
                                    @break
                                @endswitch
                            </td>

                            <!-- Actions -->
                            @if (!isset($just_view))
                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        @if ($officer_role === 'initiator')
                                            @if ($action_buttons)
                                                <div class="pension-delete-button" data-pension-id="{{ $pension->id }}"
                                                    data-total-amount="{{ $totalAmount }}"
                                                    data-button-status="{{ $pension->status !== 'floated' ? 'true' : 'false' }}">
                                                </div>
                                                <div class="pension-forward-button" data-pension-id="{{ $pension->id }}"
                                                    data-total-amount="{{ $totalAmount }}"
                                                    data-button-status="{{ $pension->status !== 'floated' ? 'true' : 'false' }}">
                                                </div>
                                            @endif
                                        @endif

                                        @if ($officer_role === 'certifier' || $officer_role === 'approver')
                                            @if ($action_buttons)
                                                <div class="pension-return-button" data-pension-id="{{ $pension->id }}"
                                                    data-total-amount="{{ $totalAmount }}"
                                                    data-button-status="{{ in_array($pension->status, ['initiated', 'certified']) ? 'false' : 'true' }}">
                                                </div>
                                            @endif
                                        @endif

                                        <div class="pension-workflow-button" data-pension-id="{{ $pension->id }}"
                                            data-total-amount="{{ $totalAmount }}">
                                        </div>

                                        <div class="pension-dashboard-button" data-pension-id="{{ $pension->id }}">
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted fst-italic py-4">
                                    No pension is generated by your office yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $pensions->links() }}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <a class="btn btn-primary btn-lg me-2 shadow-sm" href="{{ route('show.generate.pension.section') }}">
                    Generate Pension
                </a>
                <a class="btn btn-outline-primary btn-lg shadow-sm"
                    href="{{ route('show.all.generated.pensions', ['type' => 'approved']) }}">
                    Refresh List
                </a>
            </div>

        </section>
    @endsection
