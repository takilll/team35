<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hobby;
use App\Models\Post;
use DB;
use Session;
use Form;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class HobbyController extends Controller
{
    // 一覧ページ
    public function list(Request $request){
        //データベースのデータ取得
        $db = DB::table('posts');
        //Userテーブルのサブクエリ usersテーブルのid名が被るから idをu_idにリネーム
        $u = DB::table('users')->select( DB::raw( 'id as u_id'), 'nickname','profile_img_path');
        //leftjoinで$dbに$uを結合
        $db->leftjoin( DB::raw( '( '.$u->toSql().' ) as users'), function($join){
            // left join の on句
            $join->whereRaw( 'user_id = u_id ' );
                });
        $hobbys = $db->get();

        $user = Session::get('user');

        $user = User::where( 'id', $user[0]->id )->first();

        $def['prefecture']  = __('define.prefecture');
        $view = view('hobbys.hobbys_list');
        $view->with( 'user', $user);
        $view->with( 'hobbys', $hobbys);
        $view->with( 'def', $def);
        return $view;
    }

    // 趣味投稿ページ
    public function regist(Request $request){
        $user = Session::get('user');
        $user = User::where( 'id', $user[0]->id )->first();
        $nullitem = [ '' => '選択して下さい' ];
        //フォームの構築
        $form = [
            'category'   => Form::select('category', $nullitem + __('define.category'), '',["class"=>"", "id"=>"category"] ),
            'prefecture' => Form::select('prefecture', $nullitem + __('define.prefecture'), '',["class"=>"", "id"=>"prefecture"] ),
        ];
        $view = view('hobbys.regist');
        $view->with( 'form', $form);
        $view->with( 'user', $user);
        return $view;
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
        $user = Session::get('user');
        // var_dump($user);
        // die;


        $post = new Post;
        // ログインしているuser_idを何処で拾うか
        $post->user_id        = $user[0]->id;
        $post->category       = $request->category;
        $post->title          = $request->title;
        $post->text           = $request->text;
        $post->hobby_img_path = $fileName;
        $post->prefecture     = $request->prefecture;
        $post->municipalities = $request->municipalities;
        $post->save();

        // $message = "新規登録が完了しました。";
        return redirect()->route('hobby.list');
    }

    public function edit(Request $request)
    {
        $user = User::find($request->id);
        return view('hobbys.profile_edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        if (Hash::needsRehash($user)) {
            $hashed = Hash::make('password');
        }
        $user->nickname = $request->nickname;
        $user->mail = $request->mail;
        $user->password = Hash::make($request->password);
        $user->profile_img_path = $request->profile_img_path;
        $user->save();
        return redirect('index');
    }

    public function login()
    {   
        // ログイン画面へ遷移
        return view('login');
    }
    public function post(Request $req)
    {
        $table = new hobby;
        $user = $table->getUser($req->mail);
        if (Hash::check($req->password, $user[0]->password)) {
            // kimoto修正
            Session::put('user', $user);
            // ログイン
            return redirect('index');
        } else {
            //ログイン失敗
            return view('login', ['errorMsg' => 'ログインできませんでした']);
        }
    }

    public function getRegister()
    {   
        // ユーザ登録画面へ遷移
        return view('signup');
    }
    public function postRegister(Request $request)
    {
        // ユーザ登録処理
        $user = new hobby;
        $user->nickname = $request->nickname;
        $user->mail = $request->mail;
        $user->birth_year = $request->birth_year;
        $user->birth_month = $request->birth_month;
        $user->birth_day = $request->birth_day;
        $user->password = Hash::make($request->password);

        if ($request -> profile_img_path != null) {
            $file = $request->file('profile_img_path');
            // getClientOriginalName()  拡張子を含め、アップロードしたファイルのファイル名を取得することができる。
            $image_extension = pathinfo($file -> getClientOriginalName(), PATHINFO_EXTENSION);
            // file名が重複しないようにmail_time.拡張子に変更。
            $image_name = $user->mail . '_' . date('YmdHis') . '.' . $image_extension;
            $user->profile_img_path = $image_name;
            //public_path() publicディレクトリの完全パスを返す。publicディレクトリ内にuploadsディレクトリを作成。
            $target_path = public_path('uploads/profile/');
            $file -> move($target_path, $user->profile_img_path);
        }else {
            $user->profile_img_path = "";
        }
        $user->save();
        return redirect('login');
    }

    public function contact()
    {
        //フォーム入力画ページのviewを表示
        return view('contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'nickname' => 'required',
            'mail' => 'required|mail',
            'body'  => 'required'
        ]);

        //フォームから受け取ったactionの値を取得
        $action = $request->input('action');
        
        //フォームから受け取ったactionを除いたinputの値を取得
        $inputs = $request->except('action');

        //actionの値で分岐
        if($action !== 'submit'){
            return redirect()
                ->route('contact')
                ->withInput($inputs);

        } else {
            //入力されたメールアドレスにメールを送信
            \Mail::to($inputs['mail'])->send(new ContactSendmail($inputs));

            //再送信を防ぐためにトークンを再発行
            $request->session()->regenerateToken();

            //送信完了ページのviewを表示
            return view('contact.thanks');
            
        }
    }

    public function mypage(Request $request)
    {
        $nullitem = [ '' => '選択して下さい' ];
        //フォームの構築
        $form = [
            'category'   => Form::select('category', $nullitem + __('define.category'), '',["class"=>"", "id"=>"category"] ),
            'prefecture' => Form::select('prefecture', $nullitem + __('define.prefecture'), '',["class"=>"", "id"=>"prefecture"] ),
        ];
        return view('hobbys.regist')->with('form',$form);
    }
    
   
}
