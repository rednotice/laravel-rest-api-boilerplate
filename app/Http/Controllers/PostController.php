<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    public function index(Request $request) 
    {
        // Show only posts by a specific author
        $queryString = $request->query();

        if($queryString) {
            $posts = Post::whereHas('user', function (Builder $query) use ($queryString) {
                $query->where($queryString, '=', $queryString);
            })->get();

            if(!$posts) {
                return response('No posts found', 403);
            }

            return gettype($posts);

            // return response($posts, 200);
        }
        
        // $posts = Post::all();
        // return response($posts, 200);
    }

    public function store(PostStoreRequest $request) 
    {
        $post = new Post;
        $post->fill($request->validated());
        $post->user_id = Auth::user()->id;
        $post->save();
        return response('Saved', 200);
    }

    public function show(Post $post) 
    {
        return response($post, 200);
    }

    public function update(PostUpdateRequest $request, Post $post) 
    {
        $post->save();
        return response('Updated', 200);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response('Deleted', 200);
    }
}
