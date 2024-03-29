<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // 編集ページを表示するためのメソッド
    public function edit(Comment $comment)
    {
        return view('admin_home.edit_comment', compact('comment'));
    }

    // コメントを更新するためのメソッド
    public function update(Request $request, Comment $comment)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($validatedData);

        return redirect()->route('home')->with('status', 'コメントが更新されました！');
    }
}
