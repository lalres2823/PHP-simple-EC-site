<?php
session_start();
if(!$_SESSION){
  header('Location: ./product_register.php');
  }

if(isset($_POST['back_home'])){
  header('Location: http://localhost/EC/product_regist/product_register.php');
  exit();
  }
?>

<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>EC会員登録完了画面</title>
</head>
<body>
  <form method = "post" action = "">
    <p>商品登録が完了しました</p>
    <p><input type="submit" 'value'="submit" name = "complete">買い物画面へ進む</P>
  </form>
  <form method = "post" action = "">
    <p><input type="submit" 'value'="back" name="back_home">製品登録のトップページに戻る</p>
  </form>
  </body>
</html>
