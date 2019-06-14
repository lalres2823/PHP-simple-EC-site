<?php
session_start();
if(empty($_SESSION['userEmail'])){
  header('Location: http://localhost/EC/EC_body/EC_login.php');
}


//postの値があるときのみSESSIONに格納。
if(!empty($_POST['hiddenName'])){
$_SESSION['hiddenId']=$_POST['hiddenId'];
$_SESSION['hiddenName']=$_POST['hiddenName'];
$_SESSION['hiddenPicture']=$_POST['hiddenPicture'];
$_SESSION['hiddenIntroduction']=$_POST['hiddenIntroduction'];
$_SESSION['hiddenPrice']=$_POST['hiddenPrice'];
}else{
  echo "ポストの値がありません.リロードした場合は正常です";
}


//カートへボタンが押された際の処理
if(isset($_POST['go_cart']) && $_POST['quantity'] !== 0){
//購入した製品のIDを配列で追加していく。
$id=$_SESSION['hiddenId'];
if(isset($_SESSION['cart'])==true)
{
  $cart=$_SESSION['cart'];
  $quantity=$_SESSION['quantity'];
  //同じ製品をカートに入れようとした際の処理
  if(in_array($id,$cart)==true){
    print 'その製品は既にカートに入っています。<br/>';
    print '<a href="product_list.php">製品一覧に戻る</a>';
    exit();
  }
  echo 'セッション,数量に初期値あり';
}
$cart[]=$id;
$quantity[]=$_POST['quantity'];
$_SESSION['cart']=$cart;
$_SESSION['quantity']=$quantity;
header('Location: http://localhost/EC/EC_body/product_list.php');
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
<h3>商品の詳細</3>
<table border="1">
  <tr>
    <th>製品コード</th><th>商品名</th><th>写真</th><th>紹介文</th><th>価格</th><th>数量</th><th>購入</th>
  </tr>
<form method="post" action="" >
  <tr>
  <td><?php echo $_SESSION['hiddenId']; ?></td>
  <td><?php echo $_SESSION['hiddenName']; ?></td>
  <td><img src="<?php echo '../product_regist/picture/'.$_SESSION['hiddenPicture'];?>"width="400" height="400"></td>
  <td><?php echo $_SESSION['hiddenIntroduction']; ?></td>
  <td><?php echo $_SESSION['hiddenPrice']; ?></td>
  <td>
    <select name="quantity">
      <?php
        for ($i = 0; $i <= 9; $i++) {
            echo "<option>$i</option>";
            }
            ?>
    </select>
  </td>
  <td>
  <input type="submit" name="go_cart" value="カートへ">
</form>
  </td>
  </tr>
</table>
<br>
<a href="product_list.php"><button type="button" name="back_home">戻る</button></a>
<br>
<form method = "post" action='delete_confirm.php'>
<p><button type="submit" value="削除する" name="delete" >削除する</button></p>

</form>
</body>
</html>
