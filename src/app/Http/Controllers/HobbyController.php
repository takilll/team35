<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
// use App\Contact;
use App\Mail\ContactMail;
use Illuminate\Http\Request;

use App\Models\Hobby;
use App\Models\Post;
use DB;
use Session;
use Form;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HobbyController extends Controller
{
    // 一覧ページ
    public function list(Request $request){
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if(!Session::has('user')){
            return redirect('login');
        }
        // 検索処理
        if( $request->has('btnClearSearch') ){
            Session::forget('hobby.search.input');
        }
        $db = DB::table('posts');
        //btnSearchが押されていれば
        if( $request->has('btnSearch') ){
            // 検索条件を$serchに保管する
            $search =[];
            $input = $request->input('category');
            if( $input ){
                $db->where( 'category', $input );
                $search['category'] = $input;
            }
            $input = $request->input('prefecture');
            if( $input ){
                $db->where('prefecture', $input);
                $search['prefecture'] = $input;
            }
            $input = $request->input('municipalities');
            if( $input ){
                $db->where('municipalities', 'like', "%{$input}%");
                $search['municipalities'] = $input;
            }
            //検索条件をセッションに保存
            Session::put('hobby.search.input', $search);
        } else {
            //ボタンが押されてない場合は、セッションから検索条件を取得して検索を行う
            $input = Session::get('hobby.search.input');
            if( !empty($input['category']) ){
                $db->where( 'category', $input['category'] );
            }
            if( !empty($input['prefecture']) ){
                $db->where('prefecture', $input['prefecture']);
            }
            if( !empty($input['municipalities']) ){
                $db->where('municipalities', 'like', "%{$input['municipalities']}%");
            }
        }
        //Userテーブルのサブクエリ usersテーブルのid名が被るから idをu_idにリネーム
        $u = DB::table('users')->select( DB::raw( 'id as u_id'), 'nickname','profile_img_path');
        //leftjoinで$dbに$uを結合
        $db->leftjoin( DB::raw( '( '.$u->toSql().' ) as users'), function($join){
            // left join の on句
            $join->whereRaw( 'user_id = u_id ' );
                });
        //検索条件を保管
        $data = Session::get('hobby.search.input');
        //データを取得
        $hobbys = $db->get();
        //検索結果が無い場合のメッセージ
        $mes = "";
        if($hobbys->isEmpty()){
            $mes = "対象データがありませんでした。";
        }
        //検索フォームの構築
        $nullitem_category =   [ '' => 'カテゴリーを選択' ];
        $nullitem_prefecture = [ '' => '県名を入力して下さい' ];
        $form = [
            'category'          => Form::select('category', $nullitem_category + __('define.category'), $data['category']?? null,["class"=>"", "id"=>"category"] ),
            'prefecture'        => Form::select('prefecture', $nullitem_prefecture  + __('define.prefecture'), $data['prefecture']?? null,["class"=>"", "id"=>"prefecture"] ),
            'municipalities'    => Form::text('municipalities', $data['municipalities'] ?? null, ["class"=>"", "id"=>"municipalities", "placeholder"=>"市区町村を入力して下さい","autocomplete"=>"off"]),
        ];
        $user = Session::get('user');
        $user = User::where( 'id', $user[0]->id )->first();
        $def['prefecture']  = __('define.prefecture');
        $view = view('hobbys.hobbys_list');
        $view->with( 'user',    $user);
        $view->with( 'hobbys',  $hobbys);
        $view->with( 'def',     $def);
        $view->with( 'form',    $form);
        $view->with( 'mes',     $mes);
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

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'new_password' => 'required|string|min:6|confirmed',
        ]);
    }
    
    public function edit(Request $request)
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if(!Session::has('user')){
            return redirect('login');
        }
        $user = Session::get('user');
        $user = User::find( $user[0]->id );
        // $user = User::find($request->id);
        // return view('hobbys.profile_edit', ['user' => $user]);
        $view = view('hobbys.profile_edit');
        $view->with( 'user',    $user);
        return $view;
    }

    public function update(Request $request)
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if(!Session::has('user')){
            return redirect('login');
        }
        $user = Session::get('user');
        $user = User::find( $user[0]->id );
        // $user = User::find($request->id);
        Log::debug("current:".$request->current_password);
        Log::debug("new:".$request->new_password);
        if($request->current_password!='' && $request->new_password!='' ){
            // ID のチェック
            //（ここでエラーになることは通常では考えられない）
            Log::debug("before id verify");
            // if ($request->id != $id = Auth::id() ) {
            //     return redirect('/index')
            //             ->with('warning', '致命的なエラーです');
            // }
            // 現在のパスワードを確認
            Log::debug("before password verify");
            if (!password_verify($request->current_password, $user->password)) {
            return redirect('/user/edit/{id}')
                    ->with('warning', 'パスワードが違います');
            }
            // Validation（6文字以上あるか，2つが一致しているかなどのチェック）
            Log::debug("before validate");
            $this->validator($request->all())->validate();
            // パスワードを保存
            Log::debug($user->password);
            $user->password = Hash::make($request->new_password);
            Log::debug($user->password);
        } 
        // return redirect('/index')
        //         ->with('status', 'パスワードを変更しました');
        $user->nickname = $request->nickname;
        $user->mail = $request->mail;
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
            $user->profile_img_path = "profile_img_path";
        }
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
    public function logout(Session $session)
    {
        //ユーザーセッションの消去
        Session::forget('user');
        // ログイン画面に戻る
        return redirect('login');
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
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if(!Session::has('user')){
            return redirect('login');
        }
        $user = Session::get('user');
        $user = User::where( 'id', $user[0]->id )->first();
        $view = view('hobbys.contact');
        $view->with( 'user', $user);
        return $view;
    }

    public function confirm()
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if(!Session::has('user')){
            return redirect('login');
        }
        $request->validate([
            'title'     => 'required|max:50',
            'nickname'     => 'required|max:100',
            'mail'    => 'required|mail',
            'message' => 'required|max:300',
        ]);

        // ここを追記
        // フォームから受け取ったすべてのinputの値を取得
        $inputs = $request->all();

        $user = Session::get('user');
        $user = User::where( 'id', $user[0]->id )->first();
        $view = view('hobbys.confirm', ['inputs' => $inputs]);
        $view->with( 'user', $user);
        return $view;
    }

    public function process()
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if(!Session::has('user')){
            return redirect('login');
        }
        $action = $request->get('action', 'return');
        $input  = $request->except('action');

        if($action === 'submit') {

            // DBにデータを保存
            $contact = new Contact();
            $contact->fill($input);
            $contact->save();

            // メール送信
            Mail::to($input['mail'])->send(new ContactMail('mails.contact', 'お問い合わせありがとうございます', $input));

            $user = Session::get('user');
            $user = User::where( 'id', $user[0]->id )->first();
            // $view = view('hobbys.confirm');
            $view->with( 'user', $user);
            return redirect()->route('complete');
        } else {
            $user = Session::get('user');
            $user = User::where( 'id', $user[0]->id )->first();
            // $view = view('hobbys.confirm');
            $view->with( 'user', $user);
            return redirect()->route('contact')->withInput($input);
        }
    }

    public function complete()
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if(!Session::has('user')){
            return redirect('login');
        }
        $user = Session::get('user');
        $user = User::where( 'id', $user[0]->id )->first();
        $view = view('hobbys.complete');
        $view->with( 'user', $user);
        return $view;
    }

    public function mypage(Request $request)
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if(!Session::has('user')){
            return redirect('login');
        }
        $user = Session::get('user');
        $user = User::find( $user[0]->id );
        $query = <<<SQL
            SELECT
                users.nickname AS nickname,
                users.profile_img_path AS profile_img_path,
                posts.*
            FROM
                posts
                LEFT JOIN
                users ON users.id = posts.user_id
            WHERE
                posts.user_id = $user->id
        SQL;

        $def['prefecture']  = __('define.prefecture');
        $result = DB::select($query);
        $view = view('hobbys.mypage');
        $view->with( 'def',     $def);
        $view->with( 'user',    $user);
        $view->with( 'hobbys',  $result);
        return $view;
    }

    public function hobby_edit(Request $request)
    {
        // ID のチェック
        // $user = Session::get('user');
        // $user = User::find( $user[0]->id );
        // $post = Session::get('post');
        // $post = Post::find( $post->id );
        $user = User::find($request->id);
        $post = Post::find($request->id);
        $view = view('hobbys.hobby_edit');
        $nullitem = [ '' => '選択して下さい' ];
        //フォームの構築
        $form = [
            'category'   => Form::select('category', $nullitem + __('define.category'), $post->category,["class"=>"", "id"=>"category"] ),
            'prefecture' => Form::select('prefecture', $nullitem + __('define.prefecture'), $post->prefecture,["class"=>"", "id"=>"prefecture"]  ),
        ];
        $view->with( 'user',    $user);
        $view->with( 'post',  $post);
        $view->with( 'form', $form);
        return $view;
    }

    public function hobby_update(Request $request)
    {
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
            $fileName = "hobby_img_path";
        }

        // $user = Session::get('user');
        // $user = User::find( $user[0]->id );
        // $post = Session::get('post');
        // $post = Post::find( $post->id );
        $user = Session::get('user');
        $post = Post::find($request->id);
        // ログインしているuser_idを何処で拾うか
        $post->user_id        = $user[0]->id;
        $post->category       = $request->category;
        $post->title          = $request->title;
        $post->text           = $request->text;
        $post->hobby_img_path = $fileName;
        $post->prefecture     = $request->prefecture;
        $post->municipalities = $request->municipalities;
        $post->save();

        return redirect('mypage');
    }

    public function hobby_delete(Request $request)
    {
        $post = Post::find($request->id);
        // $post = Session::get('post');
        // $post = Post::find( $post[0]->id );
        $nullitem = [ '' => '選択して下さい' ];
        //フォームの構築
        $form = [
            'category'   => Form::select('category', $nullitem + __('define.category'), $post->category,["class"=>"", "id"=>"category"] ),
            'prefecture' => Form::select('prefecture', $nullitem + __('define.prefecture'), $post->prefecture,["class"=>"", "id"=>"prefecture"] ),
        ];
        // $view = view('hobbys.hobby_delete');
        // $view->with( 'post',  $post);
        // $view->with( 'form', $form);
        // return $view;
        return view('hobbys.hobby_delete', ['post' => $post]);
    }

    public function hobby_remove(Request $request)
    {
        $post = Post::find($request->id);
        // $post = Session::get('post');
        // $post = Post::find( $post[0]->id );
        $post->delete();
        return redirect('mypage');
    }


   
}
