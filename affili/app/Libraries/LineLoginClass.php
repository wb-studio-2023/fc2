<?php

namespace App\Libraries;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
 * LINE 共通処理
 */
class LineLoginClass {

    /**
     * 認可アクション
     * 
     * @param $redirectUrl LINEプラットフォームに登録済みのコールバックURL
     */
    public function authorize($redirectUrl)
    {
        // 認可URL
        $authorizeURL = 'https://access.line.me/oauth2/v2.1/authorize';

        // リダイレクトURL
        session(['line.redirect_url' => $redirectUrl]);

        // PKCE対応用コード
        $codeVerifier = $this->base64url_encode(random_bytes(32));
        session(['line.code_verifier' => $codeVerifier]);

        // XSS対策パラメータ
        $state = $this->getRandomString();
        session(['line.state' => $state]);

        // 攻撃対策
        $nonce = $this->getRandomString();
        session(['line.nonce' => $nonce]);

        // クエリパラメータ
        $params = [
            'response_type'         => 'code',
            'client_id'             => env('LINE_CLIENT_ID'),
            'redirect_uri'          => $redirectUrl,
            'state'                 => $state,
            'scope'                 => 'openid',
            'nonce'                 => $nonce,
            'code_challenge'        => $this->base64url_encode(hash('sha256', $codeVerifier, true)),
            'code_challenge_method' => 'S256',
            'bot_prompt'            => 'aggressive'
        ];
        $queryParam = [];
        foreach ($params as $key => $value) {
            $queryParam[] = $key. '='. $value;
        }
        $qeury = implode('&', $queryParam);
        return redirect($authorizeURL. '?'. $qeury);
    }

    /**
     * アクセストークンの取得
     * 
     * @param string $code LINEプラットフォームから受け取った認可コード
     */
    public function getIdToken($code)
    {
        // アクセストークン取得先
        $url = 'https://api.line.me/oauth2/v2.1/token';

        // リダイレクトURL
        $redirectUrl = session('line.redirect_url');

        // PKCE対応用コード
        $codeVerifier = session('line.code_verifier');

        // パラメータ
        $param = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUrl,
            'client_id' => env('LINE_CLIENT_ID'),
            'client_secret' => env('LINE_CLIENT_SECRET'),
            'code_verifier' => $codeVerifier
        ];

        // ヘッダー
        $options = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        // API
        $response = $this->apiRequest('POST', $url, $param, $options);
        if (!$response) {
            return false;
        }

        return $response['id_token'];
    }

    /**
     * LINEユーザーIDの取得
     * 
     * @param string $idToken LINEプラットフォームから受け取ったIDトークン
     */
    public function getLineUserId($idToken)
    {
        // アクセストークン取得先
        $url = 'https://api.line.me/oauth2/v2.1/verify';

        // 攻撃対策用コード
        $nonce = session('line.nonce');

        // パラメータ
        $param = [
            'id_token' => $idToken,
            'client_id' => env('LINE_CLIENT_ID'),
            'nonce' => $nonce
        ];

        // ヘッダー
        $options = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        // API
        $response = $this->apiRequest('POST', $url, $param, $options);
        if (!$response) {
            return false;
        }

        return $response['sub'];
    }

    /**
     * LINEユーザー情報の取得
     * 
     * @param string $idToken LINEプラットフォームから受け取ったIDトークン
     */
    public function getLineUserDetail($idToken)
    {
        // アクセストークン取得先
        $url = 'https://api.line.me/oauth2/v2.1/verify';

        // 攻撃対策用コード
        $nonce = session('line.nonce');

        // パラメータ
        $param = [
            'id_token' => $idToken,
            'client_id' => env('LINE_CLIENT_ID'),
            'nonce' => $nonce
        ];

        // ヘッダー
        $options = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        // API
        $response = $this->apiRequest('POST', $url, $param, $options);
        if (!$response) {
            return false;
        }

        $result = [
            'line_user_id' => $response['sub'],
            'email'        => $response['email'] ?? null
        ];

        return $result;
    }

    /**
     * ランダム文字列を取得
     */
    function getRandomString($length = 8, $symbol = false)
    {
        $range = $symbol ? '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-._~' : '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return array_reduce(range(1, $length), function($p) use($range){ return $p.str_shuffle($range)[0]; });
    }

    /**
     * BASE64URL形式のエンコード
     */
    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * LINE API 接続
     * 
     * @param $method
     * @param $url
     * @param $param
     * @param $header
     */
    private function apiRequest($method, $url, $param, $header)
    {
        try {
            if ($method === 'POST') {
                $response = Http::asForm()->withHeaders($header)->post($url, $param);
            } elseif ($method === 'GET') {
                $response = Http::withHeaders($header)->get($url, $param);
            }

            // HTTPステータスコードが400 or 500系の場合エラー
            if (!$response->successful()) {
                Log::debug('ERROR ---------------------------------------------------------');
                Log::debug('REQUEST');
                Log::debug('- URL   :'. json_encode($url));
                Log::debug('- HEADER:'. json_encode($header));
                Log::debug('- PARAM :'. json_encode($param));
                Log::debug('RESPONSE');
                Log::debug('- STATUS :'. $response->status());
                Log::debug(json_encode($response->json()));
                Log::debug('---------------------------------------------------------------');
                throw new \Exception("[{$url}] API HTTP status is 400 or 500");
            }

            $responseBody = $response->json();
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return false;
        }

        return $responseBody;
    }

}