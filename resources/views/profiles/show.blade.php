@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="bi bi-person"></i> Profile Details</h4>
                        <span class="badge bg-light text-dark">ID #{{ $profile->id }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if ($profile->avatar)
                        <div class="text-center mb-4">
                            <img src="{{ $profile->avatar }}" alt="Avatar" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>{{ $profile->student->getFullNameAttribute() }}</h5>
                        <p class="text-muted">{{ $profile->student->email }}</p>
                    </div>

                    @if ($profile->bio)
                        <div class="mb-3">
                            <strong>Bio:</strong>
                            <p>{{ $profile->bio }}</p>
                        </div>
                    @endif

                    @if ($profile->location)
                        <div class="mb-3">
                            <strong><i class="bi bi-geo-alt"></i> Location:</strong>
                            <p>{{ $profile->location }}</p>
                        </div>
                    @endif

                    @if ($profile->phone)
                        <div class="mb-3">
                            <strong><i class="bi bi-telephone"></i> Phone:</strong>
                            <p>{{ $profile->phone }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <strong>Created:</strong>
                        <p>{{ $profile->created_at->format('M d, Y @ h:i A') }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('profiles.index') }}" class="btn btn-secondary">
                            <i class="bi bi-list"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
