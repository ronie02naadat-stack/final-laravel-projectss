@extends('layouts.app')

@section('content')
@include('components.promotion-banner')

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-person"></i> Student Profiles</h2>
            <p class="text-muted">Manage student profile information</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('profiles.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Create Profile
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (count($profiles) > 0)
        <div class="row">
            @foreach ($profiles as $profile)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h5 class="card-title">{{ $profile->student->getFullNameAttribute() }}</h5>
                                    <p class="text-muted small">{{ $profile->student->email }}</p>
                                </div>
                                <span class="badge bg-primary">ID #{{ $profile->student_id }}</span>
                            </div>
                            
                            @if ($profile->bio)
                                <p class="card-text">{{ Str::limit($profile->bio, 100) }}</p>
                            @endif
                            
                            <div class="mb-3">
                                @if ($profile->location)
                                    <small class="d-block text-muted">
                                        <i class="bi bi-geo-alt"></i> {{ $profile->location }}
                                    </small>
                                @endif
                                @if ($profile->phone)
                                    <small class="d-block text-muted">
                                        <i class="bi bi-telephone"></i> {{ $profile->phone }}
                                    </small>
                                @endif
                            </div>
                            
                            <div class="btn-group" role="group">
                                <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center" role="alert">
            <i class="bi bi-info-circle"></i> No profiles found. <a href="{{ route('profiles.create') }}">Create one now</a>
        </div>
    @endif
</div>
@endsection
