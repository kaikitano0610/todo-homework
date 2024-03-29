@extends('layouts.app')
@section("content")
  <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route("comment.store") }}" method="POST">
                @csrf 
                <div class="form-group">
                    <label>コメント</label>
                    <textarea class="form-control" placeholder="コメントを登録してください。" rows="6" name="content"></textarea>
                </div>
                {{-- <input type="hidden" name="task_id" value="{{ $taskId }}"> --}}
                <button type="submit" class="btn btn-primary">投稿</button>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
  </div>
 @endsection