<?PHP
session_start();
if(empty($_SESSION['userEmail'])){
  header('Location: http://localhost/EC/EC_body/EC_login.php');
}
//変数cartは選んだ製品のidを表す
$cart=$_SESSION['cart'];
$quantity=$_SESSION['quantity'];
$max=count($cart);

if($max==0)
{
 print 'カートには現在何も入っておりません。<br/>';
 print '<br/>';
 print '<a href="product_list.php">製品一覧画面へ</a>';
 exit();

}

//DBから注文情報を取り出す。

  $dsn='mysql:dbname=shop;host=localhost';
  $user='root';
  $password='';
  $dbh=new PDO($dsn,$user,$password);
  $dbh->query('SET NAMES utf8');


//メールの設定と送信内容
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to      = 'yoshikawa180@gmail.com';
$subject = 'ご注文商品';
//ここからメッセージ本文
$message = '';

$message .=$_SESSION['userName']."様\n\nこの度はご注文いただきありがとうございました\n";
$message .=
"\n"
."====================================\n"
."■送信日付:  ".date('Y-m-d H:i:s')."\n"
."■ご注文商品：\n";
// ."              {$product_price}円\n"
// ."              {$product_quantity}個\n"
// ."              小計{$subtotal}円。\n"
// ."              　　　　　　　　　　　\n"
// ."              　　　　　　　　　　　\n"
// ."              ありがとうございました。\n"
// ."====================================\n";

//ループで選択した商品のみを取り出す。
for($i=0;$i<$max;$i++)
  {
  $sql='SELECT name,price FROM product WHERE id=?';
  $stmt=$dbh->prepare($sql);
  $data[0]=$cart[$i];
  $stmt->execute($data);

  $rec=$stmt->fetch(PDO::FETCH_ASSOC);

  $product_name=$rec['name'];
  $product_price=$rec['price'];
  $product_quantity=$quantity[$i];
  $subtotal=$rec['price']*$quantity[$i];

  $message .=$product_name." ";
  $message .=$product_price."円 × ";
  $message .=$product_quantity."個 ＝";
  $message .=$subtotal."円\n";

  }

  $dbh=null;

$message .="合計金額 ".$_SESSION['format_total']."円"."\n";
$message .="送付先 ".$_SESSION['shipping_address']."\n";
$message .="ありがとうございました。\n";
$message .="====================================\n";

$headers = 'From: yuma.yoshikawa0509@gmail.com' . "\r\n";

mb_send_mail($to, $subject, $message, $headers);

//購入が完了したためカートの中身を空にする
$userEmail=$_SESSION['userEmail'];
$userName=$_SESSION['userName'];
$_SESSION=array();
//セッションをすべて消したためusernameとemailをセッションに入れる
$_SESSION['userEmail']=$userEmail;
$_SESSION['userName']=$userName;

?>

<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHP基礎</title>
</head>
<body>
<p><?php echo $_SESSION['userName']?>様！</p>
<p>ご注文ありがとうございました。</p>
<p><?=$_SESSION['userEmail']?>宛にメールを送りましたのでご確認ください。</p>
<br>
<a href="product_list.php">製品一覧画面へ</a>

</body>
</html>
