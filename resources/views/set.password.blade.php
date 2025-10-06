@extends('layouts.layout')

@section('title', 'Set Password for Pensioenr')

@section('content')
    <section class="gradient-custom">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Set Passwrod for Pensioner</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('set.password.process') }}" method="POST">
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

                                    @if (session()->has('password'))
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg" value="{{ old('password') }}" disabled
                                            hidden />
                                    @else
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg" />
                                    @endif

                                </div>

                                <div class="mb-4">

                                    @if (session()->has('password'))
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control form-control-lg" value="{{ old('password') }}" disabled
                                            hidden />
                                    @else
                                        <label class="form-label" for="password_confirmation">Confirm password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control form-control-lg" />
                                    @endif


                                </div>

                                @if (session()->has('erp_id'))
                                    <div class="mb-4 row">
                                        <button class="btn btn-success"
                                            onclick="window.location='{{ route('login.page', ['type' => 'pensioner']) }}'"
                                            type="button">Password set successful. Go to Login page</button>
                                    </div>
                                @else
                                    <div class="mb-4 row">
                                        <button class="btn btn-primary" type="submit">Set Your Password</button>
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
