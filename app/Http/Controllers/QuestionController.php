<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer',
            'content' => 'required|string',
        ]);

        $question = new Question();
        $question->task_id = $request->task_id;
        $question->content = $request->content;
        $question->user_id = auth()->id(); // 質問者（ログインユーザー）のIDを設定
        $question->save();

        return back()->with('success', '質問が送信されました！');
    }
}
