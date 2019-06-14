<?php
session_start();
if(!$_SESSION){
  header('Location: ./user_register.php');
}

if(isset($_POST['confirm'])){
  try{
  $dsn='mysql:dbname=shop;host=localhost';
  $user='root';
  $password='';
  $dbh=new PDO($dsn,$user,$password);
  $dbh->query('SET NAMES utf8');
  //DBへ挿入
  $sql='INSERT INTO user(name,address,email,password,card_number)
    VALUES("'.$_SESSION['name'].'","'.$_SESSION['address'].'","'.$_SESSION['email'].'","'.$_SESSION['pass1'].'","'.$_SESSION['card_number'].'")';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();
  $dbh=null;
  header('Location: http://localhost/EC/user_regist/user_complete.php');
  exit();
  }catch(PDOException $e){
    echo 'データベースにアクセスできません'.$e->getMessage();
    exit();
  }
}


?>


<!-- ここからHTML -->
<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>EC会員登録確認画面</title>
</head>
<body>
  <form method = "post" action = "">
    <span class="navbar-text">ようこそ！<?=$_SESSION['name']?> 様</span>
    <p>名前は、<?=$_SESSION['name']?></p>
    <p>住所は、<?=$_SESSION['address']?></p>
    <p>メールアドレスは、<?=$_SESSION['email']?></p>
    <p>パスワードは、<?=$_SESSION['pass1']?></p>
    <p>入力したメールアドレスは、<?=$_SESSION['email']?></p>
    <p>クレジットカード番号は、<?=$_SESSION['card_number']?> です。</p>
    <p><input type="submit" value="submit" name = "confirm"></P>
  </form>
    <p><button type="button" onclick="history.back()">戻る</button></p>
  </body>
</html>
