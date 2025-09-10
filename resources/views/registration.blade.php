@extends('layouts.layout')

@section('title', 'Registration')

@section('content')
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #f093fb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to bottom right, rgba(240, 147, 251, 1), rgba(245, 87, 108, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to bottom right, rgba(240, 147, 251, 1), rgba(245, 87, 108, 1))
        }

        .card-registration .select-input.form-control[readonly]:not([disabled]) {
            font-size: 1rem;
            line-height: 2.15;
            padding-left: .75em;
            padding-right: .75em;
        }

        .card-registration .select-arrow {
            top: 13px;
        }
    </style>
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
                                        <input type="text" id="erp_id" name="erp_id"
                                            class="form-control form-control-lg" placeholder="Your ERP ID"
                                            value="{{ old('erp_id') }}" />
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
                                        @if (session()->has('role') && session('role') == 'USER')
                                            <input class="form-check-input" type="radio" name="role" id="role"
                                                value="USER" checked disabled />
                                        @else
                                            <input class="form-check-input" type="radio" name="role" id="role"
                                                value="USER" {{ old('role') == 'USER' ? 'checked' : '' }} />
                                        @endif
                                        <label class="form-check-label" for="user">User</label>
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
                                    <label class="form-label" for="password">Password</label>
                                    @if (session()->has('name'))
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg" value="{{ old('password') }}"
                                            disabled />
                                    @else
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg" />
                                    @endif


                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="password_confirmation">Confirm password</label>
                                    @if (session()->has('name'))
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control form-control-lg" value="{{ old('password') }}"
                                            disabled />
                                    @else
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control form-control-lg" />
                                    @endif


                                </div>

                                @if (session()->has('name'))
                                    <div class="mb-4 row">
                                        <button class="btn btn-success"
                                            onclick="window.location='{{ route('login.page') }}'">Registration successful.
                                            Go to Login page</button>
                                    </div>
                                @else
                                    <div class="mb-4 row">
                                        <input class="btn btn-primary btn-lg" type="submit" />
                                    </div>
                                @endif


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
