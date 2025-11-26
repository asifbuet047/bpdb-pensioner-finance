@extends('layouts.layout')

@section('title', 'Registration as Payment Officer')

@section('content')
    <section class="gradient-custom">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Registration
                                Form as Payment Officer</h3>

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

                                    @if (session()->has('name'))
                                        <label class="form-label" for="name">Name</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-lg" value="{{ session('name') }}" disabled />
                                    @endif
                                </div>


                                <div class="mb-4">

                                    @if (session()->has('office'))
                                        <label class="form-label" for="office">Office</label>
                                        <input type="text" name="office" class="form-control form-control-lg"
                                            value="{{ session('office') }}" disabled />
                                    @endif
                                </div>


                                <div class="mb-4">
                                    @if (session()->has('designation'))
                                        <label class="form-label" for="designation">Designation</label>
                                        <input type="text" name="designation" class="form-control form-control-lg"
                                            value="{{ session('designation') }}" disabled />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    @if (session()->has('role'))
                                        <label class="form-label" for="role">Role</label>
                                        <input type="text" name="role" class="form-control form-control-lg"
                                            value="{{ session('role') }}" disabled />
                                    @endif
                                </div>

                                <div class="mb-4">

                                    @if (session()->has('name'))
                                        <label class="form-label" for="password">Password</label>
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

                                    @if (!session()->has('name'))
                                        <label class="form-label" for="password_confirmation">Confirm password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control form-control-lg" placeholder="Retype your password" />
                                    @endif

                                </div>

                                @if (session()->has('name'))
                                    <div class="mb-4 row">
                                        <button class="btn btn-success"
                                            onclick="window.location='{{ route('login.page', ['type' => 'officer', 'designation' => session('designation'), 'role' => session('role')]) }}'"
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
