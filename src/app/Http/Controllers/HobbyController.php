<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hobby;

class HobbyController extends Controller
{
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

   
}
