@extends('layouts.layout')

@section('title', 'Add Office')

@section('content')

    <section class="vh-100" style="background-color: #CEF3ED">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Add a Office</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('add.office.process') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label" for="office_name">Office Name</label>
                                    @if (session()->has('office_name'))
                                        <input type="text" id="office_name" name="office_name"
                                            class="form-control form-control-lg" placeholder="New Office name in English"
                                            value="{{ session('office_name') }}" disabled />
                                    @else
                                        <input type="text" id="office_name" name="office_name"
                                            class="form-control form-control-lg" placeholder="New Office name in English"
                                            value="{{ old('office_name') }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="office_name_bangla">অফিসের নাম</label>
                                    @if (session()->has('office_name_bangla'))
                                        <input type="text" id="office_name_bangla" name="office_name_bangla"
                                            class="form-control form-control-lg" placeholder="New Office name in Bangla"
                                            value="{{ session('office_name_bangla') }}" disabled />
                                    @else
                                        <input type="text" id="office_name_bangla" name="office_name_bangla"
                                            class="form-control form-control-lg" placeholder="New Office name in Bangla"
                                            value="{{ old('office_name_bangla') }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="office_code">Office Code</label>
                                    @if (session()->has('office_code'))
                                        <input type="number" id="office_code" name="office_code"
                                            class="form-control form-control-lg" placeholder="Office Code in ERP"
                                            value="{{ session('office_code') }}" disabled />
                                    @else
                                        <input type="number" id="office_code" name="office_code"
                                            class="form-control form-control-lg" placeholder="Office Code in ERP"
                                            value="{{ old('office_code') }}" />
                                    @endif
                                </div>

                                @if (session()->has('id'))
                                    <div class="mb-4 row">
                                        <button class="btn btn-success" type="button">Addition successful.
                                            Add another Office?</button>
                                    </div>
                                @else
                                    <div class="mb-4 row">
                                        <button class="btn btn-primary" type="submit">ADD OFFICE</button>
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
