<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
// use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;


class PostController extends Controller implements HasMiddleware

{

    public static function middleware(){
        return [
            new Middleware('auth:sanctum', except:['index','show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view('post.home');

        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return 'ok';
        
        $rqPost = $request->validate([
            'title'=> 'required',
            'description'=> 'required',
        ]);
        // return [];

        $post = $request->user()->posts()->create($rqPost); 
        
        return $post; 
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify',$post);
        $rqPost = $request->validate([
            'title'=> 'required',
            'description'=> 'required',
        ]);
        
        $post->update($rqPost); 
        
        return $post; 
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify',$post);
        $post->delete();
        return ['delete'=>true];
    }
}
