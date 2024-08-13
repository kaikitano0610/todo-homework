@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $task->title }}</h1>
    <p>{{ $task->contents }}</p>
    <p>締切日: {{ \Carbon\Carbon::parse($task->due_date)->format('Y/m/d') }}</p>
    {{-- 画像がある場合は表示 --}}
    @if($task->image)
      @foreach($task->images as $image)
         <img src="{{ Storage::url($image->path) }}" alt="Task Image">
       @endforeach
    @endif
    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">編集</a>
    <a href="{{ route('home', $task->id) }}" class="btn btn-secondary">ホームに戻る</a>
</div>
@endsection
