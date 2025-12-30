@extends('layouts.layout')

@section('title', 'Generate pension')


@section('content')
    <section class="container-fluid py-5">
        <h2 class="mb-4 text-center fw-bold text-primary">All Approved Pensioners for Generate Pension</h2>
        <h1 class="mb-4 text-center fw-bold text-primary">বাংলাদেশ বিদ্যুৎ উন্নয়ন বোর্ড</h1>
        <div class="table-responsive shadow rounded p-2">
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="alert alert-info text-center shadow-sm fw-semibold">
                        <i class="bi bi-calendar-event me-2"></i>
                        Pension Generation Period :
                        <span class="fw-bold text-primary">
                            {{ $month }}
                            {{ $year }}
                        </span>
                    </div>
                </div>
            </div>
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
                            Special benifit
                        </th>
                        @if ($bonuses['muslim_bonus'] || $bonuses['hindu_bonus'] || $bonuses['christian_bonus'] || $bonuses['buddhist_bonus'])
                            <th scope="col">Festival bonus</th>
                        @endif

                        @if ($bonuses['bangla_new_year_bonus'])
                            <th scope="col">bangla new year bonus</th>
                        @endif
                        <th scope="col">
                            Total
                        </th>
                        <th scope="col">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pensioners as $index => $pensioner)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }} fw-semibold hand-pointer">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pensioner->erp_id }}</td>
                            <td>{{ $pensioner->name }}</td>
                            <td>{{ number_format($pensioner->net_pension, 2) }}</td>
                            <td>{{ number_format($pensioner->medical_allowance, 2) }}</td>
                            <td>{{ number_format($pensioner->special_benifit, 2) }}</td>

                            @php
                                $isFestivalBonus = match ($pensioner->religion) {
                                    'Islam' => $bonuses['muslim_bonus'] ?? false,
                                    'Hinduism' => $bonuses['hindu_bonus'] ?? false,
                                    'Christianity' => $bonuses['christian_bonus'] ?? false,
                                    'Buddhism' => $bonuses['buddhist_bonus'] ?? false,
                                    default => false,
                                };
                            @endphp

                            @if ($isFestivalBonus)
                                <td>{{ number_format($pensioner->festival_bonus, 2) }}</td>
                            @else
                                <td>{{ number_format(0.0, 2) }}</td>
                            @endif

                            @if ($bonuses['bangla_new_year_bonus'])
                                <td>{{ number_format($pensioner->bangla_new_year_bonus, 2) }}</td>
                            @endif

                            @if ($bonuses['muslim_bonus'] || $bonuses['hindu_bonus'] || $bonuses['christian_bonus'] || $bonuses['buddhist_bonus'])
                                @if ($bonuses['bangla_new_year_bonus'])
                                    <td>{{ number_format($pensioner->net_pension + $pensioner->medical_allowance + $pensioner->special_benifit + $pensioner->festival_bonus + $pensioner->bangla_new_year_bonus, 2) }}
                                    </td>
                                @else
                                    <td>{{ number_format($pensioner->net_pension + $pensioner->medical_allowance + $pensioner->special_benifit + $pensioner->festival_bonus, 2) }}
                                    </td>
                                @endif
                            @else
                                @if ($bonuses['bangla_new_year_bonus'])
                                    <td>{{ number_format($pensioner->net_pension + $pensioner->medical_allowance + $pensioner->special_benifit + $pensioner->bangla_new_year_bonus, 2) }}
                                    </td>
                                @else
                                    <td>{{ number_format($pensioner->net_pension + $pensioner->medical_allowance + $pensioner->special_benifit, 2) }}
                                    </td>
                                @endif
                            @endif


                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <div class="pensioner-block-checkbox">
                                    </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted fst-italic">
                                No pensioners found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-4">
            <a class="btn btn-primary btn-lg me-2 shadow-sm" href="{{ route('add.pensioner.section') }}">
                Generate Pension
            </a>
            <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('show.pensioner.section') }}">
                Refresh List
            </a>
        </div>
    </section>

@endsection
