<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hobby;
use App\Models\Post;
use DB;
use Session;
use Form;


class HobbyController extends Controller
{
    // 一覧ページ
    public function list(Request $request){
        return view('hobbys.hobbys_list');
    }

    // 趣味投稿ページ
    public function regist(Request $request){
        $nullitem = [ '' => '選択して下さい' ];
        //フォームの構築
        $form = [
            'category'   => Form::select('category', $nullitem + __('define.category'), '',["class"=>"", "id"=>"category"] ),
            'prefecture' => Form::select('prefecture', $nullitem + __('define.prefecture'), '',["class"=>"", "id"=>"prefecture"] ),
        ];
        return view('hobbys.regist')->with('form',$form);
    }

    // 趣味投稿処理
    public function store(Request $request){
        $request->validate([
            'category'              =>'required',
            'title'                 =>'required|max:30',
            'text'                  =>'required|max:300',
            'hobby_img_path'        =>'image',
            'prefecture'            =>'required',
            'municipalities'        =>'max:10'
        ],
        [
            'required'              =>'必須入力です。',
            'image'                 =>'画像はjpg、png、bmp、gif、svg、webpのファイルを選択して下さい。'
        ]);

        if ($file = $request->hobby_img_path) {
            // getClientOriginalName()  拡張子を含め、アップロードしたファイルのファイル名を取得することができる。
            $fileName = time() . $file->getClientOriginalName();
            //public_path() publicディレクトリの完全パスを返す。publicディレクトリ内にuploadsディレクトリを作成。
            $target_path = public_path('uploads/post/');
            $file->move($target_path, $fileName);
        }else {
            $fileName = "";
        }

        // ログインしているuser_idの取得
        // $user = auth::user()->id;

        $post = new Post;
        // ログインしているuser_idを何処で拾うか
        // $post->user_id     = $user;
        $post->category       = $request->category;
        $post->title          = $request->title;
        $post->text           = $request->text;
        $post->hobby_img_path = $fileName;
        $post->prefecture     = $request->prefecture;
        $post->municipalities = $request->municipalities;
        $post->save();

        // $message = "新規登録が完了しました。";
        return redirect()->route('index');
    }

    public function edit(Request $request)
    {
        $user = User::find($request->id);
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->nickname = $request->nickname;
        $user->mail = $request->mail;
        $user->birth_year = $request->birth_year;
        $user->birth_month = $request->birth_month;
        $user->birth_day = $request->birth_day;
        $user->password = $request->password;
        $user->profile_img_path = $request->profile_img_path;
        $user->save();
        return redirect('/user/index');
    }

   
}
