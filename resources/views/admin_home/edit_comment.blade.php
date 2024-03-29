@extends('layouts.app')

@section('content')
<div class="container">
    <h1>コメントを編集する</h1>
    
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('comments.update', $comment->id) }}" method="post">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="content">コメント</label>
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ $comment->content }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">コメントを更新する</button>
    </form>
</div>
@endsection
