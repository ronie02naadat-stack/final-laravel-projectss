@extends('layouts.app')

@section('content')
@include('components.promotion-banner')

<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Degrees</h1>
        </div>
        <div class="col-md-4 text-end">
            @if (!auth()->check() || auth()->user()->user_type !== 'student')
                <a href="{{ route('degrees.create') }}" class="btn btn-primary">Add New Degree</a>
            @endif
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Warning!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="80px">#</th>
                    <th>Degree Title</th>
                    <th width="120px">Courses</th>
                    <th width="280px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($degrees as $degree)
                    <tr>
                        <td>{{ $degree->id }}</td>
                        <td>{{ $degree->degree_title }}</td>
                        <td>
                            <span class="badge bg-info">{{ $degree->courses_count }} course(s)</span>
                        </td>
                        <td>
                            <a href="{{ route('degrees.show', $degree->id) }}" class="btn btn-info btn-sm">View</a>
                            @if (!auth()->check() || auth()->user()->user_type !== 'student')
                                <a href="{{ route('degrees.edit', $degree->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('degrees.destroy', $degree->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No degrees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $degrees->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
