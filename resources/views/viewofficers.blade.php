@extends('layouts.layout')

@section('title', 'View All Officers')

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
                        <th scope="col" class="fw-bolder fs-4">Office</th>
                        <th scope="col"></th>
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
                            <td class="fw-semibold">{{ $officer->office->officeName }}</td>
                            <td>
                                <div class="row justify-content-center">
                                    <div class="col-6 d-flex justify-content-center">
                                        <i class="bi bi-trash hand-pointer officer-delete-buttons" data-bs-toggle="modal"
                                            data-bs-target="#officerDeleteActionModal" data-name="{{ $officer->name }}"
                                            data-index="{{ $officer->id }}"></i>
                                    </div>
                                    <div class="col-6 d-flex justify-content-center">
                                        <i class="bi bi-pen hand-pointer officer-update-buttons" data-bs-toggle="modal"
                                            data-bs-target="#officerUpdateActionModal" data-name="{{ $officer->name }}"
                                            data-index="{{ $officer->id }}"></i>
                                    </div>
                                </div>
                            </td>
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

            <!--Delete Action Modal -->
            <div class="modal fade" id="officerDeleteActionModal" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Are You sure?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Do You really want to delete <span class="fw-bold" id="officerDeleteActionModalSpan"></span>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                id="officerDeleteButton">Yes</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Not now</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--Update Action Modal -->
            <div class="modal fade" id="officerUpdateActionModal" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Are You sure?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Do You really want to update <span class="fw-bold" id="officerUpdateActionModalSpan"></span>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                id="officerUpdateButton">Yes</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Not now</button>
                        </div>
                    </div>
                </div>
            </div>
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
