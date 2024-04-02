@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $task->title }}</h1>
    <p>{{ $task->contents }}</p>
    <p>締切日: {{ \Carbon\Carbon::parse($task->due_date)->format('Y/m/d') }}</p>
    {{-- 画像がある場合は表示 --}}
    @if($task->images)
        @foreach($task->images as $image)
            <img src="{{ Storage::url($image->path) }}" alt="Task Image" style="width:100%;max-width:400px;">
        @endforeach
    @endif
    <div>
      <a href="{{ route('home') }}" class="btn btn-secondary">ホームに戻る</a>
    </div>
    <br>

    {{-- 質問フォーム --}}
    <form method="POST" action="{{ route('questions.store') }}">
        @csrf
        <input type="hidden" name="task_id" value="{{ $task->id }}">
        <div class="form-group">
            <label for="content">質問を投稿する:</label>
            <textarea name="content" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">質問を送信</button>
    </form>

    {{-- 既存の質問を表示 --}}
    @foreach($task->questions as $question)
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">{{ $question->user->name }}からの質問</h5>
                <p class="card-text">{{ $question->content }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection
