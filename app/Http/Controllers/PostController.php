<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'featured_image' => 'required|image|max:2048',
            'images' => 'nullable',
            'excerpt' => 'nullable|max:500',
            'status' => 'in:draft,published,archived',
            'published_at' => 'nullable|date'
        ]);

        $img = $request->featured_image;
        $featuredImage = time() . '.' . $img->getClientOriginalExtension();
        $path = public_path('assets/posts/');
        $img->move($path, $featuredImage);

        $uploadedImages = [];
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = public_path('assets/posts/');
                $image->move($path, $imageName);

                $uploadedImages[] = $imageName;
            }
        }

        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title) . '-' . uniqid();
        $post->excerpt = $request->excerpt;
        $post->content = $request->content;
        $post->featured_image = $featuredImage ?? null;
        $post->images = !empty($uploadedImages) ? json_encode($uploadedImages) : null;
        $post->category_id = $request->category_id;
        $post->status = $request->status ?? 'draft';
        $post->published_at = $request->status === 'published' ? ($request->published_at ?? now()) : null;
        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Post added successfully');
    }

    public function show($id)
    {
        $post = Post::find($id);
        if ($post) {
            return view('admin.posts.show', compact('post'));
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
            return view('admin.posts.edit', compact('post', 'categories'));
        } else {
            return redirect()->route('posts.index')
                ->with('error', 'Post not found');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'images' => 'nullable',
            'excerpt' => 'nullable|max:500',
            'status' => 'in:draft,published,archived',
            'published_at' => 'nullable|date'
        ]);

        $post = Post::find($id);
        $featuredImage = $post->featured_image;
        if ($request->hasFile('featured_image')) {
            $img = $request->featured_image;
            $featuredImage = time() . '.' . $img->getClientOriginalExtension();
            $path = public_path('assets/posts/');
            $img->move($path, $featuredImage);
        }

        $existingImages = $post->images ? json_decode($post->images, true) : [];
        $uploadedImages = [];

        if ($request->has('existing_images')) {
            foreach ($existingImages as $image) {
                if (in_array($image, $request->existing_images)) {
                    $uploadedImages[] = $image;
                } else {
                    $oldImagePath = public_path('assets/posts/' . $image);
                    if (file_exists($oldImagePath)) {
                        try {
                            unlink($oldImagePath);
                        } catch (\Exception $e) {
                            Log::error('Failed to delete image: ' . $oldImagePath, ['error' => $e->getMessage()]);
                        }
                    }
                }
            }
        } else {
            foreach ($existingImages as $image) {
                $oldImagePath = public_path('assets/posts/' . $image);
                if (file_exists($oldImagePath)) {
                    try {
                        unlink($oldImagePath);
                    } catch (\Exception $e) {
                        Log::error('Failed to delete image: ' . $oldImagePath, ['error' => $e->getMessage()]);
                    }
                }
            }
        }

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = public_path('assets/posts/');
                $image->move($path, $imageName);

                $uploadedImages[] = $imageName;
            }
        }

        if ($post->title !== $request->title) {
            $post->slug = Str::slug($request->title) . '-' . uniqid();
        }

        $post->title = $request->title;
        $post->excerpt = $request->excerpt;
        $post->content = $request->content;
        $post->featured_image = $featuredImage;
        $post->images = !empty($uploadedImages) ? json_encode($uploadedImages) : null;
        $post->category_id = $request->category_id;
        $post->status = $request->status ?? $post->status;

        if ($request->status === 'published' && $post->status !== 'published') {
            $post->published_at = $request->published_at ?? now();
        } elseif ($request->status !== 'published') {
            $post->published_at = null;
        }
        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    public function delete($id)
    {
        $post = Post::where('id', $id)->first();
        if ($post) {
            $post->delete();
            return response(['success' => true]);
        } else {
            return response(['success' => false]);
        }
    }
}
