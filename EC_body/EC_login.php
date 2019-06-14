<?PHP
session_start();
$SESSION_['userEmail']='';
$errorMessage=array('userEmail'=>'','userPassword'=>'');

//ログインボタンが押された際の処理
if(isset($_POST['login'])){
  //バリデーション
  if(empty($_POST['userEmail']) && empty($_POST['userPassword'])){
      $errorMessage['userEmail']='メールアドレスが未入力です';
      $errorMessage['userPassword']='パスワードが未入力です';
    }elseif(empty($_POST['userEmail']) && !empty($_POST['userPassword'])){
      $errorMessage['userEmail']='メールアドレスが未入力です';
    }elseif(!empty($_POST['userEmail']) && empty($_POST['userPassword'])){
      $errorMessage['userPassword']='パスワードが未入力です';
    }

  //dbの接続
  try {
       $dsn='mysql:dbname=shop;host=localhost';
       $user='root';
       $password='';
       $options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'");
       $dbh = new PDO($dsn,$user,$password);
       $dbh->query("set names utf8");
       $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $userEmail = $_POST['userEmail'];
       $userPassword = $_POST['userPassword'];
       $sql = "SELECT * FROM user WHERE email = '$userEmail' AND password = '$userPassword'";
       $stmt = $dbh->query($sql);
       $result = $stmt->fetch(PDO::FETCH_ASSOC);
       //print($result['id']);
       //print($result['name']);

       //ログイン時の処理
       if($userEmail === $result['email'] AND $userPassword===$result['password']){
          $_SESSION['userEmail']=$_POST['userEmail'];
          $_SESSION['userName']=$result['name'];
          //echo $_SESSION['userName'];
          echo '<script>location.href="http://localhost/EC/EC_body/product_list.php";</script>';
          echo 'ログインしました';
          exit();
              }else{
                  echo 'ユーザー名、もしくはパスワードが一致しません';
                    }
       }
       catch (PDOException $e) {
       echo $e->getMessage();
       echo 'パスワードが違います。';
       exit();
  }

  //エラーを表示する設定
  error_reporting(E_ALL & ~E_NOTICE);

}
?>

<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>ログイン機能</title>
</head>
<body>
  <form method="POST" action=''>
    <p>ECサイト　ログインフォーム</p>
    <p>メールアドレス</P>
    <p><?= $errorMessage['userEmail']; ?></P>
      <input type="text" name="userEmail" placeholder="※入力必須">
    <!-- required/ -->
      <p>パスワード</p>
      <p><?= $errorMessage['userPassword'] ?></P>
      <input type="password" name="userPassword" placeholder="※入力必須">
      <br>
      <br>
      <button type="submit" name="login">ログインする</button>
      <br>
      <!-- <br>
         <button type="submit" name="logout">ログアウトする</button>
      <br> -->
      <a href="../user_regist/user_register.php">会員登録はこちらから</a>

  </form>
<?php $dbh=null;?>
</body>
</html>
