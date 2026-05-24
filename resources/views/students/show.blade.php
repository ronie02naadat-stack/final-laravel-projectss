@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Student Details</h1>

            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <strong>First Name:</strong>
                        <p>{{ $student->first_name }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Middle Name:</strong>
                        <p>{{ $student->middle_name ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Last Name:</strong>
                        <p>{{ $student->last_name }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Email:</strong>
                        <p>{{ $student->email }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Address:</strong>
                        <p>{{ $student->address }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Contact Number:</strong>
                        <p>{{ $student->contact_number }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Degree:</strong>
                        <p>{{ $student->degree->degree_title ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Created At:</strong>
                        <p>{{ $student->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
