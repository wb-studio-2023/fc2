<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Actress;
use \App\Models\ActressType;
use Illuminate\Validation\Rule;
use Storage;

class ActressController extends Controller
{
    //
    const PAGE_KIND = '女優';

    public function getList(Request $request) {

        $pageName = self::PAGE_KIND . "一覧";

        if ($request->method() === 'POST') {
            $deleteRequest = [];
            $deleteRequest = [
                'st' => null,
                'sk' => null,
                'page' => null
            ];
            $request->merge($deleteRequest);
        }
        $arrayRequest = [
            'keyword' => $request->input('keyword'),
            'sk' => $request->input('sk'),
            'st' => $request->input('st'),
        ];
        
        $mdActress = new Actress();
        $actressList = $mdActress->getList($request);

        if ($actressList->isNotEmpty()) {
            $actressList->appends($arrayRequest);
        }
        $queryString = '&keyword=' . $arrayRequest['keyword'] . '&sk=' . $arrayRequest['sk'] . '&st=' . $arrayRequest['st'];

        return view('admin.actress.list', 
                    compact(
                        'actressList',
                        'pageName',
                        'arrayRequest',
                        'queryString',
                    )
                );
    }

    public function registShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ登録フォーム";

        $mdActressType = new ActressType();
        $actressTypeList = $mdActressType->getListForActress();
        
        return view('admin.actress.regist.form', 
                    compact(
                        'pageName',
                        'actressTypeList',
                    )
                );
    }

    public function registConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ登録確認画面";
        
        $validated  = $request->validate([
            'name' => ['required', 'string', 'unique:actresses'],
            'name_kana' => ['required', 'string', 'unique:actresses'],
        ],
        [
            'name.required' => '女優名は必須です。',
            'name.string' => '女優名は文字列で記入してください。',
            'name.unique' => 'この女優名は登録してあります。',
            'name_kana.required' => '女優名(カナ)は必須です。',
            'name_kana.string' => '女優名(カナ)は文字列で記入してください。',
            'name_kana.unique' => 'この女優名(カナ)は登録してあります。',
        ]);

        $inputData = $this->checkConfirmData($request);
        $eyecatchUrl = "";
        // バケットの`example`フォルダへアップロードする
        $image = $request->file('eyecatch');
        if (isset($image)) {
            $path = Storage::disk('s3')->putFile('/article_eyecatch', $image, 'public');
            // アップロードした画像のフルパスを取得
            $eyecatchUrl = Storage::disk('s3')->url($path);
        }
        $mdActressType = new ActressType();
        $actressTypeList = $mdActressType->getListForActress();

        return view('admin.actress.regist.confirm', 
                    compact(
                        'pageName',
                        'inputData',
                        'actressTypeList',
                        'eyecatchUrl',
                    )
                );
    }

    public function registExecution(Request $request) {

        $inputData = $request->input();
        $action = $request->input('action');

        if ($action === 'submit') {
            $request->session()->regenerateToken();
            $insertData = $inputData;
            $mdActress = new Actress;
            $mdActress->insertData($insertData);
        }

        return redirect()->route('administrator.actress.list');
    }

    public function editShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ編集フォーム";
        
        $mdActress = new Actress;
        $actressDataByDb = $mdActress->getDataById($request);
        $actressData = $this->convertDBData($actressDataByDb);

        $mdActressType = new ActressType();
        $actressTypeList = $mdActressType->getListForActress();

        return view('admin.actress.edit.form', 
                    compact(
                        'actressData',
                        'pageName',
                        'actressTypeList',
                    )
                );
    }


    public function editConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ編集確認画面";

        $validated  = $request->validate([
            'name' => ['required', 'string', Rule::unique('actresses', 'name')->where('delete_flg', config('const.DELETE_FLG_OFF'))->whereNot('id', $request->input('id'))],
            'name_kana' => ['required', 'string', Rule::unique('actresses', 'name_kana')->where('delete_flg', config('const.DELETE_FLG_OFF'))->whereNot('id', $request->input('id'))],
        ],
        [
            'name.required' => '女優名は必須です。',
            'name.string' => '女優名は文字列で記入してください。',
            'name.unique' => 'この女優名は使われています。',
            'name_kana.required' => 'かなは必須です。',
            'name_kana.string' => 'かなは文字列で記入してください。',
            'name_kana.unique' => 'このかなは使われています。',
        ]);

        $inputData = $this->checkConfirmData($request);

        $eyecatchUrl = "";
        // バケットの`example`フォルダへアップロードする
        $image = $request->file('eyecatch');
        if (isset($image)) {
            $path = Storage::disk('s3')->putFile('/article_eyecatch', $image, 'public');
            // アップロードした画像のフルパスを取得
            $eyecatchUrl = Storage::disk('s3')->url($path);
        } else {
            $eyecatchUrl = $request->eyecatch_text;
        }

        $mdActressType = new ActressType();
        $actressTypeList = $mdActressType->getListForActress();


        return view('admin.actress.edit.confirm', 
                    compact(
                        'inputData',
                        'pageName',
                        'actressTypeList',
                        'eyecatchUrl',
                    )
                );
    }

    public function editExecution(Request $request) {

        $inputData = $request->input();
        $action = $request->input('action');

        if ($action === 'submit') {
            $mdActress = new Actress();
            $request->session()->regenerateToken();
            $mdActress->updateData($inputData);
        }
        return redirect()->route('administrator.actress.list');
    }

    public function deleteExecution(Request $request) {

        $deleteIds = $request->input('delete');

        $request->session()->regenerateToken();
        $mdActress = new Actress();
        $mdActress->deleteData($deleteIds);

        return redirect()->route('administrator.actress.list');
    }

    private function convertDBData($inputData)
    {
        $ret = new \stdClass();

        $keepValueList = ['id', 'name', 'name_kana', 'size', 'introduction', 'eyecatch'];
        foreach ($keepValueList as $keepValueKey) {
            $ret->$keepValueKey = null;
            if ( isset($inputData->$keepValueKey) ) {
                $ret->$keepValueKey = $inputData->$keepValueKey;
            }
        }

        $multipleChoiceList = ['type'];
        foreach ($multipleChoiceList as $multipleChoiceKey) {
            $ret->$multipleChoiceKey = null;
            if ( isset($inputData->$multipleChoiceKey) ) {
                $ret->$multipleChoiceKey = explode(',', $inputData->$multipleChoiceKey);
            }
        }

        return $ret; 
    }

    private function checkConfirmData($request)
    {
        $inputData = $request->input();
        $inputData['eyecatch'] = null;
        if ($request->file('eyecatch')) {
            $name = $request->file('eyecatch')->getClientOriginalName();
            $request->file('eyecatch')->storeAs('public/eyecatch', $name);
            $inputData['eyecatch'] = $name;
        } else if ($request->input('eyecatch_text')) {
            $inputData['eyecatch'] = $request->input('eyecatch_text');
        }

        return $inputData;
    }
}
