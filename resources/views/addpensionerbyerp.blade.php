@extends('layouts.layout')

@section('title', 'Add Pensioner by ERP no')

@section('content')

    <section>
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Add a Pensioner by ERP</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('search.pensioner.erp.process') }}" method="POST">
                                @csrf

                                @foreach ($pensioner_info as $key => $value)
                                    <div class="mb-4">
                                        <label class="form-label" for="{{ $key }}">
                                            Pensioner's {{ ucwords(str_replace('_', ' ', $key)) }}
                                        </label>

                                        <input type="text" id="{{ $key }}" name="{{ $key }}"
                                            class="form-control form-control-lg"
                                            placeholder="Pensioner {{ ucwords(str_replace('_', ' ', $key)) }}"
                                            value="{{ $value }}">
                                    </div>
                                @endforeach

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
