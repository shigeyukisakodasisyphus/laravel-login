<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ホーム画面</title>
  <link rel="stylesheet" href="{{ asset('css/app.css')}}">
</head>
<body>
  <div class="container">
    <div class="mt-5">
    <x-alert type="success" :session="session('success')"/>
    <!-- <x-alert type="success" :session="session('login_success')"/> -->
    <!-- @if (session('login_success'))
      <div class="alert alert-success">
        {{ session('login_success')}}
      </div>
    @endif -->
    <h3>プロフィール</h3>
      <ul>
        <li>名前：{{ Auth::user()->name}}</li>
        <li>メールアドレス：{{ Auth::user()->email}}</li>
      </ul>
      <form action="{{route('logout')}}" method="POST">
      @csrf
        <button class='btn btn-danger'>ログアウト</button>
      </form>
    </div>
  </div>
</body>
</html>