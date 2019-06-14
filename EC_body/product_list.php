<?PHP
session_start();
if(empty($_SESSION['userEmail'])){
  header('Location: http://localhost/EC/EC_body/EC_login.php');
}


//ログアウトを押した際の処理
if(isset($_POST['logout'])){
  $_SESSION=array();
  if(isset($_COOKIE[session_name()])==true)
  {
    setcookie(session_name(),'',time()-42000,'/');
  }
  session_destroy();
  header('Location: http://localhost/EC/EC_body/EC_login.php');
  exit();
}


$dsn='mysql:dbname=shop;host=localhost';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');
$sql='SELECT*FROM product WHERE 1';//SQL文。すべてのデータを取り出し。
$stmt=$dbh->prepare($sql);//SQL文。
$stmt->execute();//SQL文。STMTに結果データを入れる。
?>

<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHP基礎</title>
</head>
<body>
<p>こんにちは！<?php echo $_SESSION['userName']?>様！</p>

<form method = "POST" action = "">
<P><input type="submit" value="ログアウト" name="logout"></p>
</form>

<h3>製品一覧</3>
<table border="1">
  <tr>
    <th>商品名</th><th>写真</th><th>紹介文</th><th>価格</th><th>商品詳細</th>
  </tr>
<?php while(1)//ループ命令
{
  $rec=$stmt->fetch(PDO::FETCH_ASSOC);//ループ内容。レコードの取り出しを示す。
  if($rec==false)
  {
    break;
  }
  $rec['price']=number_format($rec['price']);
  ?>

  <tr>
    <td><?php echo $rec['name']; ?></td>
    <td><img src="<?php echo '../product_regist/picture/'.$rec['picture'];?>"width="200" height="200"></td>
    <td><?php echo $rec['introduction']; ?></td>
    <td><?php echo $rec['price']; ?>円</td>
    <td>
      <form method = 'post' action ='product_detail.php'>
      <P><input type="submit" value="詳細" name="detail"></p>
         <input type="hidden" value="<?=$rec['id']?>" name="hiddenId">
         <input type="hidden" value="<?=$rec['name']?>" name="hiddenName">
         <input type="hidden" value="<?=$rec['picture']?>" name="hiddenPicture">
         <input type="hidden" value="<?=$rec['introduction']?>" name="hiddenIntroduction">
         <input type="hidden" value="<?=$rec['price']?>" name="hiddenPrice">
      </form>
    </td>
  </tr>
<?php } ?>
</table>

<form method = "POST" action = "cart.php">
<P><input type="submit" value="カートの中身を確認する" name="cart_contents"></p>
</form>

<?php $dbh=null;?>

</body>
</html>
