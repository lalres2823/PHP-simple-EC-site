<?php
//laravel_kadaiのController
//実験的に作成。この内容はFormsControllerに組み込まれているため不要。
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Laravel_kadai;

class Laravel_kadaiController extends Controller
{
  public function add(Request $request)
  {
    return view('person.add');
  }

  public function create(Request $req)
  {
    $laravel_kadai = new Laravel_kadai;
    $laravel_kadai->name = $req->hiddenName;
    $laravel_kadai->gender = $req->hiddenGender;
    $laravel_kadai->email = $req->hiddenEmail;
    $laravel_kadai->body = $req->hiddenBody;
    $laravel_kadai->save();
  }

}
