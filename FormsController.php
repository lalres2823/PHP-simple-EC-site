<?php
//Validatorを用いたvalidation
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Laravel_kadai;
use Illuminate\Support\Facades\db;
use Validator;

class FormsController extends Controller
{

  public function input(Request $data1)
  {

    $rules = [
          'name' => 'required',
          'gender' => 'required|in:male,female',
          'email' => 'email',
          'body' => 'required|min:10|max:400',
    ];

    $messages = [
      'name.required'=>'名前は必ず入力してください（validatorを用いたメッセージ）',
      'gender.required'=>'性別を選択してください（validatorを用いたメッセージ）',
      'gender.in'=>'性別は男性、女性よりお選びください（validatorを用いたメッセージ）',
      'email.email'=>'メールアドレスを入力してください（validatorを用いたメッセージ）',
      'body.required'=>'お問い合わせ内容を入力ください（validatorを用いたメッセージ）',
      'body.min'=>'お問い合わせ内容は10文字以上でご入力ください（validatorを用いたメッセージ）',
      'body.max'=>'お問い合わせ内容は400文字以内でご入力ください（validatorを用いたメッセージ）',
    ];
    $validator = Validator::make($data1->all(),$rules,$messages);

    if($validator->fails()){
      return redirect('/input')
                      ->withErrors($validator)
                      ->withInput();
    }

      return view('forms/confirm',compact('data1'));
  }

    //確認画面からPOSTされた際の処理
    public function confirm(Request $req){
    $confirm = $req->get('confirm', 'back');
    $input = $req->except('action');
    //dd($input);　…ddした結果、この時点で$nameは$hiddenNameになっていた。

    if($confirm === 'submit') {
      //DBへデータの挿入

      $laravel_kadai = new Laravel_kadai;
      $laravel_kadai->name = $req->hiddenName;
      $laravel_kadai->gender = $req->hiddenGender;
      $laravel_kadai->email = $req->hiddenEmail;
      $laravel_kadai->body = $req->hiddenBody;
      $laravel_kadai->save();

    $req->session()->put('name', $req->input('hiddenName'));
    $req->session()->put('gender', $req->input('hiddenGender'));
    $req->session()->put('email', $req->input('hiddenEmail'));
    $req->session()->put('body', $req->input('hiddenBody'));
    $hiddenName = $req->session()->get('name');
    $hiddenGender = $req->session()->get('gender');
    $hiddenEmail = $req->session()->get('email');
    $hiddenBody = $req->session()->get('body');


    return view('forms/complete',compact('hiddenName','hiddenGender','hiddenEmail','hiddenBody'));
  }else{
    return redirect()->action('FormsController@input')
    ->withInput($input);
  }


 }

  public function complete(){
    return view('forms/input',['msg'=>'入力してください']);
  }

}
?>
