@extends('layouts.layout')

@section('title', 'View All Offices')

@section('content')
    <section class="container-fluid py-5">

        <h1 class="mb-3 text-center fw-bold text-primary">All Offices</h1>
        <h5 class="mb-4 text-center text-secondary">
            Total number of Offices: {{ $offices->total() }}
        </h5>

        <div class="table-responsive shadow rounded p-3 bg-white">
            <table class="table table-hover align-middle text-center custom-border">
                <thead class="table-primary">
                    <tr>
                        <th scope="col" class="fw-bolder">No</th>
                        <th scope="col" class="fw-bolder">Office Name</th>
                        <th scope="col" class="fw-bolder">Office Name (Bangla)</th>
                        <th scope="col" class="fw-bolder">Office Code (ERP)</th>
                        <th scope="col" class="fw-bolder">Office Address</th>
                        <th scope="col" class="fw-bolder">Contact No</th>
                        <th scope="col" class="fw-bolder">Email</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($offices as $index => $office)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }}">
                            <td class="fw-semibold">
                                {{ $offices->firstItem() + $index }}
                            </td>
                            <td class="fw-semibold">{{ $office->name_in_english }}</td>
                            <td class="fw-semibold">{{ $office->name_in_bangla }}</td>
                            <td class="fw-semibold">{{ $office->office_code }}</td>
                            <td class="fw-semibold">{{ $office->address }}</td>
                            <td class="fw-semibold">{{ $office->mobile_no }}</td>
                            <td class="fw-semibold">{{ $office->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted fst-italic py-4">
                                No Office found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $offices->links() }}
            </div>
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
