@extends('layouts.layout')

@section('title', 'Update Officer')

@section('content')
    <section class="gradient-custom">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 row justify-content-center align-items-center font-bold">
                                Update Officer's Role form</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('update.officer.process') }}" method="POST">
                                @csrf

                                <input type="hidden" name="id" value="{{ $officer->id }}" />

                                <div class="mb-4">
                                    <label class="form-label" for="erp_id">Officer's ERP ID</label>
                                    <input type="number" id="erp_id" name="erp_id" class="form-control form-control-lg"
                                        placeholder="officer ERP ID" value="{{ $officer->erp_id }}" disabled />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="name">Officer's Name</label>
                                    <input type="text" id="name" name="name" class="form-control form-control-lg"
                                        value="{{ $officer->name }}" disabled />
                                </div>


                                <div class="mb-4">
                                    <label class="form-label" for="office">Officer's Office</label>
                                    <input type="text" name="office" class="form-control form-control-lg"
                                        value="{{ $officer->office->name_in_english }}" disabled />
                                </div>


                                <div class="mb-4">
                                    <label class="form-label" for="designation">Officer's Designation</label>
                                    <input type="text" name="designation" class="form-control form-control-lg"
                                        value="{{ $officer->designation->description_english }}" disabled />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="role">Officer's Role</label>
                                    @if (session()->has('role'))
                                        <select name="role" class="form-select shadow-sm">
                                            <option value="initiator" selected>Initiator</option>
                                            <option value="certifier">Certifier</option>
                                            <option value="approver">Approver</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    @else
                                        <select name="role" class="form-select shadow-sm">
                                            @switch($officer->role->role_name)
                                                @case('super_admin')
                                                    <option value="super_admin" selected>Super Admin</option>
                                                @break

                                                @case('initiator')
                                                    <option value="initiator" selected>Initiator</option>
                                                    <option value="certifier">Certifier</option>
                                                    <option value="approver">Approver</option>
                                                    <option value="admin">Admin</option>
                                                @break

                                                @case('certifier')
                                                    <option value="initiator">Initiator</option>
                                                    <option value="certifier" selected>Certifier</option>
                                                    <option value="approver">Approver</option>
                                                    <option value="admin">Admin</option>
                                                @break

                                                @case('approver')
                                                    <option value="initiator">Initiator</option>
                                                    <option value="certifier">Certifier</option>
                                                    <option value="approver" selected>Approver</option>
                                                    <option value="admin">Admin</option>
                                                @break

                                                @case('admin')
                                                    <option value="initiator">Initiator</option>
                                                    <option value="certifier">Certifier</option>
                                                    <option value="approver">Approver</option>
                                                    <option value="admin" selected>Admin</option>
                                                @break

                                                @default
                                            @endswitch
                                        </select>
                                    @endif
                                </div>


                                @if (session()->has('name'))
                                    <div class="mb-4 row">
                                        <button class="btn btn-success"
                                            onclick="window.location='{{ route('login.page', ['type' => 'officer']) }}'"
                                            type="button">Update
                                            successful.
                                            Go to Login page</button>
                                    </div>
                                @else
                                    <div class="mb-4 row">
                                        @if ($officer->role->role_name === 'super_admin')
                                            <button class="btn btn-primary" type="submit" disabled>You can't update this
                                                officers role</button>
                                        @else
                                            <button class="btn btn-primary" type="submit">UPDATE OFFICER</button>
                                        @endif

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
