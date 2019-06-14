<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//※ここでは他のページやコントローラーに遷移させるのみで複雑な処理はコントローラーにて行う。
//inputからconfirmの画面遷移
Route::get('/input',function(){
  return view('forms/input',['msg'=>'入力してください']);
});

Route::post('/input','FormsController@input');


Route::post('/confirm','FormsController@confirm');

Route::post('/complete','FormsController@complete');

//Route::post('/complete','FormsController@complete');
//これはファーム画面からPOST送信したときのルーティンgぬ
//コンプリートからもgetで画面を表示する。



//confirm画面でのルーティング
// Route::get('/complete', function () {
//      return view('forms/complete');
     // SESSION()->put(['name' => 'ちゃんとセッションに入れた名前:大将']);
     // return SESSION()->all;
// });

//実験的に格納してみたsession
//Session::put('subname','仮に入れたセッション');
//confirmでpostをsessionに格納する
// Route::controller('/session','Sessioncontroller');

//
// Route::get('/confirm', function() {
//     return view('forms/confirm');
// });
//
// Route::get('/complete', function () {
//     return view('forms/complete');
// });

?>
