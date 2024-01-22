<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Comment;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function createCommentView($id): View{
        $user = Auth::user();
        return view('comment.create_comment', [
            'topic_id' => $id
        ]);
    }
    
    public function createComment(Request $request, $id) {
        $comment = new Comment([
            'text' => $request->text,
            'user_id' => Auth::user()->id,
            'topic_id' => $id
        ]);

        $comment->save();

        return redirect('/');
    }
}
