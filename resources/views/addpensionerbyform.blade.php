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
                                        <label class="form-label" for="{{ $key }}"
                                            {{ $key === 'office_id' ? 'hidden' : '' }}>
                                            Pensioner's {{ ucwords(str_replace('_', ' ', $key)) }}
                                        </label>
                                        @if (
                                            $key === 'office' ||
                                                $key === 'bank_name' ||
                                                $key === 'bank_branch_name' ||
                                                $key === 'service_life' ||
                                                $key === 'bank_branch_address')
                                            <input type="text" id="{{ $key }}"
                                                class="form-control form-control-lg"
                                                placeholder="Enter {{ ucwords(str_replace('_', ' ', $key)) }}"
                                                value="{{ $value }}" {{ isset($success) ? 'disabled' : '' }}>
                                        @else
                                            @if (
                                                $key === 'is_self_pension' ||
                                                    $key === 'status' ||
                                                    $key === 'verified' ||
                                                    $key === 'biometric_verified' ||
                                                    $key === 'religion' ||
                                                    $key === 'biometric_verification_type')
                                                <select name="{{ $key }}" id="{{ $key }}"
                                                    class="form-select shadow-sm" {{ isset($success) ? 'disabled' : '' }}>
                                                    @switch($key)
                                                        @case('is_self_pension')
                                                            <option value="1" selected>Self</option>
                                                            <option value="0">Family</option>
                                                        @break

                                                        @case('religion')
                                                            <option value="Islam" {{ $value == 'Islam' ? 'selected' : '' }}>Islam
                                                            </option>
                                                            <option value="Hinduism" {{ $value == 'Hinduism' ? 'selected' : '' }}>
                                                                Hinduism</option>
                                                            <option value="Christianity"
                                                                {{ $value == 'Christians' ? 'selected' : '' }}>Christianity
                                                            </option>
                                                            <option value="Buddhists" {{ $value == 'Buddhism' ? 'selected' : '' }}>
                                                                Buddhism</option>
                                                            <option value="Other" {{ $value == 'Others' ? 'selected' : '' }}>
                                                                Others</option>
                                                        @break

                                                        @case('status')
                                                            <option value="floated" selected>floated</option>
                                                            <option value="initiated">initiated</option>
                                                            <option value="certified">certified</option>
                                                            <option value="approved">approved</option>
                                                        @break

                                                        @case('verified')
                                                            <option value="1">Verified</option>
                                                            <option value="0" selected>Not verified</option>
                                                        @break

                                                        @case('biometric_verified')
                                                            <option value="1">Verified</option>
                                                            <option value="0" selected>Not verified</option>
                                                        @break

                                                        @case('biometric_verification_type')
                                                            <option value="fingerprint" selected>Fingerprint</option>
                                                            <option value="face">Facial</option>
                                                        @break

                                                        @default
                                                    @endswitch
                                                </select>
                                            @else
                                                <input type="text" id="{{ $key }}" name="{{ $key }}"
                                                    {{ $key === 'office_id' ? 'hidden' : '' }}
                                                    class="form-control form-control-lg"
                                                    placeholder="Enter {{ ucwords(str_replace('_', ' ', $key)) }}"
                                                    value="{{ $value }}" {{ isset($success) ? 'disabled' : '' }}>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                                <input type="hidden" name="religion" value="{{ $pensioner_info['religion'] }}">
                                <input type="hidden" name="status" value="floated">
                                <input type="hidden" name="verified" value="0">
                                <input type="hidden" name="biometric_verified" value="0">
                                <input type="hidden" name="biometric_verification_type" value="fingerprint">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
