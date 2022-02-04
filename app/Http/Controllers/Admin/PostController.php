<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(5);
        $categories = Category::all();
        return view('admin.posts.index', compact('posts','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title'=>"required|max:255|min:2",
                'content'=>"required",   
            ],
            [
                'title.required'=> "You have to title your post",
                'title.max' => "Title excedes :max characters",
                'title.min' => "Title must be at least :min character long",

                'content.required' => "You have to fill the content",
            ]
            );
        $data = $request->all();
        $data['slug'] = Post::generateSlug($data['title']);
        $new_post = new Post();
        $new_post->fill($data);
        $new_post->save();
        return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if($post){
            return view('admin.posts.show',compact('post'));
        }
        abort(404,'Post not foud');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        if($post){
            return view('admin.posts.edit', compact('post','categories'));
        }
        abort(404, 'The post you want to edit is not present');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate(
            [
                'title'=>"required|max:255|min:2",
                'content'=>"required",   
            ],
            [
                'title.required'=> "You have to title your post",
                'title.max' => "Title excedes :max characters",
                'title.min' => "Title must be at least :min character long",

                'content.required' => "You have to fill the content",
            ]
            );
        $data = $request->all();
        if($data['title'] != $post->title){
            $data['slug'] = Post::generateSlug($data['title']);
        }
        
        $post->update($data);
        return redirect()->route('admin.posts.show',$post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('deleted',"This post has been deleted: $post->title ");
    }
}
