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
                                Add a Pensioner by filling form</h3>

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
                                @foreach ($pensioner_info as $key => $value)
                                    <div class="mb-4">
                                        <label class="form-label" for="{{ $key }}">
                                            Pensioner's {{ ucwords(str_replace('_', ' ', $key)) }}
                                        </label>
                                        @if ($key === 'office' || $key === 'bank_name' || $key === 'bank_branch_name' || $key === 'service_life')
                                            <input type="text" id="{{ $key }}"
                                                class="form-control form-control-lg"
                                                placeholder="Pensioner {{ ucwords(str_replace('_', ' ', $key)) }}"
                                                value="{{ $value }}" {{ isset($success) ? 'disabled' : '' }}>
                                        @else
                                            <input type="text" id="{{ $key }}" name="{{ $key }}"
                                                class="form-control form-control-lg"
                                                placeholder="Pensioner {{ ucwords(str_replace('_', ' ', $key)) }}"
                                                value="{{ $value }}" {{ isset($success) ? 'disabled' : '' }}>
                                        @endif

                                    </div>
                                @endforeach
                                @if (isset($success))
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
