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

?>
