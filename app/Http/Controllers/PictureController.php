<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PictureController extends Controller
{
    public function index()
    {
        $pictures = Picture::paginate(10);
        return view('admin.pictures.index', compact('pictures'));
    }

    public function create()
    {
        return view('admin.pictures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:gallery,banner',
            'image' => 'required|image|max:5120',
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'status' => 'boolean'
        ]);

        $img = $request->image;
        $fileName = time() . '.' . $img->getClientOriginalExtension();
        $path = public_path('assets/pictures/');
        $img->move($path, $fileName);

        $picture = new Picture();
        $picture->title = $request->title;
        $picture->type = $request->type;
        $picture->image = $fileName;
        $picture->description = $request->description;
        $picture->status = $request->status ?? 1;
        $picture->save();
        return redirect()->route('pictures.index')
            ->with('success', 'Picture added successfully');
    }

    public function show($id)
    {
        $picture = Picture::find($id);
        if ($picture) {
            return view('admin.pictures.show', compact('picture'));
        } else {
            return redirect()->route('pictures.index')
                ->with('error', 'Picture not found');
        }
    }

    public function edit($id)
    {
        $picture = Picture::find($id);
        if ($picture) {
            return view('admin.pictures.edit', compact('picture'));
        } else {
            return redirect()->route('pictures.index')
                ->with('error', 'Picture not found');
        }
    }

    public function update(Request $request, $id)
    {
         $request->validate([
            'type' => 'required|in:gallery,banner',
            'image' => 'nullable|image|max:5120',
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'status' => 'boolean'
        ]);

        $picture = Picture::find($id);
        $fileName = $picture->image;
        if ($request->hasFile('image')) {
            $img = $request->image;
            $fileName = time() . '.' . $img->getClientOriginalExtension();
            $path = public_path('assets/pictures/');
            $img->move($path, $fileName);

              if ($picture->image && File::exists(public_path('assets/pictures/' . $picture->image))) {
                File::delete(public_path('assets/pictures/' . $picture->image));
            }
        }

        $picture->title = $request->title;
        $picture->type = $request->type;
        $picture->image = $fileName;
        $picture->description = $request->description;
        $picture->save();

        return redirect()->route('pictures.index')
            ->with('success', 'Picture updated successfully');
    }

    public function delete($id)
    {
        $picture = Picture::where('id', $id)->first();
        if ($picture) {
             if ($picture->image && File::exists(public_path('assets/pictures/' . $picture->image))) {
                File::delete(public_path('assets/pictures/' . $picture->image));
            }
            
            $picture->delete();
            return response(['success' => true]);
        } else {
            return response(['success' => false]);
        }
    }
}
