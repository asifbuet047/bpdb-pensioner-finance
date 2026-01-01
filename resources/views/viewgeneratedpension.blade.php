@extends('layouts.layout')

@section('title', 'Generate pension')

@section('content')
    <section class="container-fluid py-5">
        <h1 class="mb-4 text-center fw-bold text-primary">বাংলাদেশ বিদ্যুৎ উন্নয়ন বোর্ড</h1>
        <h2 class="mb-4 text-center fw-bold text-primary">All Approved Pensioners for Generate Pension</h2>
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
                        @if (!$onlybonus)
                            <th scope="col">
                                Net pension
                            </th>
                            <th scope="col">
                                Medical Allowance
                            </th>
                            <th scope="col">
                                Special Allowance
                            </th>
                        @endif

                        @if (in_array(true, $festivalbonuses))
                            <th scope="col">Festival bonus</th>
                        @endif

                        @if ($banglanewyearbonus)
                            <th scope="col">bangla new year bonus</th>
                        @endif
                        <th scope="col">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pensioners as $index => $pensioner)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }} fw-semibold hand-pointer">
                            <td class="text-end">{{ $index + 1 }}</td>
                            <td class="text-end">{{ $pensioner->erp_id }}</td>
                            <td class="text-end">{{ $pensioner->name }}</td>
                            @if (!$onlybonus)
                                <td class="text-end">{{ number_format($pensioner->net_pension, 2) }}</td>
                                <td class="text-end">{{ number_format($pensioner->medical_allowance, 2) }}</td>
                                <td class="text-end">{{ number_format($pensioner->special_benifit, 2) }}</td>
                            @endif
                            @php
                                $isFestivalBonus = match ($pensioner->religion) {
                                    'Islam' => $festivalbonuses['muslim_bonus'] ?? false,
                                    'Hinduism' => $festivalbonuses['hindu_bonus'] ?? false,
                                    'Christianity' => $festivalbonuses['christian_bonus'] ?? false,
                                    'Buddhism' => $festivalbonuses['buddhist_bonus'] ?? false,
                                    default => false,
                                };
                            @endphp

                            @if (!$onlybonus)
                                @if ($isFestivalBonus)
                                    @if ($banglanewyearbonus)
                                        <td class="text-end">{{ number_format($pensioner->festival_bonus, 2) }}</td>
                                        <td class="text-end">{{ number_format($pensioner->bangla_new_year_bonus, 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format($pensioner->net_pension + $pensioner->medical_allowance + $pensioner->special_benifit + $pensioner->festival_bonus + $pensioner->bangla_new_year_bonus, 2) }}
                                        </td>
                                    @else
                                        <td class="text-end">{{ number_format($pensioner->festival_bonus, 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format($pensioner->net_pension + $pensioner->medical_allowance + $pensioner->special_benifit + $pensioner->festival_bonus, 2) }}
                                        </td>
                                    @endif
                                @else
                                    @if ($banglanewyearbonus)
                                        @if (in_array(true, $festivalbonuses))
                                            <td class="text-end">{{ number_format(0.0, 2) }}</td>
                                        @endif
                                        <td class="text-end">{{ number_format($pensioner->bangla_new_year_bonus, 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format($pensioner->net_pension + $pensioner->medical_allowance + $pensioner->special_benifit + $pensioner->bangla_new_year_bonus, 2) }}
                                        </td>
                                    @else
                                        @if (in_array(true, $festivalbonuses))
                                            <td class="text-end">{{ number_format(0.0, 2) }}</td>
                                        @endif
                                        <td class="text-end">
                                            {{ number_format($pensioner->net_pension + $pensioner->medical_allowance + $pensioner->special_benifit, 2) }}
                                        </td>
                                    @endif
                                @endif
                            @else
                                @if ($isFestivalBonus)
                                    @if ($banglanewyearbonus)
                                        <td class="text-end">{{ number_format($pensioner->festival_bonus, 2) }}</td>
                                        <td class="text-end">{{ number_format($pensioner->bangla_new_year_bonus, 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format($pensioner->festival_bonus + $pensioner->bangla_new_year_bonus, 2) }}
                                        </td>
                                    @else
                                        <td class="text-end">{{ number_format($pensioner->festival_bonus, 2) }}</td>
                                        <td class="text-end">{{ number_format($pensioner->festival_bonus, 2) }}
                                        </td>
                                    @endif
                                @else
                                    @if ($banglanewyearbonus)
                                        @if (in_array(true, $festivalbonuses))
                                            <td class="text-end">{{ number_format(0.0, 2) }}</td>
                                        @endif
                                        <td class="text-end">{{ number_format($pensioner->bangla_new_year_bonus, 2) }}</td>
                                        <td class="text-end">{{ number_format($pensioner->bangla_new_year_bonus, 2) }}
                                        </td>
                                    @else
                                        @if (in_array(true, $festivalbonuses))
                                            <td class="text-end">{{ number_format(0.0, 2) }}</td>
                                        @endif
                                        <td class="text-end">{{ number_format(0.0, 2) }}
                                        </td>
                                    @endif
                                @endif
                            @endif
                        </tr>
                        @if ($loop->last)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'table-light' : '' }} fw-semibold hand-pointer">
                                <td colspan="3" class="text-end">Sum</td>
                                @if (!$onlybonus)
                                    <td class="text-end">{{ number_format($sumOfNetpension, 2) }}</td>
                                    <td class="text-end">{{ number_format($sumOfMedicalAllowance, 2) }}</td>
                                    <td class="text-end">{{ number_format($sumOfSpecialAllowance, 2) }}</td>
                                @endif

                                @if (in_array(true, $festivalbonuses))
                                    <td class="text-end">{{ number_format($sumOfFestivalbonus, 2) }}</td>
                                @endif

                                @if ($banglanewyearbonus)
                                    <td class="text-end">{{ number_format($sumOfbanglaNewYearBonus, 2) }}</td>
                                @endif
                                <td class="text-end">
                                    @if (!$onlybonus)
                                        {{ number_format($sumOfNetpension + $sumOfMedicalAllowance + $sumOfSpecialAllowance + $sumOfFestivalbonus + $sumOfbanglaNewYearBonus, 2) }}
                                    @else
                                        {{ number_format($sumOfFestivalbonus + $sumOfbanglaNewYearBonus, 2) }}
                                    @endif
                                </td>

                            </tr>
                        @endif
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
        @if ($officer_role === 'initiator')
            <div id="initiator-pension-button" data-pension-data='@json($pensionData)'>
            </div>
        @endif

    </section>

@endsection
