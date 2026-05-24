<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::with('user')->paginate(10);
            Log::info('Post list retrieved', ['count' => $posts->count()]);
            return view('posts.index', compact('posts'));
        } catch (\Exception $e) {
            Log::error('Error retrieving posts: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading posts.');
        }
    }

    public function create()
    {
        try {
            $users = User::all();
            return view('posts.create', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error loading create post form: ' . $e->getMessage());
            return redirect()->route('posts.index')->with('error', 'Error loading form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:posts,slug',
                'content' => 'required|string|max:5000',
            ], [
                'user_id.required' => 'Please select an author.',
                'title.required' => 'Post title is required.',
                'slug.unique' => 'This slug already exists.',
                'content.required' => 'Post content is required.',
            ]);

            $post = Post::create($validated);
            Log::info('Post created successfully', ['post_id' => $post->id, 'user_id' => $post->user_id]);
            return redirect()->route('posts.index')->with('success', "Post '{$post->title}' created successfully.");
        } catch (\Exception $e) {
            Log::error('Error creating post: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating post.')->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $post = Post::with('user')->findOrFail($id);
            Log::info('Post details viewed', ['post_id' => $post->id]);
            return view('posts.show', compact('post'));
        } catch (\Exception $e) {
            Log::error('Error viewing post: ' . $e->getMessage());
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }
    }

    public function edit(string $id)
    {
        try {
            $post = Post::findOrFail($id);
            $users = User::all();
            return view('posts.edit', compact('post', 'users'));
        } catch (\Exception $e) {
            Log::error('Error loading edit post form: ' . $e->getMessage());
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $post = Post::findOrFail($id);
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
                'content' => 'required|string|max:5000',
            ]);
            $post->update($validated);
            Log::info('Post updated successfully', ['post_id' => $post->id]);
            return redirect()->route('posts.show', $id)->with('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating post: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating post.')->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $post = Post::findOrFail($id);
            $title = $post->title;
            $post->delete();
            Log::info('Post deleted successfully', ['post_id' => $id]);
            return redirect()->route('posts.index')->with('success', "Post '{$title}' deleted successfully.");
        } catch (\Exception $e) {
            Log::error('Error deleting post: ' . $e->getMessage());
            return redirect()->route('posts.index')->with('error', 'Error deleting post.');
        }
    }
}
