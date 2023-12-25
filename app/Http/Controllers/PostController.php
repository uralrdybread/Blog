<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function viewSinglePost(Post $post) {
        $ourHTML = Str::markdown($post->body);
        $post['body'] = $ourHTML;
        return view('single-post', ['post' => $post]);
    }



    public function storeNewPost(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'New post successfully created');

    }

    public function showCreateForm() {
        if (!auth()->check) {
            return redirect('/');
        }
        return view('create-post');
    }
}
