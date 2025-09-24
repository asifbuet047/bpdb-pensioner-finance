@extends('layouts.layout')

@section('title', 'Import Pensioner')

@section('content')

    <section>
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Import Excel file to add Pensioners</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('import.pensioners') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="file" class="form-label fw-bold">Upload Excel File</label>
                                    <input type="file" name="file" id="file" class="form-control" required>
                                </div>

                                @if (session('success'))
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100" disabled>
                                            <i class="bi bi-upload"></i> Import Pensioners Successful
                                        </button>
                                    </div>
                                @else
                                    <div class="mb-3"> <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-upload"></i> Import Pensioners
                                        </button></div>
                                @endif

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
