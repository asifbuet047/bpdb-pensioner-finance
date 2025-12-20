@extends('layouts.layout')

@section('title', 'Search Specific Pensionar')

{{-- @viteReactRefresh
@vite('resources/js/app.jsx') --}}

@section('content')
    {{-- <div id="app"></div> --}}
    <section class="vh-100 gradient-custom">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Search Specific Pensioner</h3>
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
                                <div class="mb-4">
                                    <label class="form-label" for="erp_id">ERP ID</label>
                                    <input type="text" id="erp_id" name="erp_id" class="form-control form-control-lg"
                                        placeholder="Sepecific Officer ERP ID" />

                                </div>
                                <div class="mb-4 row">
                                    <button class="btn btn-success" type="submit">Search Pensioner</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
