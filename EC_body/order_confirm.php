<?PHP
session_start();
if(empty($_SESSION['userEmail'])){
  header('Location: http://localhost/EC/EC_body/EC_login.php');
}

//製品詳細から引き継いだ値を変数に格納
$cart=$_SESSION['cart'];
$quantity=$_SESSION['quantity'];
$max=count($cart);

//カートが空の状態の画面を表示
if($max==0)
{
 print 'カートには現在何も入っておりません。<br/>';
 print '<br/>';
 print '<a href="product_list.php">製品一覧画面へ</a>';
 exit();

}

//変数の初期値を設定する


try{
//$cartの中身を順に出していく
foreach($cart as $key => $val){
  $dsn='mysql:dbname=shop;host=localhost';
  $user='root';
  $password='';
  $dbh=new PDO($dsn,$user,$password);
  $dbh->query('SET NAMES utf8');
  //$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $userEmail=$_SESSION['userEmail'];
  $userName=$_SESSION['userName'];
  $sql='SELECT id,name,price,picture,introduction FROM product WHERE id =?';
  $stmt=$dbh->prepare($sql);//SQL文。
  $data[0]=$val;
  $stmt->execute($data);//SQL文。STMTに結果データを入れる。
  $rec=$stmt->fetch(PDO::FETCH_ASSOC);//ループ内容。レコードの取り出しを示す。
  //取り出した値を変数に入れる。
  $id[]=$rec['id'];
  $name[]=$rec['name'];
  $price[]=$rec['price'];
  $introduction[]=$rec['introduction'];
  $picture[]='<img src="../product_regist/picture/'.$rec['picture'].'"width="200" height="200">';

  //userテーブルから会員情報の取り出し
  $sql="SELECT id,name,address,email,card_number FROM user WHERE name = '$userName' AND email = '$userEmail'";
  $stmt=$dbh->prepare($sql);//SQL文。
  $stmt->execute();//SQL文。STMTに結果データを入れる。
  $user_rec=$stmt->fetch(PDO::FETCH_ASSOC);//ループ内容。レコードの取り出しを示す。
  $user_id=$user_rec['id'];
  $user_name=$user_rec['name'];
  $user_address=$user_rec['address'];
  $user_email=$user_rec['email'];
  $user_card_number=$user_rec['card_number'];



  }

}//tryの終わり

catch (PDOException $e){
echo $e->getMessage();
echo 'カートの情報が表示できていません';
exit();
}

//戻るボタンが押された際の処理
if(isset($_POST['back_cart'])){
unset($_SESSION['shipping_address']);
header('Location: http://localhost/EC/EC_body/cart.php');
   exit();
  }

//userテーブルのIDをorderテーブルに入れる。
if(isset($_POST['complete'])){
  //SESSION['shipping_addressに値がある場合はそちらを、ない場合はユーザーテーブルの値を入れる。']
  if(isset($_SESSION['shipping_address'])){
    $user_address=$_SESSION['shipping_address'];
  }else{
      $_SESSION['shipping_address']=$user_address;
    }

  $sql='INSERT INTO user_order(user_id,shipping_address)VALUES("'.$user_id.'","'.$user_address.'")';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();

//最後に入れたIDの値を取り出す
  $sql='SELECT LAST_INSERT_ID()';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();
  $last_rec=$stmt->fetch(PDO::FETCH_ASSOC);
  $last_code=$last_rec['LAST_INSERT_ID()'];

//order＿detailテーブルにユーザーのIDと数量と製品のIDを入れる。
  for($i=0;$i<$max;$i++)
  {
  $sql='INSERT INTO user_order_detail(user_order_id,product_id,quantity) VALUES(?,?,?)';
  $stmt=$dbh->prepare($sql);
  $data=array();
  $data[]=$last_code;
  $data[]=$cart[$i];
  $data[]=$quantity[$i];
  $stmt->execute($data);
  }
  $dbh=null;
  header('Location: http://localhost/EC/EC_body/order_complete.php');
}


//エラー文に関する設定
$page_flag=0;
$error=array('shipping_address'=>'');

//住所のバリデーション
if(isset($_POST['change_address'])){
  if(empty($_POST['shipping_address'])){
    echo '配送先が空欄です。';
    $error['shipping_address']="配送先が空欄です";
    $page_flag=1;
  }
    elseif(preg_match("/^.{5,100}$/",$_POST['shipping_address'])){
      echo '1.配送先はOK';
      }else{
        echo '1.配送先はだめ';
        $error['shipping_address']="配送先は5文字以上100文字以内で入力してください";
        $page_flag=1;
      }

//バリデーションをすべて通過した際の処理
    if($page_flag==0){
        $_SESSION['shipping_address'] = $_POST['shipping_address'];

          header('Location: http://localhost/EC/EC_body/order_confirm.php');
          exit();
  }
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
<p>ご注文内容をご確認ください。</p>


<h3>購入製品一覧</3>
<table border="1">
  <tr>
    <th>商品名</th><th>写真</th><th>紹介文</th><th>価格</th><th>数量</th><th>合計金額</th>
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
  </tr>
<?php } ?>
</table>

<a>カート全体の合計金額</a>
<p><?php echo $_SESSION['format_total'];?>円</p>
<br/>

<a>配送先住所をご確認ください</a>
<p>
    <?php
        if(isset($_SESSION['shipping_address'])){
            echo '変更後の住所はこちらです';
            echo '<br/>';
            echo $_SESSION['shipping_address'];
          }else{
            echo $user_address;
          }
    ?>
</p>
<br/>
<?PHP
  if($error['shipping_address']==''){
    echo '配送先を変更する場合はこちらにご入力ください。';
  }else{
    echo $error['shipping_address'];
  }
?>
<P><input type = "text" name= "shipping_address"></p>
<P><input type="submit" value="変更する" name='change_address'></p>
<br/>
<a>クレジットカード番号をご確認ください</a>
<p><?php echo $user_card_number; ?></p>
<P><input type="submit" value="戻る" name="back_cart"></p>
<P><input type="submit" value="確定する" name="complete"></p>
</form>
</body>
</html>
