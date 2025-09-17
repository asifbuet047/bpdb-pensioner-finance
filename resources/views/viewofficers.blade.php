@extends('layouts.layout')

@section('title', 'View ALl Officers')

@section('content')
    <section class="container-fluid py-5 vh-100" style="background-color: #CEF3ED">
        <h2 class="mb-4 text-center fw-bold text-primary">All Officers</h2>

        <div class="table-responsive shadow rounded p-2">
            <table class="table table-hover align-middle custom-border">
                <thead class="bg-gradient-primary text-white">
                    <tr>
                        <th scope="col" class="fw-bolder fs-4">No</th>
                        <th scope="col" class="fw-bolder fs-4">ERP ID</th>
                        <th scope="col" class="fw-bolder fs-4">Name</th>
                        <th scope="col" class="fw-bolder fs-4">Designation</th>
                        <th scope="col" class="fw-bolder fs-4">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($officers as $index => $officer)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }}">
                            <td class="fw-semibold">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $officer->erp_id }}</td>
                            <td class="fw-semibold">{{ $officer->name }}</td>
                            <td class="fw-semibold">{{ $officer->designation }}</td>
                            <td class="fw-semibold">{{ $officer->role }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted fst-italic">
                                No Officer found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-4">
            <a class="btn btn-primary btn-lg me-2 shadow-sm">
                Add Officer
            </a>
            <a class="btn btn-outline-primary btn-lg shadow-sm">
                Refresh List
            </a>
        </div>
    </section>
@endsection
