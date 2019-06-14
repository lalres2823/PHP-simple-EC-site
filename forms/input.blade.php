<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHP基礎</title>
</head>
<body>

  <div class = "main">
    <div class = "contact-form">
        <div class = "form-title">お問い合わせフォーム</div>
    @section('content')
      <p>メッセージ{{$msg}}</p>
      @if (count($errors)>0)
      <p>入力に問題があります。再入力してください</p>
      @endif
        <table>
        <form method = "post" action = "input">
          @csrf

          <div class = "form-item" name="name">名前を入力してください</div>
          @if ($errors->has('name'))
          <p>{{$errors->first('name')}}</p>
          @endif
          <input type = "text" name= "name" value="{{old('name')}}{{old('hiddenName')}}" >

          <div class = "form-item">性別を選択してください</div>
          @if ($errors->has('gender'))
          <p>{{$errors->first('gender')}}</p>
          @endif
          <select name = "gender">
              <option value="other" @if(old('gender')=='other') selected @endif>未選択</option>
              <option value="male" @if(old('gender')=='male') selected  @endif>男性</option>
              <option value="female" @if(old('gender')=='female') selected @endif>女性</option>
          </select>

          <div class = "form-item">メールアドレスを入力してください</div>
          @if ($errors->has('email'))
          <p>{{$errors->first('email')}}</p>
          @endif
          <input type="email" name= "email" value="{{old('email')}}{{old('hiddenEmail')}}">

          <div class="form-item">お問い合わせ内容を入力してください</div>
          @if ($errors->has('body'))
          <p>{{$errors->first('body')}}</p>
          @endif
          <textarea name="body" value="{{old('body')}}">{{old('body')}}{{old('hiddenBody')}}</textarea>
          <P><input type="submit" value="送信する" name="send"></p>
        </form>
        </table>
    </div>
  </div>
  </body>
  </html>
