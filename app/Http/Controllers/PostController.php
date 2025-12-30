<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
        ]);

        $img = $request->image;
        $fileName = time() . '.' . $img->getClientOriginalExtension();
        $path = public_path('assets/posts/');
        $img->move($path, $fileName);

        $post = new Post();
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->image = $fileName;
        $post->body = $request->body;
        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Post added successfully');
    }

    public function show($id)
    {
        $post = Post::find($id);
        if ($post) {
            return view('posts.show', compact('post'));
        } else {
            return redirect()->route('posts.index')
                ->with('error', 'Post not found');
        }
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::where('status', 1)->get();
        if ($post) {
            return view('posts.edit', compact('post','categories'));
        } else {
            return redirect()->route('posts.index')
                ->with('error', 'Post not found');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable',
        ]);

        $post = Post::find($id);
        $fileName = $post->image;
        if($request->hasFile('image')) {
            $img = $request->image;
            $fileName = time() . '.' . $img->getClientOriginalExtension();
            $path = public_path('assets/posts/');
            $img->move($path, $fileName);
        }
        
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->image = $fileName;
        $post->body = $request->body;
        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    public function delete($id)
    {
        $post = Post::where('id',$id)->first();
        if ($post) {
            $post->delete();
            return response(['success'=>true]);
        } else {
            return response(['success'=>false]);
        }
    }
}