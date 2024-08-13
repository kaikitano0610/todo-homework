<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::id(); // 現在のユーザーIDを取得

        $todayTasks = Task::whereDate('due_date', Carbon::today())
            ->with(['taskUsers' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->get();
            
        //今日のコメントを取得
        $todayComments = Comment::whereDate('created_at', Carbon::today())->first(); 

        // 明日以降の締切日を持つタスクを取得
        $futureTasks = Task::where('due_date', '>', Carbon::today())
        ->with(['taskUsers' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])
        ->get();

        // 今日の完了したタスクの数をカウント
        $completedTasksCount = $todayTasks->filter(function ($task) use ($userId) {
            $userTask = $task->taskUsers->where('user_id', $userId)->first();
            return $userTask && $userTask->status == 'completed';
        })->count();

        // 今日の未完了のタスクの数をカウント
        $incompleteTasksCount = $todayTasks->count() - $completedTasksCount;

        return view('home', [
            'todayTasks' => $todayTasks,
            'todayComments' => $todayComments,
            'futureTasks' => $futureTasks,
            'completedTasksCount' => $completedTasksCount,
            'incompleteTasksCount' => $incompleteTasksCount,
            ]);
        }   


    
}
