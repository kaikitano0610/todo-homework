<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\controllers\QuestionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// この一行で、/login,/logout,/register,/password/restなどのパスワード関連のコードとなる。
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 管理者用のルート
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::post('/admin/register', [App\Http\Controllers\AdminController::class, 'register'])->name('admin.register');
});

// 認証が必要なルート
Route::middleware(['auth'])->group(function () {
    Route::get("/home/task_create", [TaskController::class, "create"])->name("tasks.create");
    Route::post("/tasks", [TaskController::class, "storeTask"])->name("tasks.store");
    Route::get("/home/comment_create", [TaskController::class, "comment"])->name("comments.create");
    Route::post("/comments", [TaskController::class, "storeComment"])->name("comment.store");
    Route::post('/tasks/{task}/images', [TaskController::class, 'storeImage'])->name('tasks.storeImage');

    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::put('/tasks/{task}/clear', [TaskController::class, 'clear'])->name('tasks.clear');
    Route::put('/tasks/{task}/undo', [TaskController::class, 'undo'])->name('tasks.undo');
});

// 質問のルート
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

// 進捗のグラフ
Route::get('/tasks/progress', 'TaskController@progress');
