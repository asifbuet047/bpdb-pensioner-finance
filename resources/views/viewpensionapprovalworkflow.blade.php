@extends('layouts.layout')

@section('title', 'Pensioner Workflow')

@section('content')
    <section class="container-fluid py-5">
        <h2 class="mb-4 text-center fw-bold text-primary">Pension Workflow</h2>
        <h1 class="mb-4 text-center fw-bold text-primary">বাংলাদেশ বিদ্যুৎ উন্নয়ন বোর্ড</h1>
        <div class="table-responsive shadow rounded p-2">
            <table class="table table-hover align-middle custom-border">
                <thead class="bg-gradient-primary text-white fw-bolder fs-4">
                    <tr>
                        <th scope="col">
                            No
                        </th>
                        <th scope="col">
                            Pension unique ID
                        </th>
                        <th scope="col">
                            From Status
                        </th>
                        <th scope="col">
                            To Status
                        </th>
                        <th scope="col">
                            Initiated Officer
                        </th>
                        <th scope="col">
                            Timestamp
                        </th>
                        <th scope="col">
                            Message
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pension_workflows as $index => $workflow)
                        <tr class="{{ $index % 2 == 0 ? 'table-light' : '' }} fw-semibold hand-pointer">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $workflow->pension->id }}</td>
                            <td>{{ $workflow->status_from }}</td>
                            <td>{{ $workflow->status_to }}</td>
                            <td>{{ $workflow->officer->name }}</td>
                            <td>{{ $workflow->created_at }}</td>
                            <td>{{ $workflow->message }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted fst-italic">
                                No pension workflow found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-4">
            <a class="btn btn-primary btn-lg me-2 shadow-sm" href="{{ route('add.pensioner.section') }}">
                Add Pensioner
            </a>
            <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('show.pensioner.section') }}">
                Refresh List
            </a>
            <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('download.pensioners') }}">
                Download
            </a>
            <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('import.pentioners.section') }}">
                Import Pensioners
            </a>
            <a class="btn btn-outline-primary btn-lg shadow-sm" href="{{ route('download.template.pensioners') }}">
                Download Excel template
            </a>
        </div>
    </section>

@endsection
