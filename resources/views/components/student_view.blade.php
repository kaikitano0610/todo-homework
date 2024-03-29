<!-- 宿題セクション -->
<section class="task-section">
    <h1>今日の宿題</h1>
    <div class="task-container">
            <hr>
        @foreach($todayTasks as $task)
            <div class="task-item">
                <h2>{{ $task->title }}</h2>
                <!-- 他のタスクの詳細を表示 -->
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