@extends('layouts.app')

@section('content')
<div class="container">
    <h1>タスク編集</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- 各フォーム要素に現在のタスクの値を設定 --}}
        <div class="form-group">
            <label>タイトル</label>
            <input type="text" class="form-control" name="title" value="{{ $task->title }}">
        </div>
        <div class="form-group">
            <label>内容</label>
            <textarea class="form-control" rows="5" name="contents">{{ $task->contents }}</textarea>
        </div>
        <div class="form-group">
            <label>締切日</label>
            <input type="date" class="form-control" name="due_date" value="{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label>画像（追加する場合）</label>
          <input type="file" name="images[]" multiple>
          {{-- 既存の画像を表示し、削除オプションを提供 --}}
          @foreach($task->images as $image)
              <div>
                  <img src="{{ Storage::url($image->path) }}" width="100">
                  {{-- 画像削除のためのチェックボックスやボタンをここに配置 --}}
              </div>
          @endforeach
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection
