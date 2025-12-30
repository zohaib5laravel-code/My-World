<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    public function index()
    {
        $pictures = Picture::paginate(10);
        return view('pictures.index', compact('pictures'));
    }

    public function create()
    {
        return view('pictures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'image' => 'required',
        ]);

        $img = $request->image;
        $fileName = time() . '.' . $img->getClientOriginalExtension();
        $path = public_path('assets/pictures/');
        $img->move($path, $fileName);

        $picture = new Picture();
        $picture->type = $request->type;
        $picture->image = $fileName;
        $picture->text_over_img = $request->text_over_img;
        $picture->save();

        return redirect()->route('pictures.index')
            ->with('success', 'Picture added successfully');
    }

    public function show($id)
    {
        $picture = Picture::find($id);
        if ($picture) {
            return view('pictures.show', compact('picture'));
        } else {
            return redirect()->route('pictures.index')
                ->with('error', 'Picture not found');
        }
    }

    public function edit($id)
    {
        $picture = Picture::find($id);
        if ($picture) {
            return view('pictures.edit', compact('picture'));
        } else {
            return redirect()->route('pictures.index')
                ->with('error', 'Picture not found');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'image' => 'nullable',
        ]);

        $picture = Picture::find($id);
        $fileName = $picture->image;
        if($request->hasFile('image')) {
            $img = $request->image;
            $fileName = time() . '.' . $img->getClientOriginalExtension();
            $path = public_path('assets/pictures/');
            $img->move($path, $fileName);
        }
        
        $picture->type = $request->type;
        $picture->image = $fileName;
        $picture->text_over_img = $request->text_over_img;
        $picture->save();

        return redirect()->route('pictures.index')
            ->with('success', 'Picture updated successfully');
    }

    public function delete($id)
    {
        $picture = Picture::where('id',$id)->first();
        if ($picture) {
            $picture->delete();
            return response(['success'=>true]);
        } else {
            return response(['success'=>false]);
        }
    }
}
