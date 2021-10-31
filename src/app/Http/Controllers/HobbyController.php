<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
// use App\Contact;
use App\Mail\ContactSendmail;
use Illuminate\Http\Request;
// use App\Mail\ContactSendmail;

use App\Models\Hobby;
use App\Models\Post;
use App\Models\Like;
use DB;
use Session;
use Form;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HobbyController extends Controller
{
    // 一覧ページ
    public function list(Request $request)
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if (!Session::has('user')) {
            return redirect('login');
        }
        // 検索処理
        if ($request->has('btnClearSearch')) {
            Session::forget('hobby.search.input');
        }
        $db = DB::table('posts');
        //btnSearchが押されていれば
        if ($request->has('btnSearch')) {
            // 検索条件を$serchに保管する
            $search = [];
            $input = $request->input('category');
            if ($input) {
                $db->where('category', $input);
                $search['category'] = $input;
            }
            $input = $request->input('prefecture');
            if ($input) {
                $db->where('prefecture', $input);
                $search['prefecture'] = $input;
            }
            $input = $request->input('municipalities');
            if ($input) {
                $db->where('municipalities', 'like', "%{$input}%");
                $search['municipalities'] = $input;
            }
            //検索条件をセッションに保存
            Session::put('hobby.search.input', $search);
        } else {
            //ボタンが押されてない場合は、セッションから検索条件を取得して検索を行う
            $input = Session::get('hobby.search.input');
            if (!empty($input['category'])) {
                $db->where('category', $input['category']);
            }
            if (!empty($input['prefecture'])) {
                $db->where('prefecture', $input['prefecture']);
            }
            if (!empty($input['municipalities'])) {
                $db->where('municipalities', 'like', "%{$input['municipalities']}%");
            }
        }
        //Userテーブルのサブクエリ usersテーブルのid名が被るから idをu_idにリネーム
        $u = DB::table('users')->select(DB::raw('id as u_id'), 'nickname', 'profile_img_path');
        //leftjoinで$dbに$uを結合
        $db->leftjoin(DB::raw('( ' . $u->toSql() . ' ) as users'), function ($join) {
            // left join の on句
            $join->whereRaw('user_id = u_id ');
        });
        //検索条件を保管
        $data = Session::get('hobby.search.input');

        $l = DB::table('likes')->select('user_id as like_user_id', 'post_id');
        //leftjoinで$dbに$uを結合
        $db->leftjoin(DB::raw('( ' . $l->toSql() . ' ) as likes'), function ($join) {
            // left join の on句
            $user = Session::get('user');
            //ログインユーザーがいいねをしているかを判定
            $join->whereRaw('id = post_id AND like_user_id = ' . $user[0]->id);
        });
        // いいね数判定
        $like_count = DB::table('likes')->select('post_id as post_id_count', DB::raw('count(post_id) as likes_count'))->groupBy('post_id');
        $db->leftjoin(DB::raw('( ' . $like_count->toSql() . ' ) as likes_count'), 'posts.id', '=', 'likes_count.post_id_count');

        //データを取得
        $hobbys = $db->get();

        //検索結果が無い場合のメッセージ
        $mes = "";
        if ($hobbys->isEmpty()) {
            $mes = "対象データがありませんでした。";
        }
        //検索フォームの構築
        $nullitem_category =   ['' => 'カテゴリーを選択'];
        $nullitem_prefecture = ['' => '県名を入力して下さい'];
        $form = [
            'category'          => Form::select('category', $nullitem_category + __('define.category'), $data['category'] ?? null, ["class" => "", "id" => "category"]),
            'prefecture'        => Form::select('prefecture', $nullitem_prefecture  + __('define.prefecture'), $data['prefecture'] ?? null, ["class" => "", "id" => "prefecture"]),
            'municipalities'    => Form::text('municipalities', $data['municipalities'] ?? null, ["class" => "", "id" => "municipalities", "placeholder" => "市区町村を入力して下さい", "autocomplete" => "off"]),
        ];
        $user = Session::get('user');
        $user = User::where('id', $user[0]->id)->first();
        $def['prefecture']  = __('define.prefecture');
        $view = view('hobbys.hobbys_list');
        $view->with('user',    $user);
        $view->with('hobbys',  $hobbys);
        $view->with('def',     $def);
        $view->with('form',    $form);
        $view->with('mes',     $mes);
        return $view;
    }

    // 趣味投稿ページ
    public function regist(Request $request)
    {
        $user = Session::get('user');
        $user = User::where('id', $user[0]->id)->first();
        $nullitem = ['' => '選択して下さい'];
        //フォームの構築
        $form = [
            'category'   => Form::select('category', $nullitem + __('define.category'), '', ["class" => "", "id" => "category"]),
            'prefecture' => Form::select('prefecture', $nullitem + __('define.prefecture'), '', ["class" => "", "id" => "prefecture"]),
        ];
        $view = view('hobbys.regist');
        $view->with('form', $form);
        $view->with('user', $user);
        return $view;
    }

    // 趣味投稿処理
    public function store(Request $request)
    {
        $request->validate(
            [
                'category'              => 'required',
                'title'                 => 'required|max:30',
                'text'                  => 'required|max:300',
                'hobby_img_path'        => 'image',
                'prefecture'            => 'required',
                'municipalities'        => 'max:10',
            ],
            [
                'required'              => '必須入力です。',
                'title.max'             => 'タイトルは30文字以内で入力して下さい。',
                'text.max'              => '投稿内容は300文字以内で入力して下さい。',
                'municipalities.max'    => '市区町村は10文字以内で入力して下さい。',
                'image'                 => '画像はjpg、png、bmp、gif、svg、webpのファイルを選択して下さい。'
            ]
        );

        if ($file = $request->hobby_img_path) {
            // getClientOriginalName()  拡張子を含め、アップロードしたファイルのファイル名を取得することができる。
            $fileName = time() . $file->getClientOriginalName();
            //public_path() publicディレクトリの完全パスを返す。publicディレクトリ内にuploadsディレクトリを作成。
            $target_path = public_path('uploads/post/');
            $file->move($target_path, $fileName);
        } else {
            $fileName = "";
        }
        $user = Session::get('user');

        $post = new Post;
        $post->user_id        = $user[0]->id;
        $post->category       = $request->category;
        $post->title          = $request->title;
        $post->text           = $request->text;
        $post->hobby_img_path = $fileName;
        $post->prefecture     = $request->prefecture;
        $post->municipalities = $request->municipalities;
        $post->save();
        return redirect()->route('hobby.list');
    }

    public function like(Request $request, $id)
    {
        $user = Session::get('user');

        $like = new Like;
        $like->user_id        = $user[0]->id;
        $like->post_id        = $id;
        $like->save();
        return redirect()->route('hobby.list');
    }

    public function unlike(Request $request, $id)
    {
        $user = Session::get('user');
        $like = Like::where('post_id', $id)->where('user_id', $user[0]->id)->first();
        $like->delete();
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
        if (!Session::has('user')) {
            return redirect('login');
        }
        $user = Session::get('user');
        $user = User::find($user[0]->id);
        // $user = User::find($request->id);
        // return view('hobbys.profile_edit', ['user' => $user]);
        $view = view('hobbys.profile_edit');
        $view->with('user',    $user);
        return $view;
    }

    public function update(Request $request)
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if (!Session::has('user')) {
            return redirect('login');
        }
        $user = Session::get('user');
        $user = User::find($user[0]->id);
        // $user = User::find($request->id);
        Log::debug("current:" . $request->current_password);
        Log::debug("new:" . $request->new_password);
        if ($request->current_password != '' && $request->new_password != '') {
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
        if ($request->profile_img_path != null) {
            $file = $request->file('profile_img_path');
            // getClientOriginalName()  拡張子を含め、アップロードしたファイルのファイル名を取得することができる。
            $image_extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            // file名が重複しないようにmail_time.拡張子に変更。
            $image_name = $user->mail . '_' . date('YmdHis') . '.' . $image_extension;
            $user->profile_img_path = $image_name;
            //public_path() publicディレクトリの完全パスを返す。publicディレクトリ内にuploadsディレクトリを作成。
            $target_path = public_path('uploads/profile/');
            $file->move($target_path, $user->profile_img_path);
        } else {
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

        if ($request->profile_img_path != null) {
            $file = $request->file('profile_img_path');
            // getClientOriginalName()  拡張子を含め、アップロードしたファイルのファイル名を取得することができる。
            $image_extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            // file名が重複しないようにmail_time.拡張子に変更。
            $image_name = $user->mail . '_' . date('YmdHis') . '.' . $image_extension;
            $user->profile_img_path = $image_name;
            //public_path() publicディレクトリの完全パスを返す。publicディレクトリ内にuploadsディレクトリを作成。
            $target_path = public_path('uploads/profile/');
            $file->move($target_path, $user->profile_img_path);
        } else {
            $user->profile_img_path = "";
        }
        $user->save();
        return redirect('login');
    }

    public function contact()
    {
        // dd($_GET['id']);
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if (!Session::has('user')) {
            return redirect('login');
        }
        $user = Session::get('user');
        // dd($user);
        $user = User::where( 'id', $user[0]->id )->first();
        // $_GET['id'];
        $post =  Session::get('user_id');
        $to_user =  Session::get('user');
        $to_user = User::where('id', $_GET['id'])->get()->toArray();
        $view = view('hobbys.contact');
        $view->with( 'user', $user);
        $view->with( 'to_user', $to_user[0]);
        $view->with( 'post', $post);
        return $view;
    }

    public function confirm(Request $request)
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if (!Session::has('user')) {
            return redirect('login');
        }
        $request->validate([
            'title'     => 'required|max:50',
            'id'     => 'required|max:50',
            'nickname'     => 'required|max:100',
            'mail'    => 'required|email',
            'body' => 'required|max:300',
        ]);
        // ここを追記
        // フォームから受け取ったすべてのinputの値を取得
        $inputs = $request->all();
        $to_user = User::where('id', $request['id']);
        $post =  Session::get('user_id');
        $to_user =  Session::get('user');
        $to_user = User::where('id', $_GET['id'])->get()->toArray();
        $user = Session::get('user');
        // Log::debug("get user data from db");
        $user = User::where( 'id', $user[0]->id )->first();
        $view = view('hobbys.confirm', ['inputs' => $inputs]);
        $view->with( 'user', $user);
        $view->with( 'to_user', $to_user[0]);
        $view->with( 'contact', ['title' => $request['title'],
            'id' => $request['id'],
            'nickname' => $request['nickname'],
            'mail' => $request['mail'],
            'body' => $request['body']
        ]);
        // Log::debug("end confirm");
        return $view;
    }

    public function send(Request $request)
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if (!Session::has('user')) {
            return redirect('login');
        }
        //バリデーションを実行（結果に問題があれば処理を中断してエラーを返す）
        $request->validate([
            'user_id' => 'required',
            'nickname' => 'required',
            'mail' => 'required|email',
            'to_user_id' => 'required',
            'to_nickname' => 'required',
            'to_mail' => 'required|email',
            'title' => 'required',
            'body'  => 'required',
        ]);

        //フォームから受け取ったactionの値を取得
        $action = $request->input('action');
        Log::debug($action);
        //フォームから受け取ったactionを除いたinputの値を取得
        $inputs = $request->except('action');

        //actionの値で分岐
        if($action !== 'submit'){

            return redirect()
                ->route('hobby.list')
                ->withInput($inputs);

        } else {

            // DBにデータを保存
            $contact = new Contact;
            // $contact->fill($inputs);
            // ログインしているuser_idを何処で拾うか
            $contact->user_id        = $request->user_id;
            $contact->nickname       = $request->nickname;
            $contact->mail           = $request->mail;
            $contact->to_user_id     = $request->to_user_id;
            $contact->to_nickname    = $request->to_nickname;
            $contact->to_mail        = $request->to_mail;
            $contact->title          = $request->title;
            $contact->body           = $request->body;
        
            $contact->save();
            //入力されたメールアドレスにメールを送信
            \Mail::to($inputs['to_mail'])->send(new ContactSendmail($inputs));

            //再送信を防ぐためにトークンを再発行
            $request->session()->regenerateToken();

            //送信完了ページのviewを表示
            return view('hobbys.complete');
        }
    }

    public function mypage(Request $request)
    {
        //瀧川追加:ログインしていなければログイン画面へ戻る
        if (!Session::has('user')) {
            return redirect('login');
        }
        $user = Session::get('user');
        $user = User::find($user[0]->id);
        $query = <<<SQL
            select * from (
                select
                    posts.*,
                    count(posts.id) as likes_count
                from posts,likes
                where posts.id=likes.post_id
                group by posts.id
                ) as posts left join users ON users.id = posts.user_id
            WHERE posts.user_id =  $user->id;
        SQL;

        $def['prefecture']  = __('define.prefecture');
        $result = DB::select($query);
        $view = view('hobbys.mypage');
        $view->with('def',     $def);
        $view->with('user',    $user);
        $view->with('hobbys',  $result);
        return $view;
    }

    public function hobby_edit(Request $request)
    {
        // $user = Session::get('user');
        // $user = User::find( $user[0]->id );
        // $post = Session::get('post');
        // $post = Post::find( $post->id );
        $user = User::find($request->id);
        $post = Post::where('id', $_GET['id'])->get()->toArray();
        // ID のチェック
        // if($post[0]['user_id']!=$user[0]->id){
        //     return view('hobby.mypage');
        // }
        // $user = User::where( 'id', $user[0]->id )->first();
        // $post = Post::where( 'id', $post[0]->id )->first();
        // $post = Post::find($request->id);
        $view = view('hobbys.hobby_edit');
        $nullitem = ['' => '選択して下さい'];
        //フォームの構築
        $form = [
            'category'   => Form::select('category', $nullitem + __('define.category'), $post[0]['category'],["class"=>"", "id"=>"category"] ),
            'prefecture' => Form::select('prefecture', $nullitem + __('define.prefecture'), $post[0]['prefecture'],["class"=>"", "id"=>"prefecture"]  ),
        ];
        $view->with( 'user',    $user);
        $view->with( 'post',  $post[0]);
        // dd($post[0]);
        $view->with( 'form', $form);
        return $view;
    }

    public function hobby_update(Request $request)
    {
        $request->validate(
            [
                'category'              => 'required',
                'title'                 => 'required|max:30',
                'text'                  => 'required|max:300',
                'hobby_img_path'        => 'image',
                'prefecture'            => 'required',
                'municipalities'        => 'max:10'
            ],
            [
                'required'              => '必須入力です。',
                'image'                 => '画像はjpg、png、bmp、gif、svg、webpのファイルを選択して下さい。'
            ]
        );

        if ($file = $request->hobby_img_path) {
            // getClientOriginalName()  拡張子を含め、アップロードしたファイルのファイル名を取得することができる。
            $fileName = time() . $file->getClientOriginalName();
            //public_path() publicディレクトリの完全パスを返す。publicディレクトリ内にuploadsディレクトリを作成。
            $target_path = public_path('uploads/post/');
            $file->move($target_path, $fileName);
        } else {
            $fileName = "hobby_img_path";
        }

        // $user = Session::get('user');
        // $user = User::find( $user[0]->id );
        // $post = Session::get('post');
        // $post = Post::find( $post->id );
        $user = Session::get('user');
        $post = Post::where('id', $_GET['id'])->first();
        // dd($post);s
        // $post = Post::find($request->id);
        // ログインしているuser_idを何処で拾うか
        $post->user_id        = $user[0]->id;
        $post->category       = $request->category;
        $post->title          = $request->title;
        $post->text           = $request->text;
        $post->hobby_img_path = $fileName;
        $post->prefecture     = $request->prefecture;
        $post->municipalities = $request->municipalities;
        $post-> save();

        return redirect('mypage');
    }

    public function hobby_delete(Request $request)
    {
        // $post = Post::find($request->id);
        $post = Post::where('id', $_GET['id'])->get()->toArray();
        // $post = Session::get('post');
        // $post = Post::find( $post[0]->id );
        $nullitem = ['' => '選択して下さい'];
        //フォームの構築
        $form = [
            'category'   => Form::select('category', $nullitem + __('define.category'), $post[0]['category'],["class"=>"", "id"=>"category", 'disabled'=>'disabled'] ),
            'prefecture' => Form::select('prefecture', $nullitem + __('define.prefecture'), $post[0]['prefecture'],["class"=>"", "id"=>"prefecture", 'disabled'=>'disabled'] ),
        ];
        $view = view('hobbys.hobby_delete');
        $view->with( 'post',  $post[0]);
        $view->with( 'form', $form);
        return $view;
        // return view('hobbys.hobby_delete', ['post' => $post]);
    }

    public function hobby_remove(Request $request)
    {
        $post = Post::where('id', $_GET['id'])->first();
        // $post = Session::get('post');
        // $post = Post::find( $post[0]->id );
        $post->delete();
        return redirect('mypage');
    }
}
