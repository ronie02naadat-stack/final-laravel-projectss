@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Add New Degree</h1>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('degrees.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="degree_title" class="form-label">Degree Title</label>
                    <input type="text" name="degree_title" id="degree_title" class="form-control @error('degree_title') is-invalid @enderror" value="{{ old('degree_title') }}" placeholder="Enter degree title">
                    @error('degree_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('degrees.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
