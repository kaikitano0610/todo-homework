<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // User モデルをインポート
use Illuminate\Support\Facades\Hash; // Hash ファサードをインポート

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.registration');
    }

    public function register(Request $request)
    {
    // バリデーションルールを定義
    $validatedData = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'role' => ['required', 'in:teacher,student'], 
    ]);

    // ユーザーを作成
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'role' => $validatedData['role'], // バリデーション後のデータからroleを取得して保存
    ]);

    // 登録後の処理（例: 管理者ページにリダイレクト）
    return redirect()->route('admin')->with('success', 'User registered successfully');
}}
