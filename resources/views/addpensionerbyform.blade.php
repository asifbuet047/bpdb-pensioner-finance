@extends('layouts.layout')

@section('title', 'Add Pensioner by filling form')

@section('content')

    <section>
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Add a Pensioner</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('add.pensioner.process') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label" for="erp_id">ERP ID</label>
                                    @if (session()->has('erp_id'))
                                        <input type="number" id="erp_id" name="erp_id"
                                            class="form-control form-control-lg" placeholder="Pensioner ERP ID"
                                            value="{{ session('erp_id') }}" disabled />
                                    @else
                                        <input type="number" id="erp_id" name="erp_id"
                                            class="form-control form-control-lg" placeholder="Pensioner ERP ID"
                                            value="{{ old('erp_id') }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="name">Pensioner name</label>
                                    @if (session()->has('name'))
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-lg" placeholder="Pensioner name"
                                            value="{{ session('name') }}" disabled />
                                    @else
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-lg" placeholder="Pensioner name"
                                            value="{{ old('name') }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="register_no">Pensioner Designation</label>
                                    @if (session()->has('register_no'))
                                        <input type="text" id="designation" name="designation"
                                            class="form-control form-control-lg" placeholder="Designation"
                                            value="{{ session('designation') }}" disabled />
                                    @else
                                        <input type="text" id="designation" name="designation"
                                            class="form-control form-control-lg" placeholder="Designation"
                                            value="{{ old('designation') }}" />
                                    @endif
                                </div>

                                
                                <div class="mb-4">
                                    <label class="form-label" for="register_no">Pensioner register no</label>
                                    @if (session()->has('register_no'))
                                        <input type="text" id="register_no" name="register_no"
                                            class="form-control form-control-lg" placeholder="Register no"
                                            value="{{ session('register_no') }}" disabled />
                                    @else
                                        <input type="text" id="register_no" name="register_no"
                                            class="form-control form-control-lg" placeholder="Register no"
                                            value="{{ old('register_no') }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="basic_salary">Pensioner basic salary</label>
                                    @if (session()->has('basic_salary'))
                                        <input type="number" id="basic_salary" name="basic_salary"
                                            class="form-control form-control-lg" placeholder="Basic salary"
                                            value="{{ session('basic_salary') }}" disabled />
                                    @else
                                        <input type="number" id="basic_salary" name="basic_salary"
                                            class="form-control form-control-lg" placeholder="Basic salary"
                                            value="{{ old('basic_salary') }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="medical_allowance">Pensioner medical allowance</label>
                                    @if (session()->has('medical_allowance'))
                                        <input type="number" id="medical_allowance" name="medical_allowance"
                                            class="form-control form-control-lg" placeholder="Medical allowance"
                                            value="{{ session('medical_allowance') }}" disabled />
                                    @else
                                        <input type="number" id="medical_allowance" name="medical_allowance"
                                            class="form-control form-control-lg" placeholder="Medical allowance"
                                            value="{{ old('medical_allowance') }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="incentive_bonus">Pensioner incentive bonus</label>
                                    @if (session()->has('incentive_bonus'))
                                        <input type="number" id="incentive_bonus" name="incentive_bonus"
                                            class="form-control form-control-lg" placeholder="Incentive bonus"
                                            value="{{ session('incentive_bonus') }}" disabled />
                                    @else
                                        <input type="number" id="incentive_bonus" name="incentive_bonus"
                                            class="form-control form-control-lg" placeholder="Incentive bonus"
                                            value="{{ old('incentive_bonus') }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="bank_name">Pensioner bank name</label>
                                    @if (session()->has('bank_name'))
                                        <input type="text" id="bank_name" name="bank_name"
                                            class="form-control form-control-lg" placeholder="Bank name"
                                            value="{{ session('bank_name') }}" disabled />
                                    @else
                                        <input type="text" id="bank_name" name="bank_name"
                                            class="form-control form-control-lg" placeholder="Bank name"
                                            value="{{ old('bank_name') }}" />
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="account_number">Pensioner bank account no</label>
                                    @if (session()->has('account_number'))
                                        <input type="text" id="account_number" name="account_number"
                                            class="form-control form-control-lg" placeholder="account no"
                                            value="{{ session('account_number') }}" disabled />
                                    @else
                                        <input type="text" id="account_number" name="account_number"
                                            class="form-control form-control-lg" placeholder="account no"
                                            value="{{ old('account_number') }}" />
                                    @endif
                                </div>


                                <div class="mb-4">
                                    <label class="form-label" for="office">Office</label>
                                    @if (session()->has('office'))
                                        <input type="text" name="office_id" class="form-control form-control-lg"
                                            placeholder="Your Office" value="{{ session('office') }}" disabled />
                                    @else
                                        <input type="text" id="office" name="office_name"
                                            class="form-control form-control-lg" placeholder="Your Office click to select"
                                            value="{{ old('office') }}" data-bs-toggle="modal"
                                            data-bs-target="#selectModal" readonly />

                                        <input type="hidden" name="office_id" id="office_id" value="" />
                                    @endif
                                </div>


                                @if (session()->has('id'))
                                    <div class="mb-4 row">
                                        <button class="btn btn-success" type="button">Addition successful. Add another
                                            Pensioner?</button>
                                    </div>
                                @else
                                    <div class="mb-4 row">
                                        <button class="btn btn-success" type="submit">ADD PENSIONER</button>
                                    </div>

                                    <div class="mb-4 row">
                                        <a class="btn btn-outline-primary btn-lg shadow-sm"
                                            href="{{ route('import.pentioners.section') }}">
                                            Import Pensioners
                                        </a>
                                    </div>
                                @endif

                            </form>


                            <!--Office selection Modal -->
                            <div class="modal fade" id="selectModal" tabindex="-1" role="dialog"
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