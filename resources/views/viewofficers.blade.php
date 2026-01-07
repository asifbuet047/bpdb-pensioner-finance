@extends('layouts.layout')

@section('title', 'View All Officers')

@section('content')
    <section class="container-fluid py-5">
        <h2 class="mb-3 text-center fw-bold text-primary">All Officers</h2>
        <h5 class="mb-4 text-center text-secondary">
            Total number of Officers: {{ $officers->total() }}
        </h5>
        <div class="table-responsive shadow rounded p-3 bg-white">
            <table class="table table-hover align-middle text-center custom-border">
                <thead class="table-primary fw-bolder">
                    <tr>
                        <th>No</th>
                        <th>ERP ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Role</th>
                        <th>Office</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($officers as $index => $officer)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }} fw-semibold">
                            <td>
                                @if (method_exists($officers, 'firstItem'))
                                    {{ $officers->firstItem() + $index }}
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </td>

                            <td>{{ $officer->erp_id }}</td>
                            <td>{{ $officer->name }}</td>
                            <td>{{ $officer->designation->description_english }}</td>

                            <!-- Role -->
                            <td>
                                @switch($officer->role->role_name)
                                    @case('initiator')
                                        INITIATOR
                                    @break

                                    @case('certifier')
                                        CERTIFIER
                                    @break

                                    @case('approver')
                                        APPROVER
                                    @break

                                    @case('admin')
                                        ADMIN
                                    @break

                                    @case('super_admin')
                                        SUPER ADMIN
                                    @break
                                @endswitch
                            </td>

                            <td>{{ $officer->office->name_in_english }}</td>

                            <!-- Actions -->
                            <td>
                                <div class="d-flex justify-content-center gap-3">
                                    <i class="bi bi-trash hand-pointer officer-delete-buttons" data-bs-toggle="modal"
                                        data-bs-target="#officerDeleteActionModal" data-name="{{ $officer->name }}"
                                        data-db-id="{{ $officer->id }}"></i>

                                    <i class="bi bi-pen hand-pointer officer-update-buttons" data-bs-toggle="modal"
                                        data-bs-target="#officerUpdateActionModal" data-name="{{ $officer->name }}"
                                        data-db-id="{{ $officer->id }}"></i>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted fst-italic py-4">
                                    No Officer found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $officers->links() }}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <a class="btn btn-primary btn-lg me-2 shadow-sm" href="{{ route('add.officer.section') }}">
                    Add Officer
                </a>
                <a class="btn btn-outline-primary btn-lg me-2 shadow-sm" href="{{ route('search.officer.section') }}">
                    Search Specific Officer
                </a>
                <a class="btn btn-outline-primary btn-lg me-2 shadow-sm" href="{{ route('show.officers') }}">
                    Refresh List
                </a>
                <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('download.officers') }}">
                    Download
                </a>
            </div>
        </section>
    @endsection
