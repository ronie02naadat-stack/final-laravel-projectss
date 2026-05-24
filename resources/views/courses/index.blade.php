@extends('layouts.app')

@section('content')
@include('components.promotion-banner')

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-book"></i> Courses</h2>
            <p class="text-muted">
                @if (auth()->check() && auth()->user()->user_type === 'student')
                    Your enrolled courses and teachers
                @else
                    Browse and manage available courses
                @endif
            </p>
        </div>
        <div class="col-md-4 text-end">
            @if (!auth()->check() || auth()->user()->user_type !== 'student')
                <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Create Course
                </a>
            @endif
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (count($courses) > 0)
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">{{ $course->course_name }}</h5>
                                <span class="badge bg-success">{{ $course->code }}</span>
                            </div>
                            
                            @if ($course->description)
                                <p class="card-text text-muted">{{ Str::limit($course->description, 100) }}</p>
                            @endif
                            
                            <div class="mb-3">
                                @if ($course->teacher)
                                    <small class="d-block text-muted">
                                        <i class="bi bi-person-fill"></i> 
                                        <strong>Teacher:</strong> {{ $course->teacher->name }}
                                    </small>
                                @endif
                                
                                @if ($course->degree)
                                    <small class="d-block text-muted">
                                        <i class="bi bi-mortarboard"></i> 
                                        <strong>Degree:</strong> 
                                        <a href="{{ route('degrees.show', $course->degree->id) }}" class="text-decoration-none">
                                            {{ $course->degree->degree_title }}
                                        </a>
                                    </small>
                                @endif
                                
                                @if (!auth()->check() || auth()->user()->user_type !== 'student')
                                    <small class="d-block text-muted">
                                        <i class="bi bi-people"></i> 
                                        <strong>{{ $course->students_count ?? $course->students->count() }}</strong> student(s) enrolled
                                    </small>
                                @endif
                            </div>
                            
                            @if (!auth()->check() || auth()->user()->user_type !== 'student')
                                <div class="btn-group" role="group">
                                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View Course Details
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $courses->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="alert alert-info text-center" role="alert">
            <i class="bi bi-info-circle"></i> No courses available. <a href="{{ route('courses.create') }}">Create one now</a>
        </div>
    @endif
</div>
@endsection
