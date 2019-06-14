<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>confirm</title>
</head>
<body>
  <form method = "post" action = "confirm">
    @csrf
    <span class="navbar-text">ようこそ！　{{ Session::get('subname') }} 様</span>
    <p>入力した名前は、{{$data1['name']}}</p>
    <p>選択した性別は、{{$data1['gender']}}</p>
    <p>入力したメールアドレスは、{{$data1['email']}}</p>
    <p>入力した問い合わせ内容は、{{$data1['body']}} です。</p>
    <p><input type="submit" value="submit" name = "confirm"></P>
       <input type="hidden" value="<?= $data1['name']?>" name = "hiddenName">
       <input type="hidden" value="<?= $data1['gender']?>" name = "hiddenGender">
       <input type="hidden" value="<?= $data1['email']?>" name = "hiddenEmail">
       <input type="hidden" value="<?= $data1['body']?>" name = "hiddenBody">
    <p><input type="submit" value="back" name="confirm"></p>
  </form>
  <p><button type="button" onclick="history.back()">戻る</button></p>
  </body>
</html>
