<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 


class TaskController extends Controller
{
    public function index()
{
    $tasks = Task::with('images')->get(); // 関連する画像も同時に取得
    return view('tasks.index', compact('tasks'));
}

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
            'images' => 'sometimes|array',
            'images.*' => 'image|max:2048', // 画像ファイルの各項目に対するバリデーション
            
        ]);
        
        $task = new Task; 
        $task->title = $request->title;
        $task->contents = $request->contents;
        $task->due_date = $request->due_date; // due_dateを扱う
        $task->user_id = Auth::id();

        $task->save();

         // 画像がアップロードされている場合
         if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/tasks');
                $task->images()->create(['path' => $path]);
            }
        }

        return redirect()->route("home")->with('success', 'Task and images uploaded successfully.');

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

        return redirect()->route("home"); 
    }

    public function update(Request $request, Task $task)
    {
    $validatedData = $request->validate([
        'title' => 'required|string|max:30',
        'contents' => 'required|string|max:170',
        'due_date' => 'required|date',
        'images' => 'sometimes|array',
        'images.*' => 'image|max:2048', // 複数の画像に対するバリデーション
    ]);

    $task->update($validatedData);

    // 画像がアップロードされている場合、新しい画像を保存
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('public/tasks');
            $task->images()->create(['path' => $path]);
        }
    }

    // 画像を削除する処理が必要な場合はここに追加

    return redirect()->route('tasks.show', $task->id)->with('status', 'タスクが更新されました！');
    }

    // タスクの詳細表示
    public function show(Task $task)
    {
        // タスクに関連する画像も取得
        $task->load('images');
        return view('admin_home.show_task', compact('task'));
    }

    // タスク編集ページ
    public function edit(Task $task)
    {
        // タスクに関連する画像も取得
        $task->load('images');
        return view('admin_home.edit_task', compact('task'));
    }

    //タスクの削除
    public function destroy($id)
    {
        $task =Task::find($id);
        $task->delete();

        return redirect()->route("home");

    }
            
}
