@extends('layouts.layout')

@section('title', 'Registration')

@section('content')
    <section class="gradient-custom">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Registration
                                Form as Officer</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('registration.process') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label" for="name">Name</label>
                                    @if (session()->has('name'))
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-lg" placeholder="Your name"
                                            value="{{ session('name') }}" disabled />
                                    @else
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-lg" placeholder="Your name"
                                            value="{{ old('name') }}" />
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
                                            value="{{ old('erp_id') }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="office">Office</label>
                                    @if (session()->has('office'))
                                        <input type="text" name="office_id" class="form-control form-control-lg"
                                            placeholder="Your Office" value="{{ session('office') }}" disabled />
                                    @else
                                        <div class="autocomplete-wrapper">
                                            <input id="officeSearch" class="form-control form-control-lg"
                                                placeholder="Start typing office name..." autocomplete="off" />
                                            <ul id="autocompleteList" class="list-group autocomplete-list"></ul>
                                            <input type="hidden" name="office_id" id="office_id" value="" />
                                        </div>
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
                                                {{ old('designation') == 'AD' ? 'checked' : '' }} />
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
                                                {{ old('designation') == 'SAD' ? 'checked' : '' }} />
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
                                                {{ old('designation') == 'DD' ? 'checked' : '' }} />
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
                                                value="ADMIN" {{ old('role') == 'ADMIN' ? 'checked' : '' }} />
                                        @endif
                                        <label class="form-check-label" for="admin">Admin</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        @if (session()->has('role') && session('role') == 'SUPER_ADMIN')
                                            <input class="form-check-input" type="radio" name="role" id="role"
                                                value="SUPER_ADMIN" checked disabled />
                                        @else
                                            <input class="form-check-input" type="radio" name="role" id="role"
                                                value="SUPER_ADMIN" {{ old('role') == 'SUPER_ADMIN' ? 'checked' : '' }} />
                                        @endif
                                        <label class="form-check-label" for="super_admin">Super Admin</label>
                                    </div>
                                </div>

                                <div class="mb-4">

                                    @if (session()->has('name'))
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg" value="{{ old('password') }}" disabled
                                            hidden />
                                    @else
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg" placeholder="Your login password" />
                                    @endif

                                </div>

                                <div class="mb-4">

                                    @if (session()->has('name'))
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control form-control-lg" value="{{ old('password') }}" disabled
                                            hidden />
                                    @else
                                        <label class="form-label" for="password_confirmation">Confirm password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control form-control-lg" placeholder="Retype your password" />
                                    @endif


                                </div>

                                @if (session()->has('name'))
                                    <div class="mb-4 row">
                                        <button class="btn btn-success"
                                            onclick="window.location='{{ route('login.page', ['type' => 'officer']) }}'"
                                            type="button">Registration successful.
                                            Go to Login page</button>
                                    </div>
                                @else
                                    <div class="mb-4 row">
                                        <button class="btn btn-primary" type="submit">ADD OFFICER</button>
                                    </div>
                                @endif

                                @if (session()->has('name'))
                                    <div class="mb-4 row" hidden>
                                        <button class="btn btn-success"
                                            onclick="window.location='{{ route('login.page', ['type' => 'officer']) }}'"
                                            type="button">Already
                                            have an account?
                                            Login here</button>
                                    </div>
                                @else
                                    <div class="mb-4 row">
                                        <button class="btn btn-success"
                                            onclick="window.location='{{ route('login.page', ['type' => 'officer']) }}'"
                                            type="button">Already
                                            have an account?
                                            Login here</button>
                                    </div>
                                @endif
                            </form>

                            <!--Office selection Modal -->
                            {{-- <div class="modal fade" id="selectModal" tabindex="-1" role="dialog"
                                aria-labelledby="selectModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Select an Item</h5>
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
                                                        <tr class="selectable-row" data-value="{{ $office->id }}"
                                                            data-name="{{ $office->name_in_english }}">
                                                            <td>{{ $office->id }}</td>
                                                            <td>{{ $office->name_in_english }}</td>
                                                            <td>{{ $office->name_in_bangla }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
