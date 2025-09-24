@extends('layouts.layout')

@section('title', 'View ALl Offices')

@section('content')
    <section class="container-fluid py-5 vh-100">
        <h2 class="mb-4 text-center fw-bold text-primary">All Offices</h2>

        <div class="table-responsive shadow rounded p-2">
            <table class="table table-hover align-middle custom-border">
                <thead class="bg-gradient-primary text-white">
                    <tr>
                        <th scope="col" class="fw-bolder fs-4">No</th>
                        <th scope="col" class="fw-bolder fs-4">Office name</th>
                        <th scope="col" class="fw-bolder fs-4">Office name in Bangla</th>
                        <th scope="col" class="fw-bolder fs-4">Office code in ERP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($offices as $index => $office)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }}">
                            <td class="fw-semibold">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $office->officeName }}</td>
                            <td class="fw-semibold">{{ $office->officeNameInBangla }}</td>
                            <td class="fw-semibold">{{ $office->officeCode }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted fst-italic">
                                No Office found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-4">
            <a class="btn btn-primary btn-lg me-2 shadow-sm">
                Add Office
            </a>
            <a class="btn btn-outline-primary btn-lg shadow-sm">
                Refresh List
            </a>
        </div>
    </section>
@endsection
