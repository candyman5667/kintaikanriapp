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
        <li class="header-nav-item"><a href="{{route('signout')}}">ログアウト</a></li>
      </ul>
    </nav>
  </header>

  <main class="attendance-main">
    {{-- <p>{{ $msg }}</p> --}}
    <p>{{ Auth::user()->name }}さんお疲れ様です！</p>
    <form action="/start" class="time_add" method="POST">
      @csrf
      @php
      var_dump(isset($is_attendance_start));
      var_dump(isset($is_attendance_end));
      var_dump(isset($is_rest_start));
      var_dump(isset($is_rest_end));
      @endphp
      @if (isset($is_attendance_start))
      <button type="submit" id="b1">勤務開始</button>
      @else
      <button type="submit" id="b1" disabled>勤務開始</button>
      @endif
    </form>

    <form action="/end" class="time_add" method="POST">
      @csrf
      @if (!isset($is_attendance_end))
      <button type="submit" id="b2">勤務終了</button>
      @else
      <button type="submit" id="b2" disabled>勤務終了</button>
      @endif
    </form>

    <form action="/rest_start" class="time_add" method="POST">
      @csrf
      @if (!isset($is_rest_start))
      <button type="submit" id="b3">休憩開始</button>
      @else
      <button type="submit" id="b3" disabled>休憩開始</button>
      @endif
    </form>

    <form action="/rest_end" class="time_add" method="POST">
      @csrf
      @if (isset($is_rest_end))
      <button type="submit" id="b4">休憩終了</button>
      @else
      <button type="submit" id="b4" disablee >休憩終了</button>
      @endif
    </form>

  </main>

  <footer class="attendance-footer">
    <small class="copylight">
      <p>Atte,inc</p>
    </small>
  </footer>
  <!--
  <script>
    function func1() {

      if (document.getElementById("b1").disabled === true) {
        // disabled属性を削除
        document.getElementById("b1").removeAttribute("disabled");
        document.getElementById("b1").style.color = "black";
      } else {
        // disabled属性を設定
        document.getElementById("b1").setAttribute("disabled", true);
        document.getElementById("b1").style.color = "White";
      }
    }
  </script>
  -->
</body>

</html>