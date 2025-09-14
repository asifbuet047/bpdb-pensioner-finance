@extends('layouts.layout')

@section('title', 'View ALl Users')

@section('content')
    <section class="container-fluid py-5 vh-100" style="background-color: #CEF3ED">
        <h2 class="mb-4 text-center fw-bold text-primary">All Users</h2>

        <div class="table-responsive shadow rounded p-2">
            <table class="table table-hover align-middle custom-border">
                <thead class="bg-gradient-primary text-white">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">ERP ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($officers as $index => $officer)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }}">
                            <td class="fw-bold">{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $officer->erp_id }}</td>
                            <td class="fw-bold">{{ $officer->name }}</td>
                            <td class="fw-bold">{{ $officer->designation }}</td>
                            <td class="fw-bold">{{ $officer->role }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted fst-italic">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-4">
            <a class="btn btn-primary btn-lg me-2 shadow-sm">
                Add User
            </a>
            <a class="btn btn-outline-primary btn-lg shadow-sm">
                Refresh List
            </a>
        </div>
    </section>
@endsection
