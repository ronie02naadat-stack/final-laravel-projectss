@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-book"></i> Courses by Degree</h2>
            <p class="text-muted">All courses organized by their degree programs</p>
        </div>
    </div>

    @forelse ($degrees as $degree)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-mortarboard"></i> 
                    {{ $degree->degree_title }}
                    <span class="badge bg-light text-dark">{{ $degree->degree_code }}</span>
                    <span class="badge bg-info">{{ $degree->courses->count() }} courses</span>
                </h5>
                @if ($degree->description)
                    <small class="text-light">{{ $degree->description }}</small>
                @endif
            </div>
            <div class="card-body">
                @forelse ($degree->courses as $course)
                    <div class="row align-items-center border-bottom pb-3 mb-3">
                        <div class="col-md-2">
                            <span class="badge bg-success">{{ $course->code }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong>{{ $course->course_name }}</strong>
                            @if ($course->description)
                                <br><small class="text-muted">{{ Str::limit($course->description, 60) }}</small>
                            @endif
                        </div>
                        <div class="col-md-3">
                            @if ($course->teacher)
                                <i class="bi bi-person-fill"></i> 
                                <strong>Teacher:</strong> {{ $course->teacher->name }}
                            @else
                                <span class="text-muted">No teacher assigned</span>
                            @endif
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="badge bg-secondary">
                                {{ $course->students()->count() }} students
                            </span>
                        </div>
                        <div class="col-md-1 text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if (auth()->check() && auth()->user()->user_type === 'admin')
                                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> No courses assigned to this degree
                    </div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> No degrees found
        </div>
    @endforelse
</div>
@endsection
