@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="bi bi-book"></i> Course Details</h4>
                        <span class="badge bg-light text-dark">{{ $course->code }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <h5>{{ $course->course_name }}</h5>
                    
                    @if ($course->description)
                        <div class="mb-4">
                            <strong>Description:</strong>
                            <p class="mt-2">{{ $course->description }}</p>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Course Code:</strong>
                            <p>{{ $course->code }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Total Enrolled:</strong>
                            <p><span class="badge bg-primary">{{ count($course->students) }}</span> student(s)</p>
                        </div>
                    </div>

                    @if (count($course->students) > 0)
                        <div class="mb-4">
                            <strong><i class="bi bi-people"></i> Enrolled Students ({{ count($course->students) }}):</strong>
                            <div class="mt-3">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Email</th>
                                            <th>Degree</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($course->students as $student)
                                            <tr>
                                                <td>{{ $student->getFullNameAttribute() }}</td>
                                                <td>{{ optional($student->user)->email ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($student->degree)
                                                        <span class="badge bg-info">{{ $student->degree->degree_title }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">No Degree</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> No students enrolled in this course yet.
                        </div>
                    @endif

                    <div class="mb-3">
                        <strong>Created:</strong>
                        <p>{{ $course->created_at->format('M d, Y @ h:i A') }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                            <i class="bi bi-list"></i> Back to Courses
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
