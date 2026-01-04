@extends('layouts.layout')

@section('title', 'Pension Pension Apply Form')

@section('content')
    <section class="p-5 m-5">
        <div class="container">
            <form method="POST" action="{{ route('home.page') }}">
                @csrf

                {{-- Hidden month/year for backend --}}
                <input type="hidden" name="month" value="{{ now()->format('m') }}">
                <input type="hidden" name="year" value="{{ now()->format('Y') }}">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body px-4 px-md-5 py-4">

                        {{-- ===== Header ===== --}}
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-uppercase mb-1 text-primary">
                                Bangladesh Power Development Board
                            </h2>
                            <h6 class="fw-bold text-uppercase text-decoration-underline">
                                Pension Allowance Bill Form
                            </h6>
                            {{-- ===== Month ===== --}}
                            <div class="mb-4">
                                <label class="fw-semibold">For the month / period of</label>
                                <div class="d-inline-block ms-2">
                                    <input type="text" class="border-0 border-bottom border-dark bg-transparent"
                                        style="width:140px;" value="{{ now()->format('F') }}" readonly>
                                    ,
                                    <input type="text" class="border-0 border-bottom border-dark bg-transparent"
                                        style="width:70px;" value="{{ now()->format('Y') }}" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- ===== Voucher & Date ===== --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="fw-semibold">Voucher No</label>
                                <input type="text" name="voucher_no"
                                    class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                            </div>
                            <div class="col-md-6 text-md-end">
                                <label class="fw-semibold">Date</label>
                                <input type="date"
                                    class="form-control border-0 border-bottom border-dark rounded-0 w-50 ms-auto bg-transparent"
                                    value="{{ now()->format('Y-m-d') }}" readonly>
                            </div>
                        </div>



                        {{-- ===== Basic Information ===== --}}
                        <div class="mb-4 p-3 rounded-3" style="background:#f8fafc;">
                            <table class="table table-borderless align-middle mb-0">
                                <tr>
                                    <td width="40%">1. Name of Retired Officer / Employee</td>
                                    <td width="60%">
                                        <input type="text" name="retired_employee_name"
                                            class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent"
                                            value="{{ $pensionerDetails->name }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2. Name of Pensioner</td>
                                    <td><input type="text" name="pensioner_name"
                                            class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td>3. Designation at the Time of Retirement</td>
                                    <td><input type="text" name="designation"
                                            class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td>4. Office from which Retired</td>
                                    <td><input type="text" name="office_retired_from"
                                            class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td>5. Office from which Pension is being Drawn</td>
                                    <td><input type="text" name="office_pension_drawn"
                                            class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td>6. Sanction Order No & Date</td>
                                    <td>
                                        <div class="d-flex gap-3">
                                            <input type="text" name="sanction_order_no"
                                                class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                            <input type="date"
                                                class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent"
                                                value="{{ now()->format('Y-m-d') }}" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7. PPO No & Date</td>
                                    <td>
                                        <div class="d-flex gap-3">
                                            <input type="text" name="ppo_no"
                                                class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                            <input type="date"
                                                class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent"
                                                value="{{ now()->format('Y-m-d') }}" readonly>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        {{-- ===== Certificates ===== --}}
                        <div class="mb-4">
                            <p class="fw-bold mb-2">8. Certificates</p>
                            <div class="ps-3">
                                <div class="mb-2">
                                    a) Life Certificate Submitted:
                                    <select name="life_certificate" class="form-select d-inline-block w-25 ms-2">
                                        <option value="">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div>
                                    b) Marriage / Re-marriage Certificate Submitted:
                                    <select name="marriage_certificate" class="form-select d-inline-block w-25 ms-2">
                                        <option value="">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                        <option value="na">Not Applicable</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- ===== Pension Details ===== --}}
                        <div class="mb-4 p-3 rounded-3" style="background:#f8fafc;">
                            <p class="fw-bold mb-2">9. Details of Pension Allowance</p>
                            <table class="table table-borderless align-middle mb-0">
                                <tr>
                                    <td width="40%">a) Monthly Pension</td>
                                    <td width="60%"><input type="number" name="monthly_pension"
                                            class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td>b) Dearness / Special Allowance</td>
                                    <td><input type="number" name="dearness_allowance"
                                            class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td>c) % Benefit</td>
                                    <td><input type="text" name="benefit_percentage"
                                            class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td>d) Medical Allowance</td>
                                    <td><input type="number" name="medical_allowance"
                                            class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end fw-bold">Total</td>
                                    <td><input type="number" name="total_amount"
                                            class="form-control border-0 border-bottom border-dark rounded-0 fw-bold bg-transparent">
                                    </td>
                                </tr>
                            </table>
                        </div>

                        {{-- ===== Cheque ===== --}}
                        <div class="mb-4">
                            <label class="fw-semibold">10. Name in which the Cheque is to be Issued</label>
                            <input type="text" name="cheque_name"
                                class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                        </div>


                        {{-- ===== Address & Amount ===== --}}
                        <div class="mb-4">
                            <label class="fw-semibold">Full Address</label>
                            <textarea name="address" rows="2"
                                class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent"></textarea>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Amount (in figures)</label>
                                    <input type="text" name="amount_figures"
                                        class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                </div>
                                <div class="col-md-6">
                                    <label>Amount (in words)</label>
                                    <input type="text" name="amount_words"
                                        class="form-control border-0 border-bottom border-dark rounded-0 bg-transparent">
                                </div>
                            </div>
                        </div>

                        <p class="fw-bold mb-5">Approved for payment through cheque.</p>

                        {{-- ===== Submit Button ===== --}}
                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow">
                                Submit Pension Form
                            </button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection
