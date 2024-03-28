 <!-- 宿題セクション -->
<section class="task-section">
  <h1>宿題登録</h1>
  <div class="task-container">
      <!-- ここに宿題が動的に表示されます -->
  </div>
  {{-- <a href="{{ route('tasks.create') }}" class="btn-register-task">宿題を登録する</a> --}}
</section>

<!-- コメントセクション -->
<section class="comment-section">
  <h1>コメント</h1>
  <div class="comment-container">
      <!-- ここにコメントが動的に表示されます -->
  </div>
  {{-- <a href="{{ route('comments.create') }}" class="btn-register-comment">コメントを登録する</a> --}}
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