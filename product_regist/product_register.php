<?PHP
session_start();

$picture='';
$page_flag=0;
$error=array('name'=>'','picture'=>'','introduction'=>'','price'=>'');
function br() {
   echo '<br>';
 }
echo '1';

//もしも送信ボタンが押された場合
//製品名のバリデーション
if(isset($_POST['regist'])){
  if(empty($_POST['name'])){
    echo '製品の名前が空欄です。';
    $error['name']="製品の名前が空欄です";
    $page_flag=1;
  }
  elseif(preg_match("/^.{1,150}$/",$_POST['name'])){
    echo '1.製品の名前はOK';
    }else{
      echo '1.製品の名前はだめ';
      $error['name']="製品の名前は1文字以上入力してください";
      $page_flag=1;
    }

//製品画像のバリデーション
  $picture=$_FILES['picture'];
  if($picture['size'] == 0){
    echo '製品画像を挿入してください。';
    $error['picture']="製品画像がありません";
    $page_flag=1;
  }
    elseif($picture['size']>1000000){
        $error['picture']="製品画像のサイズに関するエラー";
        $page_flag=1;
      }else {
        echo '画像をアップロードできます。';

      }

//紹介文のバリデーション
        if(empty($_POST['introduction'])){
          echo '製品紹介文が空欄です。';
          $error['introduction']="製品紹介文を入力してください";
          $page_flag=1;
        }
          elseif(preg_match("/^.{1,400}$/",$_POST['introduction'])){
            echo '1.製品紹介文はOK';
            }else{
              echo '1.製品紹介文はだめ';
              $error['introduction']="製品紹介文は400文字以内で入力してください";
              $page_flag=1;
            }


///価格のバリデーション
  if(empty($_POST['price'])){
    echo '価格が空欄です。';
    $error['price']="価格が空欄です";
    $page_flag=1;
    }
      elseif(preg_match('/^[0-9]{1,11}+$/',$_POST['price'])){
        echo '価格はOK';
      }else{
        echo '価格にミスがあります。';
        $error['price']="価格はカンマを含まない11桁までの半角整数を入力してください";
        $page_flag=1;
      }


    if($page_flag==0){
        move_uploaded_file($picture['tmp_name'],'./picture/'.$picture['name']);
        //print '<img src="./picture/'.$picture['name'].'">';exit();
        $_SESSION = $_POST;
        $_SESSION['files_name']=$picture['name'];
        header('Location: http://localhost/EC/product_regist/product_confirm.php');
        exit();
    }
}

?>


<!-- ここからHTMLとエラー文の表示 -->
<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>商品登録</title>
</head>
<body>
  <div class = "form-title">商品登録ページ</div>
  <!--名称の入力欄-->
    <form method = "post" action='' enctype="multipart/form-data">
      <?PHP
        if($error['name']==''){
          echo '製品名を入力してください';
        }else{
          echo $error['name'];
        }
        var_dump($error);
      ?>
    <br>
    <input type = "text" name= "name">
    <br>
<!-- 名称の入力欄終了 -->


<!-- 画像の入力欄 -->
<?PHP
  if($error['picture']==''){
    echo '画像を挿入してください';
  }else{
    echo $error['picture'];
  }
?>
<br>
<input type = "file" name= "picture" style="width:400px">
<br>
<!-- 住所の入力欄終了 -->

<!-- メールアドレスの入力欄 -->
<?PHP
  if($error['introduction']==''){
    echo '紹介文を入力してください';
  }else{
    echo $error['introduction'];
  }
?>
<br>
<input type = "text" name= "introduction">
<br>
<!-- メールアドレスの入力欄終了 -->

<!-- パスワード2の入力欄 -->
    <?PHP
        if($error['price']==''){
          echo '価格を入力してください';
        }else{
          echo $error['price'];
        }
      ?>
    <br>
    <input type = "text" name= "price">
    <br>

<!-- ボタンを押した際の処理 -->
    <p><button type="submit" name="regist" >確認</button></p>
    <br>

</form>
</body>
</html>
