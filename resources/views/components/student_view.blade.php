<head>
  <!-- その他のメタタグやスタイルシートリンク -->
  <style>
    .graph-container {
      width: 40%; /* グラフのコンテナの幅を指定 */
      height: auto; /* 高さを自動調節 */
      margin: 0 auto; /* 中央揃え */
      margin: 20px;
    }
    </style>
  <!-- Chart.jsのCDNを追加 -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>


<!-- 宿題セクション -->
  <section class="task-section">
    <h1>今日の宿題</h1>
    <div class="task-status">
      <p>{{ $completedTasksCount }}/{{ $todayTasks->count() }} クリア</p>
    </div>

     <!-- グラフのキャンバスを追加 -->
     <div class="graph-container">
      <canvas id="taskProgressChart"></canvas>
    </div>
    

    <div class="task-container">
            <hr>
        @foreach($todayTasks as $task)
            {{-- ログインしているユーザーに関連するタスクユーザーのレコードを取得 --}}
            @php
            $userTask = $task->taskUsers->firstWhere('user_id', Auth::id());
            @endphp

              <div class="task-item" >

                <h2 @if(optional($task->taskUsers->first())->status == 'completed') style="text-decoration: line-through;" @endif>
                  {{ $task->title }}
                  {{ $task->due_date }}
                </h2>
                <div style="display: flex; align-items: center;">
                  @if(optional($userTask)->status == 'completed')
                  <form action="{{ route('tasks.undo', $task->id) }}" method="post">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="btn btn-info">元に戻す</button>
                  </form>
                  @else
                      <form action="{{ route('tasks.clear', $task->id) }}" method="post">
                          @csrf
                          @method('PUT')
                          <button type="submit" class="btn btn-primary">クリア</button>
                      </form>
                  @endif
              
                  <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-secondary">詳細をみる</a>
                </div>


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
<!-- 宿題セクション -->
<section class="task-section">
  <h1>今後の宿題</h1>
  <div class="task-container">
          <hr>
      @foreach($futureTasks as $task)
          {{-- ログインしているユーザーに関連するタスクユーザーのレコードを取得 --}}
          @php
          $userTask = $task->taskUsers->firstWhere('user_id', Auth::id());
          @endphp

            <div class="task-item">
              <h2 @if(optional($task->taskUsers->first())->status == 'completed') style="text-decoration: line-through;" @endif>
                {{ $task->title }}
                {{ $task->due_date }}
              </h2>
              <div style="display: flex; align-items: center;">
                @if(optional($userTask)->status == 'completed')
                <form action="{{ route('tasks.undo', $task->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-info">元に戻す</button>
                </form>
                @else
                    <form action="{{ route('tasks.clear', $task->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary">クリア</button>
                    </form>
                @endif
            
                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-secondary">詳細をみる</a>
              </div>
          </div>
          <hr>
      @endforeach
  </div>
</section>

<script>
  // DOMが完全に読み込まれた後に実行するためのイベントリスナー
  document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('taskProgressChart').getContext('2d');
    var taskProgressChart = new Chart(ctx, {
        type: 'doughnut', // または 'pie' などのグラフタイプ
        data: {
            labels: ['完了', '未完了'],
            datasets: [{
                label: '宿題の進捗',
                data: [@json($completedTasksCount), @json($incompleteTasksCount)],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // キャンバスの親要素に合わせて高さを調節
            responsive: true, // レスポンシブデザインを有効にする
            legend: {
                position: 'top', // 凡例の位置
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
  });
</script>