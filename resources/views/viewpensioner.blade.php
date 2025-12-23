@extends('layouts.layout')

@section('title', 'All Pensioner')

@section('content')
    <section class="container-fluid py-5">
        <h2 class="mb-4 text-center fw-bold text-primary">All {{ $pensioners_type }} Pensioners</h2>
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
                            Office name
                        </th>
                        <th scope="col">
                            Basic Salary
                        </th>
                        <th scope="col">
                            Medical Allowance
                        </th>
                        <th scope="col">
                            Status
                        </th>
                        <th scope="col">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pensioners as $index => $pensioner)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }} fw-semibold hand-pointer">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pensioner->erp_id }}</td>
                            <td>{{ $pensioner->name }}</td>
                            <td>{{ $pensioner->office_name }}</td>
                            <td>{{ number_format($pensioner->last_basic_salary, 2) }}</td>
                            <td>{{ number_format($pensioner->medical_allowance, 2) }}</td>
                            @switch($pensioner->status)
                                @case('floated')
                                    <td>{{ 'Pending' }}</td>
                                @break

                                @case('initiated')
                                    <td>{{ 'Pending' }}</td>
                                @break

                                @case('certified')
                                    <td>{{ 'Pending' }}</td>
                                @break

                                @case('approved')
                                    <td>{{ 'Approved' }}</td>
                                @break

                                @default
                            @endswitch
                            <td>
                                {{-- <div class="row">
                                    <i class="bi bi-trash col-6 pensioner-delete-buttons" data-bs-toggle="modal"
                                        data-bs-target="#pensionerDeleteActionModal" data-name="{{ $pensioner->name }}"
                                        data-index="{{ $pensioner->id }}"></i>
                                    <i class="bi bi-pen col-6 pensioner-update-buttons" data-bs-toggle="modal"
                                        data-bs-target="#pensionerUpdateActionModal" data-name="{{ $pensioner->name }}"
                                        data-index="{{ $pensioner->id }}"></i>
                                </div> --}}

                                @if ($officer_role === 'initiator')
                                    @if ($pensioners_type === 'floated')
                                        <div class="d-flex justify-content-center gap-2">
                                            <div class="pensioner-delete-button" data-pensioner-id="{{ $pensioner->id }}">
                                            </div>
                                            <div class="pensioner-update-button" data-pensioner-id="{{ $pensioner->id }}">
                                            </div>
                                            <div class="pensioner-forward-button" data-pensioner-id="{{ $pensioner->id }}">
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if ($officer_role === 'certifier')
                                    @if ($pensioners_type === 'initiated')
                                        <div
                                            class="d-flex
                                                justify-content-center gap-2">
                                            <div id="pensioner-return-button"></div>
                                            <div id="pensioner-forward-button"></div>
                                        </div>
                                    @endif
                                @endif
                                @if ($officer_role === 'approver')
                                    @if ($pensioners_type === 'certified')
                                        <div class="d-flex justify-content-center gap-2">
                                            <div id="pensioner-return-button"></div>
                                            <div id="pensioner-approve-button"></div>
                                        </div>
                                    @endif
                                @endif
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

                <!--Delete Action Modal -->
                <div class="modal fade" id="pensionerDeleteActionModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Are You sure?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Do You really want to delete <span class="fw-bold" id="pensionerDeleteActionModalSpan"></span>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                    id="pensionerDeleteButton">Yes</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Not now</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Update Action Modal -->
                <div class="modal fade" id="pensionerUpdateActionModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Are You sure?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Do You really want to update <span class="fw-bold" id="pensionerUpdateActionModalSpan"></span>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                    id="pensionerUpdateButton">Yes</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Not now</button>
                            </div>
                        </div>
                    </div>
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
                    Download Excel template
                </a>
                @if (count($pensioners) > 0)
                    <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('show.invoice.bank') }}">
                        Generate Invoice
                    </a>
                @endif
            </div>
        </section>

    @endsection
