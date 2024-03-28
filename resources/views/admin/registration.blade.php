{{-- resources\views\admin\registration.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
</head>
<body>
    <div class="container">
        <h1>管理者用ユーザー登録フォーム</h1>
        
        {{-- エラーメッセージの表示 --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ユーザー登録フォーム --}}
        <form action="{{ route('admin.register') }}" method="POST">
        @csrf <!-- CSRFトークン -->

        <div class="form-group">
            <label for="role">先生か生徒かを入力してください:</label>
            <select id="role" name="role" required class="form-control">
                <option value="teacher">先生</option>
                <option value="student">生徒</option>
            </select>
        </div>
        
        <div class="form-group">
          <label for="name">名前:</label>
          <input type="text" id="name" name="name" required class="form-control" placeholder="名前を入力してください">
      </div>

      <div class="form-group">
          <label for="email">メールアドレス:</label>
          <input type="email" id="email" name="email" required class="form-control" placeholder="メールアドレスを入力してください">
      </div>

      <div class="form-group">
          <label for="password">パスワード:</label>
          <input type="password" id="password" name="password" required class="form-control" placeholder="パスワードを入力してください">
      </div>

      <div class="form-group">
          <label for="password_confirmation">パスワード確認:</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control" placeholder="もう一度パスワードを入力してください">
      </div>

      <button type="submit" class="btn btn-primary">登録</button>
  </form>
</div>
</body>
</html>