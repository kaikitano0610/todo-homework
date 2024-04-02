<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

        $students = User::where('role', 'student')->get();
        foreach ($students as $student) {
            DB::table('task_users')->insert([
                'task_id' => $task->id,
                'user_id' => $student->id,
                'status' => 'in_progress', // 初期状態
                'completed_at' => null,    // まだ完了していない
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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
        // タスクに関連する画像と質問も取得
    $task->load('images', 'questions');

    // ユーザーの役割に応じて異なるビューを返す
    if (Auth::user()->role === 'teacher') {
        // 教師用のビューを返す
        return view('admin_home.show_task', compact('task'));
    } else {
        // 生徒用のビューを返す（編集ボタンなし、質問可能）
        return view('student_home.show_task', compact('task'));
    }
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
        // まずtask_usersテーブルから該当するタスクIDのレコードを削除する
        DB::table('task_users')->where('task_id', $id)->delete();
    
        // 次にタスクを削除する
        $task = Task::find($id);
        if ($task) {
            $task->delete();
        }
    
        // ホームページにリダイレクトする
        return redirect()->route("home")->with('success', 'タスクが削除されました。');
    }
    

    public function clear($taskId)
    {
        // ログインしているユーザーのIDを取得
        $userId = Auth::id();
    
        // task_user テーブルのレコードを検索し、status を 'completed' に更新
        DB::table('task_users')
            ->where('task_id', $taskId)
            ->where('user_id', $userId)
            ->update(['status' => 'completed', 'completed_at' => now()]);
    
        return redirect()->back()->with('status', 'タスクがクリアされました！');
    }
    public function undo($taskId)
    {
        // ログインしているユーザーのIDを取得
        $userId = Auth::id();
    
        // task_user テーブルのレコードを検索し、status を 'in_progress' に更新
        DB::table('task_users')
            ->where('task_id', $taskId)
            ->where('user_id', $userId)
            ->update(['status' => 'in_progress', 'completed_at' => null]);
    
        return redirect()->back()->with('status', 'タスクのクリアが取り消されました！');
    }
    
}
