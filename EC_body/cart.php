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

//製品詳細から引き継いだ値を変数に格納
if(isset($_SESSION['cart']))
{
$cart=$_SESSION['cart'];
$quantity=$_SESSION['quantity'];
$max=count($cart);
}else {
$max=0;
      }

//カートが空の状態の画面を表示
if($max==0)
{
 print 'カートには現在何も入っておりません。<br/>';
 print '<br/>';
 print '<a href="product_list.php">製品一覧画面へ</a>';
 exit();

}

//削除ボタンを押した際の処理
for($i=$max;0<=$i;$i--){
  if(isset($_POST['delete'.$i])==true){
    array_splice($cart,$i,1);
    array_splice($quantity,$i,1);
    $_SESSION['cart']=$cart;
    $_SESSION['quantity']=$quantity;
    header('Location: http://localhost/EC/EC_body/cart.php');
  }
}


try{
$dsn='mysql:dbname=shop;host=localhost';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');
//$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//$cartの中身を順に出していく
foreach($cart as $key => $val){
  $sql='SELECT id,name,price,picture,introduction FROM product WHERE id =?';
  $stmt=$dbh->prepare($sql);//SQL文。
  $data[0]=$val;
  $stmt->execute($data);//SQL文。STMTに結果データを入れる。

  $rec=$stmt->fetch(PDO::FETCH_ASSOC);//ループ内容。レコードの取り出しを示す。
  $name[]=$rec['name'];
  $price[]=$rec['price'];
  $introduction[]=$rec['introduction'];
  $picture[]='<img src="../product_regist/picture/'.$rec['picture'].'"width="200" height="200">';
  }
  $dbh=null;

}//tryの終わり

catch (PDOException $e){
echo $e->getMessage();
echo 'パスワードが違います。';
exit();
}
?>


<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHP基礎</title>
</head>
<body>
<p>こんにちは！<?php echo $_SESSION['userName']?>様！</p>
<p>こちらは現在あなたのカートに入っている商品一覧です。</p>

<form method = "POST" action = "">
<P><input type="submit" value="ログアウト" name="logout"></p>
</form>

<h3>製品一覧</3>
<table border="1">
  <tr>
    <th>商品名</th><th>写真</th><th>紹介文</th><th>価格</th><th>数量</th><th>小計金額</th><th>削除する</th>
  </tr>
<form method="post" action="">
<?php for($i=0;$i<$max;$i++){ ?>
  <tr>
    <td><?php echo $name[$i]; ?></td>
    <td><?php echo $picture[$i];?></td>
    <td><?php echo $introduction[$i]; ?></td>
    <td><?php echo number_format($price[$i]); ?>円</td>
    <td><?php echo $quantity[$i]; ?>個</td>
    <td><?php echo number_format($price[$i]*$quantity[$i]); ?>円</td>
    <?php $total[] = $price[$i]*$quantity[$i];?>
    <td>
      <P><input type="checkbox" value="削除" name="delete<?php print $i;?>"></p>
    </td>

  </tr>
<?php } ?>
</table>
<br/>
<a>カート全体の合計金額</a>
<?php $format_total=number_format(array_sum($total));
$_SESSION['format_total']=$format_total;?>
<p><?php echo $_SESSION['format_total'];?>円</p>


<?php $_SESSION['total']=array_sum($total);?>
<br/>
<a href="product_list.php"><button type="button" name="back_home">戻る</button></a>
<br/>
<br/>
<input type="submit" value="削除"><br/>
<br>
<a href="order_confirm.php">購入手続きに進む</a><br/>
</form>

</body>
</html>
