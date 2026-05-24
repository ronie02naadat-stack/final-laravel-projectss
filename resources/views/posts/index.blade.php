@extends('layouts.app')

@section('content')
@include('components.promotion-banner')

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-file-earmark-text"></i> Blog Posts</h2>
            <p class="text-muted">Create and manage your blog posts</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Write Post
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (count($posts) > 0)
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div style="flex: 1;">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="text-muted small mb-2">
                                        By <strong>{{ $post->user->name }}</strong> • {{ $post->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                                </div>
                                <span class="badge bg-primary">ID #{{ $post->id }}</span>
                            </div>

                            <div class="btn-group" role="group">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Read
                                </a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')">
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
            <i class="bi bi-info-circle"></i> No posts yet. <a href="{{ route('posts.create') }}">Create your first post</a>
        </div>
    @endif
</div>
@endsection
