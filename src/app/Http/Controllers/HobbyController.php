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

   
}
