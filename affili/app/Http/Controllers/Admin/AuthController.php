<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Admin;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{

    const PAGE_KIND = 'ダッシュボード';
    //
    public function showLoginForm() {

        return view('admin.login.loginForm');

    }

    public function login(Request $request) {

        //普通のログイン
        $credentialsPassword = $request->only(['email', 'password']);
        $guard = 'administrator';
        $remember = $request->has('remember');

        if(\Auth::guard($guard)->attempt($credentialsPassword,  $remember)) {
            return redirect()->route('administrator.dashboard'); // ログインしたらリダイレクト
        }

        return back()->withErrors([
            'auth' => ['認証に失敗しました']
        ]);
    }

    public function dashboard(Request $request) {
        $pageName = self::PAGE_KIND;
        return view('admin.login.dashboard', 
            compact(
                'pageName',
            )
        );
    }

    public function logout(Request $request)
    {
        \Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ログアウトしたらログインフォームにリダイレクト
        return redirect()->route('administrator.showLoginForm')->with([
            'auth' => ['ログアウトしました'],
        ]);
    }
}
