@extends('layouts.layout')

@section('title', 'Pensioner Workflow')

@section('content')
    <section class="container-fluid py-5">
        <h2 class="mb-4 text-center fw-bold text-primary">Pension Dashboard</h2>
        <h2 class="mb-4 text-center fw-bold text-primary">Pension no: {{ $pension->id }}</h2>
        <h1 class="mb-4 text-center fw-bold text-primary">বাংলাদেশ বিদ্যুৎ উন্নয়ন বোর্ড</h1>
        <div class="table-responsive shadow rounded p-2">
            <table class="table table-hover align-middle custom-border">
                <thead class="bg-gradient-primary text-white fw-bolder fs-4">
                    <tr>
                        <th scope="col">
                            No
                        </th>
                        <th scope="col">
                            ERP ID
                        </th>
                        <th scope="col">
                            Name
                        </th>
                        <th scope="col">
                            Net pension
                        </th>
                        <th scope="col">
                            Medical Allowance
                        </th>
                        <th scope="col">
                            Special Allowance
                        </th>
                        <th scope="col">Festival bonus</th>
                        <th scope="col">bangla new year bonus</th>
                        <th scope="col">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pensionerspensions as $index => $pensionerspension)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }} fw-semibold hand-pointer">
                            <td class="text-end">{{ $index + 1 }}</td>
                            <td class="text-end">{{ $pensionerspension->pensioner->erp_id }}</td>
                            <td class="text-end">{{ $pensionerspension->pensioner->name }}</td>
                            <td class="text-end">{{ number_format($pensionerspension->net_pension, 2) }}</td>
                            <td class="text-end">{{ number_format($pensionerspension->medical_allowance, 2) }}</td>
                            <td class="text-end">{{ number_format($pensionerspension->special_allowance, 2) }}</td>
                            <td class="text-end">{{ number_format($pensionerspension->festival_bonus, 2) }}</td>
                            <td class="text-end">{{ number_format($pensionerspension->bangla_new_year_bonus, 2) }}</td>
                            <td class="text-end">
                                {{ number_format(
                                    $pensionerspension->net_pension +
                                        $pensionerspension->medical_allowance +
                                        $pensionerspension->special_allowance +
                                        $pensionerspension->festival_bonus +
                                        $pensionerspension->bangla_new_year_bonus,
                                    2,
                                ) }}
                            </td>

                        </tr>
                        @if ($loop->last)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'table-light' : '' }} fw-semibold hand-pointer">
                                <td colspan="3" class="text-end">Sum</td>
                                <td class="text-end">{{ number_format($pension->sum_of_net_pension, 2) }}</td>
                                <td class="text-end">{{ number_format($pension->sum_of_medical_allowance, 2) }}</td>
                                <td class="text-end">{{ number_format($pension->sum_of_special_allowance, 2) }}</td>
                                <td class="text-end">{{ number_format($pension->sum_of_festival_bonus, 2) }}</td>
                                <td class="text-end">{{ number_format($pension->sum_of_bangla_new_year_bonus, 2) }}</td>
                                <td class="text-end">
                                    {{ number_format(
                                        $pension->sum_of_net_pension +
                                            $pension->sum_of_medical_allowance +
                                            $pension->sum_of_special_allowance +
                                            $pension->sum_of_festival_bonus +
                                            $pension->sum_of_bangla_new_year_bonus,
                                        2,
                                    ) }}
                                </td>

                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted fst-italic">
                                No pensioners pension found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-4">

            <a class="btn btn-outline-primary btn-lg shadow-sm"
                href="{{ route('show.pension.dashboard', ['id' => $id]) }}">
                Refresh List
            </a>
            <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('download.pension', ['id' => $id]) }}">
                Download as Excel
            </a>
        </div>
    </section>

@endsection
