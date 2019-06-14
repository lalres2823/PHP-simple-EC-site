<?PHP
session_start();
$dsn='mysql:dbname=shop;host=localhost';
$user='root';
$password='';
try{
$dbh=new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');
}catch(PDOException $e){
  echo 'データベースにアクセスできません'.$e->getMessage();
  exit();
}


$page_flag=0;
$error=array('name'=>'','address'=>'','email'=>'','pass1'=>'','pass2'=>'','card_number'=>'',);
function br() {
   echo '<br>';
 }
echo '1';

//もしも送信ボタンが押された場合
//名前のバリデーション
if(isset($_POST['regist'])){
  if(empty($_POST['name'])){
    echo '名前が空欄です。';
    $error['name']="名前が空欄です";
    $page_flag=1;
  }
  elseif(preg_match("/^[ぁ-んァ-ヶー一-龠]+$/",$_POST['name'])){
    echo '1.名前はOK';
    }else{
      echo '1.名前はだめ';
      $error['name']="名前に記号があります。";
      $page_flag=1;
    }

//住所のバリデーション
  if(empty($_POST['address'])){
    echo '住所が空欄です。';
    $error['address']="住所が空欄です";
    $page_flag=1;
  }
    elseif(preg_match("/^.{5,100}$/",$_POST['address'])){
      echo '1.住所はOK';
      }else{
        echo '1.住所はだめ';
        $error['address']="住所は5文字以上100文字以内で入力してください";
        $page_flag=1;
      }

//メールアドレスのバリデーション
        if(empty($_POST['email'])){
          echo 'メールアドレスが空欄です。';
          $error['email']="メールアドレスが空欄です";
          $page_flag=1;
        }
          elseif(preg_match("/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/",$_POST['email'])){
            echo '1.メールアドレスはOK';
            }else{
              echo '1.メールアドレスはだめ';
              $error['email']="メールアドレスを正しく入力してください";
              $page_flag=1;
            }


//パスワード1のバリデーション
  if(empty($_POST['pass1'])){
    echo 'パス1が空欄です。';
    $error['pass1']="パスワードが空欄です";
    $page_flag=1;
  }
    elseif(preg_match('/\A[a-z\d]{8,100}+\z/i',$_POST['pass1'])){
      echo '2パスワードはOK';
    }
    elseif($_POST['pass1']!==$_POST['pass2']){
      $error['pass1']='入力したパスワードが異なります。同じパスワードを入力してください。';
      $page_flag=1;
    }
    else{
    echo 'パスワード2にミスがあります。';
    $error['pass1']="パスワードは半角英数字8文字以上100文字以下で記入してください。";
    $page_flag=1;
  }

///パスワード2のバリデーション
  if(empty($_POST['pass2'])){
    echo 'パス2が空欄です。';
    $error['pass2']="パスワード2が空欄です";
    }
      elseif(preg_match('/\A[a-z\d]{8,100}+\z/i',$_POST['pass2'])){
        echo 'パスワード2はOK';
      }else{
        echo 'パスワード2にミスがあります。';
        $error['pass2']="パスワードは半角英数字8文字以上100文字以下で記入してください。";
        $page_flag=1;
      }

//クレジットカードのバリデーション
    if(empty($_POST['card_number'])){
      echo 'クレジットカード番号が空欄です。';
      $error['card_number']="クレジットカード番号が空欄です";
      }
      elseif(preg_match("/^[0-9]{16}+$/",$_POST['card_number'])){
            echo 'クレジットカード番号はOK';
      }else{
            echo 'クレジットカード番号にミスがあります。';
            $error['card_number']="クレジットカード番号にミスがあります。ハイフンを含めず半角数字16文字で入力してください。";
            $page_flag=1;
          }

    if($page_flag==0){
        $_SESSION = $_POST;
        header('Location: http://localhost/EC/user_regist/user_confirm.php');
        exit();
    }
}

?>


<!-- ここからHTMLとエラー文の表示 -->
<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>EC会員登録</title>
</head>
<body>
  <div class = "form-title">会員登録ページ</div>
<!--名前の入力欄-->
    <form method = "post" action='' >
      <?PHP
        if($error['name']==''){
          echo '名前を入力してください';
        }else{
          echo $error['name'];
        }
        var_dump($error);
      ?>
    <br>
    <input type = "text" name= "name">
    <br>
<!-- 名前の入力欄終了 -->


<!-- 住所の入力欄 -->
<?PHP
  if($error['address']==''){
    echo '住所を入力してください';
  }else{
    echo $error['address'];
  }
?>
<br>
<input type = "text" name= "address">
<br>
<!-- 住所の入力欄終了 -->

<!-- メールアドレスの入力欄 -->
<?PHP
  if($error['email']==''){
    echo 'メールアドレスを入力してください';
  }else{
    echo $error['email'];
  }
?>
<br>
<input type = "text" name= "email">
<br>
<!-- メールアドレスの入力欄終了 -->

<!-- パスワード1の入力欄 -->
    <?PHP
        if($error['pass1']==''){
          echo 'パスワードを入力してください';
        }else{
          echo $error['pass1'];
        }
      ?>
    <br>
    <input type = "text" name= "pass1">
    <br>

<!-- パスワード2の入力欄 -->
    <?PHP
        if($error['pass2']==''){
          echo 'パスワードを再度入力してください';
        }else{
          echo $error['pass2'];
        }
      ?>
    <br>
    <input type = "text" name= "pass2">
    <br>

<!-- クレジットカード番号の入力欄 -->
  <?PHP
      if($error['card_number']==''){
        echo 'クレジットカード番号を入力してください';
      }else{
        echo $error['card_number'];
      }
  ?>
  <br>
  <input type = "text" name= "card_number">
  <br>

<!-- クレジットカード番号の入力欄終了 -->


<!-- ボタンを押した際の処理 -->
    <p><button type="submit" name="regist" >確認</button></p>
    <br>
    <a href="">すでに登録済みの方はこちらからログインしてください(ログインページを作成したらURLを埋め込む)</a>

</form>
</body>
</html>
