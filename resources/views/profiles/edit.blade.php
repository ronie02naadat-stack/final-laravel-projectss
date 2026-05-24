@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Profile</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Validation Errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('profiles.update', $profile->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student</label>
                            <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                                <option value="">Select a student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}" {{ $profile->student_id == $student->id ? 'selected' : '' }}>
                                        {{ $student->getFullNameAttribute() }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4" placeholder="Write a brief bio...">{{ old('bio', $profile->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" placeholder="City, Country" value="{{ old('location', $profile->location) }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="+1 (555) 123-4567" value="{{ old('phone', $profile->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar URL</label>
                            <input type="text" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" placeholder="https://example.com/avatar.jpg" value="{{ old('avatar', $profile->avatar) }}">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle"></i> Update Profile
                            </button>
                            <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
