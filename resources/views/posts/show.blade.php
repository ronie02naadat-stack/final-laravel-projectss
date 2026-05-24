@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <article class="card">
                <div class="card-body">
                    <h1 class="card-title mb-3">{{ $post->title }}</h1>
                    
                    <div class="text-muted mb-4 pb-3 border-bottom">
                        <strong>By {{ $post->user->name }}</strong> 
                        <span class="ms-2">{{ $post->created_at->format('F d, Y') }}</span>
                        @if ($post->updated_at != $post->created_at)
                            <span class="ms-2 text-danger">(Updated: {{ $post->updated_at->format('F d, Y') }})</span>
                        @endif
                    </div>

                    <div class="post-content mb-4">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <div class="row mt-4 pt-3 border-top">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Post Slug:</strong> {{ $post->slug }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Post ID:</strong> #{{ $post->id }}
                            </small>
                        </div>
                    </div>
                </div>
            </article>

            <div class="mt-4">
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Post
                </a>
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                    <i class="bi bi-list"></i> Back to Posts
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
