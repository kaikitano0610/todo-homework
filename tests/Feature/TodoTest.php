<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Todo;
use Illuminate\Support\Facades\Hash;

class TodoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_todo_status(): void
    {
        // トップページ
        $response = $this->get('/');
        $response->assertStatus(200);

        // ログインページ
        $response = $this->get('/login');
        $response->assertStatus(200);

        // 登録ページ
        $response = $this->get('/register');
        $response->assertStatus(200);

        // パスワードリセットページ
        $response = $this->get('/password/reset');
        $response->assertStatus(200);

        //ログインしないと入れない状態である確認
        // ホームページ
        $response = $this->get('/home');
        $response->assertStatus(302); // リダイレクトされる

        // タスク作成ページ
        $response = $this->get('/home/task_create');
        $response->assertStatus(302); // リダイレクトされる

        // コメント作成ページ
        $response = $this->get('/home/comment_create');
        $response->assertStatus(302); // リダイレクトされる

        // テストユーザーを作成
        $user = User::factory()->create();

        // テストユーザーでログイン
        $this->actingAs($user);

        // ホームページ
        $response = $this->get('/home');
        $response->assertStatus(200);

        // タスク作成ページ
        $response = $this->get('/home/task_create');
        $response->assertStatus(200);

        // コメント作成ページ
        $response = $this->get('/home/comment_create');
        $response->assertStatus(200);
    }
}
