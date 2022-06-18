<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atte</title>
</head>

<body>
  <header class="header">
    <div class="header-ttl">
      <a href="">
        Atte
      </a>
    </div>

    <nav class="header-nav">
      <ul class="header-nav-list">
        <li class="header-nav-item"><a href="">ホーム</a></li>
        <li class="header-nav-item"><a href="">日付一覧</a></li>
        <li class="header-nav-item"><a href="">ログアウト</a></li>
      </ul>
    </nav>
  </header>

  <main class="attendance-main">
    <form action="/start" class="time_add" method="POST">
      @csrf
      <input type="submit" class="punch-in" value="勤務開始">
    </form>
  </main>

  <form action="/end" class="time_add" method="POST">
    @csrf
    <input type="submit" class="punch-out" value="勤務終了">
  </form>

  <form method="POST" action="{{ route('logout') }}">
    @csrf

    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
      {{ __('Log Out') }}
    </button>
  </form>
  
  </main>

  <footer class="attendance-footer">
    <small class="copylight">
      <p>Atte,inc</p>
    </small>
  </footer>
</body>

</html>