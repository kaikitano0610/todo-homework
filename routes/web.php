<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

// 管理者によるユーザー登録処理のルート
Route::post('/admin/register', [App\Http\Controllers\AdminController::class, 'register'])->name('admin.register');

Route::get("/home/task_create",[TaskController::class,"create"])->name("tasks.create");

Route::post("/tasks",[TaskController::class,"storeTask"])->name("tasks.store");

Route::get("/home/comment_create",[TaskController::class,"comment"])->name("comments.create");

Route::post("/comments",[TaskController::class,"storeComment"])->name("comment.store");

Route::post('/tasks/{task}/images', [TaskController::class, 'storeImage'])->name('tasks.storeImage');

// コメント編集ページのルート
Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');

// コメント更新処理のルート
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

// タスクの詳細表示のルート
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

// タスク編集ページへのルート
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

// タスク更新処理のルート
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

//タスク削除
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
