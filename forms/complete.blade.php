<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHP基礎</title>
</head>
  <body>
    <span class="navbar-text">ようこそ！{{$hiddenName}}様</span>
    <span class="navbar-text">性別：{{$hiddenGender}}</span>
    <span class="navbar-text">メールアドレス：{{$hiddenEmail}}</span>
    <span class="navbar-text">問い合わせ内容：{{$hiddenBody}}</span>
    <br>
    登録が完了しました。

    <form method = "post" action = "complete">
      @csrf
      <p><input type="submit" value="back" name="complete"></p>
    </form>

</body>
</html>
