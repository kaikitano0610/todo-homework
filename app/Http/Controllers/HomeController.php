<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Task;

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
    $todayTasks = Task::whereDate('due_date', Carbon::today())->get();
    $todayComments = Comment::whereDate('created_at', Carbon::today())->first(); 

    return view('home', ['todayTasks' => $todayTasks, 'todayComments' => $todayComments]);
    }   


    
}
