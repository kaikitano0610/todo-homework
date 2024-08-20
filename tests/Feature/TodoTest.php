<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Comment;


class TodoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_todo_status(): void
    {
        //ログインしなくても見れる確認
        // トップページ
        $response = $this->get('/');
        $response->assertStatus(200);

        // ログインページ
        $response = $this->get('/login');
        $response->assertStatus(200);

        // 登録ページ
        $response = $this->get('/register');
        $response->assertStatus(200);


        //ログインしないと入れない状態である確認
        // ホームページ
        $response = $this->get('/home');
        $response->assertStatus(302);

        // タスク作成ページ
        $response = $this->get('/home/task_create');
        $response->assertStatus(302);

        // コメント作成ページ
        $response = $this->get('/home/comment_create');
        $response->assertStatus(302);
    }

    //ユーザーを作成して、ログイン後のページを表示
    public function test_show(): void
    {
        // ユーザーの作成
        $user = User::factory()->create();
        //ホームを表示
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);

        //タスクの作成ページを表示
        $response = $this->get('/home/task_create');
        $response->assertStatus(200);

        //コメント作成ページの表示
        $response = $this->get("/home/comment_create");
        $response->assertStatus(200);


        //テストユーザー削除
        User::where('id', $user->id)->delete();
    }

    //ログイン後、タスクとコメントを追加
    public function test_task_create(): void
    {
        // ユーザーの作成
        $user = User::factory()->create();

        //ユーザーでログイン
        $this->actingAs($user);

        //タスクの作成ページを表示
        $response = $this->get('/home/task_create');
        $response->assertStatus(200);

        //タスクの作成（宿題追加）
        $response = $this->actingAs($user)->post('/tasks', [
            '_token' => csrf_token(),
            'title' => '社会',
            'contents' => '地図帳で福岡県を確認',
            'due_date' => '2024-08-19',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/home");

        //タスクをデータベースに保存できるか
        $this->assertDatabaseHas('tasks', [
            'title' => '社会',
            'contents' => '地図帳で福岡県を確認',
            'due_date' => '2024-08-19',
            'user_id' => $user->id
        ]);

        //コメントの作成
        $response = $this->actingAs($user)->post('/comments', [
            '_token' => csrf_token(),
            'content' => '今日も一日頑張りました',
        ]);

        //コメントをデータベースに保存できるか
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'content' => '今日も一日頑張りました',
        ]);

        //テストコメント削除
        Comment::where('user_id', $user->id)->delete();

        // テスト投稿削除
        Task::where('user_id', $user->id)->delete();
        //テストユーザー削除
        User::where('id', $user->id)->delete();
    }

    //ログイン後、タスクとコメントを変更
    public function test_task_edit(): void
    {
        // ユーザーの作成
        $user = User::factory()->create();

        //ユーザーでログイン
        $this->actingAs($user);

        //タスクの作成（宿題追加）
        $response = $this->actingAs($user)->post('/tasks', [
            '_token' => csrf_token(),
            'title' => '社会',
            'contents' => '地図帳で福岡県を確認',
            'due_date' => '2024-08-19',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/home");

        //投稿したタスクを変更
        $task = Task::where('user_id', $user->id)->first();
        $task_id = $task->id;
        $response = $this->actingAs($user)->put('/tasks/' . $task_id, [
            '_token' => csrf_token(),
            'title' => '社会',
            'contents' => '地図帳で長崎県を確認',
            'due_date' => '2024-08-19',
        ]);

        //変更したデータベースがあるか確認
        $this->assertDatabaseHas('tasks', [
            'title' => '社会',
            'contents' => '地図帳で長崎県を確認',
            'due_date' => '2024-08-19',
            'user_id' => $user->id
        ]);

        //コメントの作成
        $response = $this->actingAs($user)->post('/comments', [
            '_token' => csrf_token(),
            'content' => '今日も一日頑張りました',
        ]);

        //投稿したコメントを変更
        $comment = Comment::where('user_id', $user->id)->first();
        $comment_id = $comment->id;
        $response = $this->actingAs($user)->put('/comments/' . $comment_id , [
            'content' => '明日も頑張りましょう',
        ]);

        //変更したコメントがデータベースにあるか
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'content' => '明日も頑張りましょう',
        ]);

        //テストコメント削除
        Comment::where('user_id', $user->id)->delete();

        // テスト投稿削除
        Task::where('user_id', $user->id)->delete();
        //テストユーザー削除
        User::where('id', $user->id)->delete();
    }

    //テスト投稿を削除する
    public function test_task_delete():void
    {
        // ユーザーの作成
        $user = User::factory()->create();

        //ユーザーでログイン
        $this->actingAs($user);

        //タスクの作成（宿題追加）
        $response = $this->actingAs($user)->post('/tasks', [
            '_token' => csrf_token(),
            'title' => '英語',
            'contents' => '単語帳を覚えてくる',
            'due_date' => '2024-08-20',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/home");

        //タスクを削除
        $task = Task::where('user_id',$user->id)->first();
        $task_id = $task->id;
        $response = $this->actingAs($user)->delete('/tasks/'.$task_id,[
            '_token'=>csrf_token(),
        ]);
        $response->assertStatus(302);
        $response->assertRedirect("/home");

        //削除した投稿がデータベースにないことを確認
        $this->assertDatabaseMissing('tasks',[
            'id'=>$task_id,
            'title' => '英語',
            'contents' => '単語帳を覚えてくる',
            'due_date' => '2024-08-20',
            'user_id' => $user->id
        ]);

        // テスト投稿削除
        Task::where('user_id', $user->id)->delete();
        //テストユーザー削除
        User::where('id', $user->id)->delete();
    }

    public function test_logout():void
    {
        $response = $this->get('/home');
        $response->assertStatus(302);

        //ユーザーを作成してログイン
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertStatus(302);
        $response->assertRedirect('/');

        //ログアウト後に認証されていないことを確認
        $this->assertGuest();

        //テストデータ削除
        User::where('id',$user->id)->delete();
    }


}
