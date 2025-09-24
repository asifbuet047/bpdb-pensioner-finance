@extends('layouts.layout')

@section('title', 'Update Officer')

@section('content')
    <section class="gradient-custom">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Update Officer form</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('update.officer.process') }}" method="POST">
                                @csrf

                                <input type="hidden" name="id" value="{{ $officer->id }}" />

                                <div class="mb-4">
                                    <label class="form-label" for="name">Name</label>
                                    @if (session()->has('name'))
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-lg" placeholder="Your name"
                                            value="{{ session('name') }}" disabled />
                                    @else
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-lg" placeholder="Your name"
                                            value="{{ old('name') ? old('name') : $officer->name }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="erp_id">ERP ID</label>
                                    @if (session()->has('erp_id'))
                                        <input type="number" id="erp_id" name="erp_id"
                                            class="form-control form-control-lg" placeholder="Your ERP ID"
                                            value="{{ session('erp_id') }}" disabled />
                                    @else
                                        <input type="number" id="erp_id" name="erp_id"
                                            class="form-control form-control-lg" placeholder="Your ERP ID"
                                            value="{{ old('erp_id') ? old('erp_id') : $officer->erp_id }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="office">Office</label>
                                    @if (session()->has('erp_id'))
                                        <input type="text" name="office_id" class="form-control form-control-lg"
                                            placeholder="Your Office" value="{{ session('office') }}" disabled />
                                    @else
                                        <!-- This is actaully not submitted but shown -->
                                        <input type="text" id="office" name="office_name"
                                            class="form-control form-control-lg" placeholder="Your Office click to select"
                                            value="{{ old('office') ? old('office') : $officer->office->officeName }}"
                                            data-bs-toggle="modal" data-bs-target="#selectModal" readonly />

                                        <!-- This is actaully submitted but not shown -->
                                        <input type="hidden" name="office_id" id="office_id"
                                            value="{{ $officer->office->id }}" />
                                    @endif
                                </div>


                                <div class="mb-4">
                                    <h6 class="mb-2 pb-1">Designation</h6>
                                    <div class="form-check form-check-inline">
                                        @if (session()->has('designation') && session('designation') == 'AD')
                                            <input class="form-check-input" type="radio" name="designation"
                                                id="designation" value="AD" checked disabled />
                                        @else
                                            <input class="form-check-input" type="radio" name="designation"
                                                id="designation" value="AD"
                                                {{ old('designation') == 'AD' || $officer->designation === 'AD' ? 'checked' : '' }} />
                                        @endif

                                        <label class="form-check-label" for="ad">AD</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        @if (session()->has('designation') && session('designation') == 'SAD')
                                            <input class="form-check-input" type="radio" name="designation"
                                                id="designation" value="SAD" checked disabled />
                                        @else
                                            <input class="form-check-input" type="radio" name="designation"
                                                id="designation" value="SAD"
                                                {{ old('designation') == 'SAD' || $officer->designation === 'SAD' ? 'checked' : '' }} />
                                        @endif
                                        <label class="form-check-label" for="sad">SAD</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        @if (session()->has('designation') && session('designation') == 'DD')
                                            <input class="form-check-input" type="radio" name="designation"
                                                id="designation" value="DD" checked disabled />
                                        @else
                                            <input class="form-check-input" type="radio" name="designation"
                                                id="designation" value="DD"
                                                {{ old('designation') == 'DD' || $officer->designation === 'DD' ? 'checked' : '' }} />
                                        @endif
                                        <label class="form-check-label" for="dd">DD</label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="mb-2 pb-1">Role</h6>

                                    <div class="form-check form-check-inline">
                                        @if (session()->has('role') && session('role') == 'ADMIN')
                                            <input class="form-check-input" type="radio" name="role" id="role"
                                                value="ADMIN" checked disabled />
                                        @else
                                            <input class="form-check-input" type="radio" name="role" id="role"
                                                value="ADMIN"
                                                {{ old('role') == 'ADMIN' || $officer->role === 'ADMIN' ? 'checked' : '' }} />
                                        @endif
                                        <label class="form-check-label" for="admin">Admin</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        @if (session()->has('role') && session('role') == 'USER')
                                            <input class="form-check-input" type="radio" name="role" id="role"
                                                value="USER" checked disabled />
                                        @else
                                            <input class="form-check-input" type="radio" name="role" id="role"
                                                value="USER"
                                                {{ old('role') == 'USER' || $officer->role === 'USER' ? 'checked' : '' }} />
                                        @endif
                                        <label class="form-check-label" for="user">User</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        @if (session()->has('role') && session('role') == 'SUPER_ADMIN')
                                            <input class="form-check-input" type="radio" name="role" id="role"
                                                value="SUPER_ADMIN" checked disabled />
                                        @else
                                            <input class="form-check-input" type="radio" name="role" id="role"
                                                value="SUPER_ADMIN"
                                                {{ old('role') == 'SUPER_ADMIN' || $officer->role === 'SUPER_ADMIN' ? 'checked' : '' }} />
                                        @endif
                                        <label class="form-check-label" for="super_admin">Super Admin</label>
                                    </div>
                                </div>


                                @if (session()->has('name'))
                                    <div class="mb-4 row">
                                        <button class="btn btn-success"
                                            onclick="window.location='{{ route('login.page') }}'" type="button">Update
                                            successful.
                                            Go to Login page</button>
                                    </div>
                                @else
                                    <div class="mb-4 row">
                                        <button class="btn btn-primary" type="submit">UPDATE OFFICER</button>
                                    </div>
                                @endif
                            </form>

                            <!--Office selection Modal -->
                            <div class="modal fade" id="selectModal" tabindex="-1" role="dialog"
                                aria-labelledby="selectModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Select an Office</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">

                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>RAO Office Name</th>
                                                        <th>RAO Office name in Bangla</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($offices as $index => $office)
                                                        <tr class="selectable-row hand-pointer"
                                                            data-value="{{ $office->id }}"
                                                            data-name="{{ $office->officeName }}">
                                                            <td>{{ $office->id }}</td>
                                                            <td>{{ $office->officeName }}</td>
                                                            <td>{{ $office->officeNameInBangla }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
