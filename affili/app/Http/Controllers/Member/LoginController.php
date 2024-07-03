<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use \App\Libraries\LineLoginClass;
use Illuminate\Support\Facades\Log;
use \App\Models\Member;

class LoginController extends Controller
{
    //
    public function showLoginForm(Request $request)
    {
        session(['login.referer' => url()->previous()]);
        parent::userPageSetting();
        return view('front.member.' . USER_AGENT . '.login');
    }

    public function login(Request $request)
    {
        $lineLoginClass = new LineLoginClass;
        return $lineLoginClass->authorize(env('APP_URL').'member/linelink');
    }

    /**
     * LINE連携画面のLINE認証コールバック
     */
    public function lineLink(Request $request)
    {
        $lineLoginClass = new LineLoginClass;

        try {
            // エラーの場合
            if (isset($request['error'])) {
                Log::debug('ERROR :--------------------------------------------------------');
                Log::debug($request['error_description']);
                throw new \Exception("ERROR :AUTH_REDIRECT");
            }

            // 同一チェックが異なる場合
            $postState = session('line.state');
            if ($postState !== $request['state']) {
                Log::debug('ERROR :--------------------------------------------------------');
                throw new \Exception("ERROR :DIFFERENT_STATE");
            }

            // IDトークン取得
            $idToken = $lineLoginClass->getIdToken($request['code']);
            if (!$idToken) {
                throw new \Exception("ERROR :ID_TOKEN");
            }

            // LINEユーザーID取得
            $lineUserDetail = $lineLoginClass->getLineUserDetail($idToken);
            if (!$lineUserDetail['line_user_id']) {
                throw new \Exception("ERROR :LINE_USER_ID");
            }

            // LINE連携存在チェック
            $mbMember = new Member();
            $member = $mbMember->getMemberData($lineUserDetail);

            // 未登録の場合、登録画面にリダイレクト
            if (is_null($member)) {
                // LINEユーザー情報をセッションに保存
                session(['line.user' => $lineUserDetail]);
                $member->id = $mbMember->insertData($lineUserDetail);
            }

            // セッションに保存
            $credentials = [
                'line_user_key' => $lineUserDetail['line_user_id'],
            ];

            $guard = "member";
            if (Auth::guard($guard)->loginUsingId($member->id)) {
                $request->session()->put('id', $member->id);
            }

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            // $this->Flash->error('エラーが発生しました。何度も続く場合は、お問い合わせください。');
            return redirect('/');
        }

        // ホーム画面にリダイレクト
        $pageBeforeLogin = session('login.referer');
        return redirect($pageBeforeLogin);
    }
}
