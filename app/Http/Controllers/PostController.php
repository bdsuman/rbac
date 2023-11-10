<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
//    public function __construct( ) {
//
//        //Permission Check
//        $this->middleware(['permission:create-post'])->only('store');
//        $this->middleware(['permission:read-post'])->only('show');
//        $this->middleware(['permission:update-post'])->only('update');
//        $this->middleware(['permission:delete-post'])->only('destroy');
//    }
    /**
     * Display a listing of the resource.
     */
    public function postPage()
    {
        return view('dashboard.pages.post-page');
    }

    public function index()
    {
        return Post::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id=auth()->id();
        $this->authorize('create-post');

        return Post::create([
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'user_id'=>$user_id
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $this->authorize('update-post');
        $post_id=$request->input('id');
        return Post::where('id',$post_id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
            $this->authorize('update-post');

            $post_id = $request->input('id');

            return Post::where('id', $post_id)->update([
                'title' => $request->input('title'),
                'description' => $request->input('description')
            ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete-post');
        $post_id=$request->input('id');
        return Post::where('id',$post_id)->delete();
    }
}
