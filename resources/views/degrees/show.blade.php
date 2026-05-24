@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>{{ $degree->degree_title }}</h1>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Degree Title:</strong>
                        <p>{{ $degree->degree_title }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Created At:</strong>
                        <p>{{ $degree->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        @if (!auth()->check() || auth()->user()->user_type !== 'student')
                            <a href="{{ route('degrees.edit', $degree->id) }}" class="btn btn-warning">Edit</a>
                        @endif
                        <a href="{{ route('degrees.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>

            <!-- Courses Section -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📚 Courses in {{ $degree->degree_title }}</h5>
                </div>
                <div class="card-body">
                    @if ($courses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Course Name</th>
                                        <th>Code</th>
                                        <th>Teacher</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td>
                                                <strong>{{ $course->course_name }}</strong>
                                                @if ($course->description)
                                                    <br><small class="text-muted">{{ Str::limit($course->description, 60) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $course->code }}</span>
                                            </td>
                                            <td>
                                                @if ($course->teacher)
                                                    <small>{{ $course->teacher->name }}</small>
                                                @else
                                                    <small class="text-muted">-</small>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i> No courses available for this degree yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
