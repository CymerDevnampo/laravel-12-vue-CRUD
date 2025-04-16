<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function showPosts()
    {
        $allPosts = Post::all()->map(function ($post) {
            $post->encrypted_id = encrypt($post->id);
            return $post;
        });

        return Inertia::render('Posts/Index', [
            'allPosts' => $allPosts,
        ]);
    }

    public function createPosts()
    {
        return Inertia::render('Posts/Create');
    }

    public function storePosts(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $posts = new Post();
        $posts->user_id = Auth()->user()->id;
        $posts->title = $request->title;
        $posts->body = $request->body;
        $posts->save();

        return redirect()->route('show.posts');
    }

    public function editPosts($id)
    {
        $decryptID = decrypt($id);
        $editPost = Post::findOrFail($decryptID);

        return Inertia::render('Posts/Edit', [
            'editPost' => $editPost,
            'id' => $id,
        ]);
    }

    public function updatePosts(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $decryptID = decrypt($id);
        $posts = Post::findOrFail($decryptID);
        $posts->title = $request->title;
        $posts->body = $request->body;
        $posts->save();

        return redirect()->route('show.posts');
    }

    public function deletePosts($id)
    {
        $decryptID = decrypt($id);
        $deletePost = Post::findOrFail($decryptID);
        $deletePost->delete();

        return redirect()->route('show.posts');
    }
}
