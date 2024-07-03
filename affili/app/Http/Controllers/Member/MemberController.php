<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    //
    public function showLoginForm() {
        return view('member.login');
    }

    public function login(Request $request) {

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => config('const.STATUS.VERIFIED'),
            'delete_flg' => config('const.DELETE_FLG_OFF'),
        ];
        $guard = 'member';

        if(\Auth::guard($guard)->attempt($credentials)) {
            return redirect()->route('member.dashboard'); // ログインしたらリダイレクト

        }

        return back()->withErrors([
            'auth' => ['認証に失敗しました']
        ]);
    }

    public function dashboard(Request $request) {
        var_dump('memberHOME');
    }

}
