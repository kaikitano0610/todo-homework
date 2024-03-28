<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    function create()
    {
        return view("admin_home.create_task");
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'contents' => 'required|string',
            'due_date' => 'required|date', // due_dateがフォームから送信される場合
            
        ]);
        

        $task = new Task; 
        $task->title = $request->title;
        $task->contents = $request->contents;
        $task->due_date = $request->due_date; // due_dateを扱う
        $task->user_id = Auth::id();

        $task->save();

        return redirect()->route("home"); // 適切なリダイレクト先に変更してください
    }
    
}
