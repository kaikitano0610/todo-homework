<!-- 宿題セクション -->
<section class="task-section">
    <h1>今日の宿題</h1>
    <div class="task-container">
            <hr>
        @foreach($todayTasks as $task)
            <div class="task-item">
                <h2>{{ $task->title }}</h2>
                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary">クリア</a>
              <form action ="{{ route('tasks.destroy', $task->id) }}"method="post">
                @csrf
                @method("delete")
                <button type="submit" value="削除" class="btn btn-secondary" onclick='return confirm("本当に削除しますか？");'>詳細をみる</button>
            </div>
            <hr>
        @endforeach
    </div>
  </section>
  
  <!-- コメントセクション -->
  <section class="comment-section">
    <h1>先生からのコメント</h1>
    @if($todayComments)
      <div class="comment-box">
          <p>{{ $todayComments->content }}</p> <!-- コメントの内容を表示 -->
      </div>
    @else
      <div class="no-comment-box">
          <p>まだコメントがありません。</p>
      </div>
    @endif
  
    
  </section>
  
    </div>
  </section>