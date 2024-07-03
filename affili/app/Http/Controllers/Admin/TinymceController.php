<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class TinymceController extends Controller
{

    public function upload(Request $request)
    {
        $fileName = $request->file('file')->getClientOriginalName();
        $file = $request->file('file');
        $path = Storage::disk('s3')->putFile('/article_main', $file, 'public');
        // アップロードした画像のフルパスを取得
        $eyecatchUrl = Storage::disk('s3')->url($path);

        return response()->json(['location' => $eyecatchUrl]);
    }
}