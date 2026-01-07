@extends('layouts.layout')

@section('title', 'All Pensioner')

@section('content')
    <section class="container-fluid py-5">
        <h1 class="mb-3 text-center fw-bold text-primary">All Pensioners</h1>
        <h5 class="mb-4 text-center text-secondary">
            Total number of Pensioners: {{ $pensioners->total() }}
        </h5>

        <div class="table-responsive shadow rounded p-3 bg-white">
            <table class="table table-hover align-middle text-center custom-border">
                <thead class="table-primary fw-bolder">
                    <tr>
                        <th>No</th>
                        <th>ERP ID</th>
                        <th>Name</th>
                        <th>Office Name</th>
                        <th>Basic Salary</th>
                        <th>Medical Allowance</th>
                        <th>Status</th>
                        @if (!isset($just_view))
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pensioners as $index => $pensioner)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }} fw-semibold">

                            <!-- Serial number with pagination -->
                            <td>{{ $pensioners->firstItem() + $index }}</td>

                            <td>{{ $pensioner->erp_id }}</td>
                            <td>{{ $pensioner->name }}</td>
                            <td>{{ $pensioner->office_name }}</td>
                            <td>{{ number_format($pensioner->last_basic_salary, 2) }}</td>
                            <td>{{ number_format($pensioner->medical_allowance, 2) }}</td>

                            <!-- Status -->
                            <td>
                                @switch($officer_role)
                                    @case('initiator')
                                        {{ $pensioner->status === 'floated'
                                            ? 'Pending'
                                            : ($pensioner->status === 'initiated'
                                                ? 'On Certifier Desk'
                                                : ($pensioner->status === 'certified'
                                                    ? 'On Approver Desk'
                                                    : ($pensioner->status === 'approved'
                                                        ? 'Approved'
                                                        : ''))) }}
                                    @break

                                    @case('certifier')
                                        {{ $pensioner->status === 'floated'
                                            ? 'On Initiator Desk'
                                            : ($pensioner->status === 'initiated'
                                                ? 'Pending'
                                                : ($pensioner->status === 'certified'
                                                    ? 'On Approver Desk'
                                                    : ($pensioner->status === 'approved'
                                                        ? 'Approved'
                                                        : ''))) }}
                                    @break

                                    @case('approver')
                                        {{ $pensioner->status === 'floated'
                                            ? 'On Initiator Desk'
                                            : ($pensioner->status === 'initiated'
                                                ? 'On Certifier Desk'
                                                : ($pensioner->status === 'certified'
                                                    ? 'Pending'
                                                    : ($pensioner->status === 'approved'
                                                        ? 'Approved'
                                                        : ''))) }}
                                    @break
                                @endswitch
                            </td>

                            <!-- Actions -->
                            @if (!isset($just_view))
                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        @if ($officer_role === 'initiator')
                                            @if ($action_buttons)
                                                <div class="pensioner-delete-button" data-pensioner-id="{{ $pensioner->id }}"
                                                    data-pensioner-name="{{ $pensioner->name }}"
                                                    data-button-status="{{ $pensioner->status !== 'floated' ? 'true' : 'false' }}">
                                                </div>
                                                <div class="pensioner-update-button"
                                                    data-pensioner-id="{{ $pensioner->id }}"
                                                    data-pensioner-name="{{ $pensioner->name }}"
                                                    data-button-status="{{ $pensioner->status !== 'floated' ? 'true' : 'false' }}">
                                                </div>
                                            @endif

                                            <div class="pensioner-forward-button" data-pensioner-id="{{ $pensioner->id }}"
                                                data-pensioner-name="{{ $pensioner->name }}"
                                                data-button-status="{{ $pensioner->status !== 'floated' ? 'true' : 'false' }}">
                                            </div>

                                            <div class="pensioner-workflow-button" data-pensioner-id="{{ $pensioner->id }}"
                                                data-pensioner-name="{{ $pensioner->name }}">
                                            </div>
                                        @endif

                                        @if ($officer_role === 'certifier')
                                            @if ($action_buttons)
                                                <div class="pensioner-return-button"
                                                    data-pensioner-id="{{ $pensioner->id }}"
                                                    data-pensioner-name="{{ $pensioner->name }}"
                                                    data-button-status="{{ $pensioner->status !== 'initiated' ? 'true' : 'false' }}">
                                                </div>
                                                <div class="pensioner-forward-button"
                                                    data-pensioner-id="{{ $pensioner->id }}"
                                                    data-pensioner-name="{{ $pensioner->name }}"
                                                    data-button-status="{{ $pensioner->status !== 'initiated' ? 'true' : 'false' }}">
                                                </div>
                                            @endif

                                            <div class="pensioner-workflow-button" data-pensioner-id="{{ $pensioner->id }}"
                                                data-pensioner-name="{{ $pensioner->name }}">
                                            </div>
                                        @endif

                                        @if ($officer_role === 'approver')
                                            @if ($action_buttons)
                                                <div class="pensioner-return-button"
                                                    data-pensioner-id="{{ $pensioner->id }}"
                                                    data-pensioner-name="{{ $pensioner->name }}"
                                                    data-button-status="{{ $pensioner->status !== 'certified' ? 'true' : 'false' }}">
                                                </div>
                                                <div class="pensioner-approve-button"
                                                    data-pensioner-id="{{ $pensioner->id }}"
                                                    data-pensioner-name="{{ $pensioner->name }}"
                                                    data-button-status="{{ $pensioner->status !== 'certified' ? 'true' : 'false' }}">
                                                </div>
                                            @endif

                                            <div class="pensioner-workflow-button" data-pensioner-id="{{ $pensioner->id }}"
                                                data-pensioner-name="{{ $pensioner->name }}">
                                            </div>
                                        @endif

                                    </div>
                                </td>
                            @endif
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted fst-italic py-4">
                                    No pensioners found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $pensioners->links() }}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <a class="btn btn-primary btn-lg me-2 shadow-sm" href="{{ route('add.pensioner.section') }}">
                    Add Pensioner
                </a>
                <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('show.pensioner.section') }}">
                    Refresh List
                </a>
                <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('download.pensioners') }}">
                    Download
                </a>
                <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('import.pentioners.section') }}">
                    Import Pensioners
                </a>
                <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('download.template.pensioners') }}">
                    Download Excel Template
                </a>
                @if ($pensioners->count() > 0)
                    <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('show.invoice.bank') }}">
                        Generate Invoice
                    </a>
                @endif
            </div>

        </section>
    @endsection
