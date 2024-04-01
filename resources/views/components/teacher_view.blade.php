 <!-- 宿題セクション -->
<section class="task-section">
  <h1>宿題登録</h1>
  <div class="task-container">
          <hr>
      @foreach($todayTasks as $task)
          <div class="task-item">
              <h2>{{ $task->title }}</h2>
              <!-- 他のタスクの詳細を表示 -->
          </div>
          <div style="display: flex; align-items: center;">
              <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary">詳細へ</a>
              <form action ="{{ route('tasks.destroy', $task->id) }}"method="post">
                @csrf
                @method("delete")
                <button type="submit" value="削除" class="btn btn-secondary" onclick='return confirm("本当に削除しますか？");'>削除する</button>
          </div>
          <hr>
      @endforeach
  </div>
  <a href="{{ route('tasks.create') }}" class="btn-register-task">宿題を登録する</a>
</section>

<!-- コメントセクション -->
<section class="comment-section">
  <h1>コメント</h1>
  @if($todayComments)
    <div class="comment-box">
        <p>{{ $todayComments->content }}</p> <!-- コメントの内容を表示 -->
        <a href="{{ route('comments.edit', $todayComments->id) }}" class="btn btn-primary">コメントを編集する</a>
    </div>
  @else
    <div class="no-comment-box">
        <p>まだコメントがありません。</p>
        <a href="{{ route('comments.create') }}" class="btn btn-primary">コメントを登録する</a>
    </div>
  @endif

  
</section>

<!-- 質問セクション -->
<section class="question-section">
  <h1>質問の一覧</h1>
  <div class="question-container">
      <div class="question-item">
          <h2>算数のドリル</h2>
          <p>39ページの問2の式の作り方が分かりません。</p>
      </div>
      <!-- 他の質問項目もここに表示 -->
  </div>
</section>