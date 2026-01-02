<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    public function updateStatus(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->status = $request->status;
        $comment->save();
        return response(['success' => true]);
    }

    public function delete($id)
    {
        $comment = Comment::where('id', $id)->first();
        if ($comment) {
            $comment->delete();
            return response(['success' => true]);
        } else {
            return response(['success' => false]);
        }
    }
}
