<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    function create()
    {
        return view("admin_home.create_task");
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:30',
            'contents' => 'required|string|max:170',
            'due_date' => 'required|date', // due_dateがフォームから送信される場合
            'image' => 'required|image|max:2048', // 画像に関するバリデーション
            
        ]);
        

        $task = new Task; 
        $task->title = $request->title;
        $task->contents = $request->contents;
        $task->due_date = $request->due_date; // due_dateを扱う
        $task->user_id = Auth::id();

        $task->save();

         // 画像がアップロードされている場合
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/tasks');

            // 画像情報をデータベースに保存
            $task->images()->create([
            'path' => $path,
        ]);
    }

            return redirect()->route("home")->with('success', 'Task and image uploaded successfully.');

    }

    function comment()
    {
        return view("admin_home.create_comment");
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:170',
        ]);
    
        $comment = new Comment; 
        $comment->content = $request->content;
        $comment->user_id = Auth::id();

        $comment->save();

        return redirect()->route("home"); // 適切なリダイレクト先に変更してください
    }
            
}
