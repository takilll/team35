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
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();
        return redirect('/user/index');
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        return view('user.delete', ['user' => $user]);
    }

    public function remove(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return redirect('/user/index');
    }
}
