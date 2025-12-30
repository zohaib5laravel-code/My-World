<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
        ]);

        $img = $request->image;
        $fileName = time() . '.' . $img->getClientOriginalExtension();
        $path = public_path('assets/categories/');
        $img->move($path, $fileName);

        $category = new category();
        $category->name = $request->name;
        $category->image = $fileName;
        
        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'category added successfully');
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return view('categories.show', compact('category'));
        } else {
            return redirect()->route('categories.index')
                ->with('error', 'category not found');
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if ($category) {
            return view('categories.edit', compact('category'));
        } else {
            return redirect()->route('categories.index')
                ->with('error', 'category not found');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
        ]);

        $category = Category::find($id);
        $fileName = $category->image;
        if($request->hasFile('image')) {
            $img = $request->image;
            $fileName = time() . '.' . $img->getClientOriginalExtension();
            $path = public_path('assets/categories/');
            $img->move($path, $fileName);
        }
        
        $category->name = $request->name;
        $category->image = $fileName;
        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'category updated successfully');
    }

    public function delete($id)
    {
        $category = Category::where('id',$id)->first();
        if ($category) {
            $category->delete();
            return response(['success'=>true]);
        } else {
            return response(['success'=>false]);
        }
    }
}
