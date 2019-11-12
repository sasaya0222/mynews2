<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

class ProfileController extends Controller
{
    //
  public function add()
  {
      return view('admin.profile.create');
  }
 public function create(Request $request)
  {

      // 以下を追記
      // Varidationを行う
      $this->validate($request, Profile::$rules);

      $Profile = new Profile;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$Profile->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $Profile->image_path = basename($path);
      } else {
          $Profile->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $Profile->fill($form);
      $Profile->save();

      return redirect('admin/profile/create');
  }

 public function edit()
 {
 return view('admin.profile.edit');
 }
 public function update()
 {
 return redirect('admin/profile/edit');
 }

}
