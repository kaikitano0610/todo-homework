@extends('layouts.app')
@section("content")
  <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route("tasks.store") }}" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="form-group">
                    <label>タイトル</label>
                    <input type="text" class="form-control" placeholder="宿題のタイトルを入力して下さい" name="title">
                </div>
                <div class="form-group">
                    <label>内容</label>
                    <textarea class="form-control" placeholder="宿題の内容や詳細を入力してください。" rows="5" name="contents"></textarea>
                </div>
                <div class="form-group">
                    <label>締切日</label>
                    <input type="date" class="form-control" name="due_date">
                </div>                
                @csrf
                <input type="file" name="image">
                <div><button type="submit" class="btn btn-primary">作成</button></div>
                
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