@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- ユーザーのroleに基づいたメッセージを表示 --}}
                    @if(Auth::user()->role === 'teacher')
                        <p>{{ __('Welcome, Teacher! Here you can manage tasks.') }}</p>
                        {{-- 先生専用のコンポーネントを表示 --}}
                        <x-teacher_view 
                        :todayTasks="$todayTasks" 
                        :todayComments="$todayComments"
                        :futureTasks="$futureTasks" />

                    @elseif(Auth::user()->role === 'student')
                        <p>{{ __('Welcome, Student! Here you can view your tasks.') }}</p>
                        {{-- 生徒専用の情報を表示 --}}
                        <x-student_view
                        :todayTasks="$todayTasks" 
                        :todayComments="$todayComments"
                        :futureTasks="$futureTasks"
                        :completedTasksCount="$completedTasksCount"
                        :incompleteTasksCount="$incompleteTasksCount" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
