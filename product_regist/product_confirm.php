<?php
session_start();
if(!$_SESSION){
  header('Location: ./product_register.php');
}
echo $_SESSION['files_name'];
echo 'これはファイル名です';

if(isset($_POST['confirm'])){
  try{
  $dsn='mysql:dbname=shop;host=localhost';
  $user='root';
  $password='';
  $dbh=new PDO($dsn,$user,$password);
  $dbh->query('SET NAMES utf8');
  //DBへ挿入
  $sql='INSERT INTO product(name,picture,introduction,price)
    VALUES("'.$_SESSION['name'].'","'.$_SESSION['files_name'].'","'.$_SESSION['introduction'].'","'.$_SESSION['price'].'")';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();
  $dbh=null;
  header('Location: http://localhost/EC/product_regist/product_complete.php');
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
<title>EC製品登録確認画面</title>
</head>
<body>
  <form method = "post" action = "">
    <p>名前：<?=$_SESSION['name']?></p>
    <p>画像：<img src="<?php echo 'picture/'.$_SESSION['files_name'];?>"></p>
    <p>紹介文：<?=$_SESSION['introduction']?></p>
    <p>価格：<?=$_SESSION['price']?>円</p>
    <p><input type="submit" value="submit" name = "confirm"></P>
  </form>
    <p><button type="button" onclick="history.back()">戻る</button></p>
  </body>
</html>
