@extends('layouts.layout')


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
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Registration
                                Form as Officer</h3>
                            <form action="{{ route('registration.process') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name"
                                        class="form-control form-control-lg" />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="erp_id">ERP ID</label>
                                    <input type="number" id="erp_id" name="erp_id"
                                        class="form-control form-control-lg" />
                                </div>
                                <div class="mb-4">
                                    <h6 class="mb-2 pb-1">Designation</h6>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="designation" id="ad"
                                            value="AD" checked />
                                        <label class="form-check-label" for="ad">AD</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="designation" id="sad"
                                            value="SAD" />
                                        <label class="form-check-label" for="sad">SAD</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="designation" id="dd"
                                            value="DD" />
                                        <label class="form-check-label" for="dd">DD</label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="mb-2 pb-1">Role</h6>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="admin"
                                            value="ADMIN" checked />
                                        <label class="form-check-label" for="admin">Admin</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="user"
                                            value="USER" />
                                        <label class="form-check-label" for="user">User</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="designation" id="super_admin"
                                            value="SUPER_ADMIN" />
                                        <label class="form-check-label" for="super_admin">Super Admin</label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg" />
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="password_confirmation">Confirm password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control form-control-lg" />
                                </div>


                                <div class="mb-4 row">
                                    <input class="btn btn-primary btn-lg" type="submit" />
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
