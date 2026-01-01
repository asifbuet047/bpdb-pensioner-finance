@extends('layouts.layout')

@section('title', 'All Pensioner')


@section('content')
    <section class="container-fluid py-5">
        <h2 class="mb-4 text-center fw-bold text-primary">All Pensions</h2>
        <h1 class="mb-4 text-center fw-bold text-primary">বাংলাদেশ বিদ্যুৎ উন্নয়ন বোর্ড</h1>
        <div class="table-responsive shadow rounded p-2">
            <table class="table table-hover align-middle custom-border">
                <thead class="bg-gradient-primary text-white fw-bolder fs-4">
                    <tr>
                        <th scope="col">
                            No
                        </th>
                        <th scope="col">
                            Month
                        </th>
                        <th scope="col">
                            Year
                        </th>
                        <th scope="col">
                            Total Net Pension amount
                        </th>
                        <th scope="col">
                            Total Medical Allowance amount
                        </th>
                        <th scope="col">
                            Total Special Allowance amount
                        </th>
                        <th scope="col">
                            Total Festival Bonus amount
                        </th>
                        <th scope="col">
                            Total Bngla New Years Bonus amount
                        </th>
                        <th scope="col">
                            Total amount
                        </th>
                        <th scope="col">
                            Status
                        </th>
                        @if (!isset($just_view))
                            <th scope="col">
                                Actions
                            </th>
                        @endif

                    </tr>
                </thead>
                <tbody>
                    @forelse ($pensions as $index => $pension)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }} fw-semibold hand-pointer">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pension->month }}</td>
                            <td>{{ $pension->year }}</td>
                            <td>{{ number_format($pension->sum_of_net_pension, 2) }}</td>
                            <td>{{ number_format($pension->sum_of_medical_allowance, 2) }}</td>
                            <td>{{ number_format($pension->sum_of_special_allowance, 2) }}</td>
                            <td>{{ number_format($pension->sum_of_festival_bonus, 2) }}</td>
                            <td>{{ number_format($pension->sum_of_bangla_new_year_bonus, 2) }}</td>
                            @php
                                $totalAmount =
                                    $pension->sum_of_net_pension +
                                    $pension->sum_of_medical_allowance +
                                    $pension->sum_of_special_allowance +
                                    $pension->sum_of_festival_bonus +
                                    $pension->sum_of_bangla_new_year_bonus;
                            @endphp
                            <td>{{ number_format($totalAmount, 2) }}
                            </td>

                            @switch($officer_role)
                                @case('initiator')
                                    @if ($pension->status === 'floated')
                                        <td>{{ 'Pending' }}</td>
                                    @endif
                                    @if ($pension->status === 'initiated')
                                        <td>{{ 'on Certifier desk' }}</td>
                                    @endif
                                    @if ($pension->status === 'certified')
                                        <td>{{ 'on Approver desk' }}</td>
                                    @endif
                                    @if ($pension->status === 'approved')
                                        <td>{{ 'Approved' }}</td>
                                    @endif
                                @break

                                @case('certifier')
                                    @if ($pension->status === 'floated')
                                        <td>{{ 'On Initiator desk' }}</td>
                                    @endif
                                    @if ($pension->status === 'initiated')
                                        <td>{{ 'Pending' }}</td>
                                    @endif
                                    @if ($pension->status === 'certified')
                                        <td>{{ 'on Approver desk' }}</td>
                                    @endif
                                    @if ($pension->status === 'approved')
                                        <td>{{ 'Approved' }}</td>
                                    @endif
                                @break

                                @case('approver')
                                    @if ($pension->status === 'floated')
                                        <td>{{ 'On Initiator desk' }}</td>
                                    @endif
                                    @if ($pension->status === 'initiated')
                                        <td>{{ 'On Certifier desk' }}</td>
                                    @endif
                                    @if ($pension->status === 'certified')
                                        <td>{{ 'Pending' }}</td>
                                    @endif
                                    @if ($pension->status === 'approved')
                                        <td>{{ 'Approved' }}</td>
                                    @endif
                                @break

                                @default
                            @endswitch
                            <td>
                                @if ($officer_role === 'initiator')
                                    <div class="d-flex justify-content-center gap-2">
                                        @if ($pension->status === 'floated')
                                            <div class="pension-delete-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'false' }}">
                                            </div>
                                            <div class="pension-forward-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'false' }}">
                                            </div>
                                            <div class="pension-workflow-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}">
                                            </div>
                                            <div class="pension-dashboard-button" data-pension-id="{{ $pension->id }}">
                                            </div>
                                        @else
                                            <div class="pension-delete-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'true' }}">
                                            </div>
                                            <div class="pension-forward-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'true' }}">
                                            </div>
                                            <div class="pension-workflow-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}">
                                            </div>
                                            <div class="pension-dashboard-button" data-pension-id="{{ $pension->id }}">
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if ($officer_role === 'certifier')
                                    <div class="d-flex justify-content-center gap-2">
                                        @if ($pension->status === 'initiated')
                                            <div class="pension-return-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'false' }}">
                                            </div>
                                            <div class="pension-forward-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'false' }}">
                                            </div>
                                            <div class="pension-workflow-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}">
                                            </div>
                                            <div class="pension-dashboard-button" data-pension-id="{{ $pension->id }}">
                                            </div>
                                        @else
                                            <div class="pension-return-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'true' }}">
                                            </div>
                                            <div class="pension-forward-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'true' }}">
                                            </div>
                                            <div class="pension-workflow-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}">
                                            </div>
                                            <div class="pension-dashboard-button" data-pension-id="{{ $pension->id }}">
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if ($officer_role === 'approver')
                                    <div class="d-flex justify-content-center gap-2">
                                        @if ($pension->status === 'certified')
                                            <div class="pension-return-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'false' }}">
                                            </div>
                                            <div class="pension-approve-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'false' }}">
                                            </div>
                                            <div class="pension-workflow-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}">
                                            </div>
                                            <div class="pension-dashboard-button" data-pension-id="{{ $pension->id }}">
                                            </div>
                                        @else
                                            <div class="pension-return-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'true' }}">
                                            </div>
                                            <div class="pension-approve-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}"
                                                data-button-status="{{ 'true' }}">
                                            </div>
                                            <div class="pension-workflow-button" data-pension-id="{{ $pension->id }}"
                                                data-total-amount="{{ $totalAmount }}">
                                            </div>
                                            <div class="pension-dashboard-button" data-pension-id="{{ $pension->id }}">
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted fst-italic">
                                    No pension is generated by Your office yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <a class="btn btn-primary btn-lg me-2 shadow-sm" href="{{ route('add.pensioner.section') }}">
                    Add Pensioner
                </a>
                <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('show.pensioner.section') }}">
                    Refresh List
                </a>
                <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('download.pensioners') }}">
                    Download
                </a>
                <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('import.pentioners.section') }}">
                    Import Pensioners
                </a>
                <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('download.template.pensioners') }}">
                    Download Excel template
                </a>
            </div>
        </section>

    @endsection
