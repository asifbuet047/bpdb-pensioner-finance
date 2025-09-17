@extends('layouts.layout')

@section('title', 'All Pensioner')

@section('content')
    <section class="container-fluid py-5 vh-100" style="background-color: #CEF3ED">
        <h2 class="mb-4 text-center fw-bold text-primary">All Pensioners</h2>

        <div class="table-responsive shadow rounded p-2">
            <table class="table table-hover align-middle custom-border">
                <thead class="bg-gradient-primary text-white fw-bolder fs-4">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">ERP ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Register No</th>
                        <th scope="col">Basic Salary</th>
                        <th scope="col">Medical Allowance</th>
                        <th scope="col">Incentive Bonus</th>
                        <th scope="col">Bank Name</th>
                        <th scope="col">Account Number</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pensioners as $index => $pensioner)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }} fw-semibold hand-pointer">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pensioner->erp_id }}</td>
                            <td>{{ $pensioner->name }}</td>
                            <td>{{ $pensioner->register_no }}</td>
                            <td>{{ number_format($pensioner->basic_salary, 2) }}</td>
                            <td>{{ number_format($pensioner->medical_allowance, 2) }}</td>
                            <td>{{ number_format($pensioner->incentive_bonus, 2) }}</td>
                            <td>{{ $pensioner->bank_name }}</td>
                            <td>{{ $pensioner->account_number }}</td>
                            <td>
                                <div class="row">
                                    <i class="bi bi-trash col-6"></i>
                                    <i class="bi bi-pen col-6"></i>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted fst-italic">
                                No pensioners found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-4">
            <a class="btn btn-primary btn-lg me-2 shadow-sm">
                Add Pensioner
            </a>
            <a class="btn btn-outline-primary btn-lg shadow-sm">
                Refresh List
            </a>
        </div>
    </section>

@endsection
