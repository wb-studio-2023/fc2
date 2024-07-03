<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \App\Models\Platform;

class PlatformController extends Controller
{
    //
    //
    const PAGE_KIND = 'プラットフォーム(ASP)';

    public function getList(Request $request) {

        $pageName = self::PAGE_KIND . "一覧";
        
        $mdPlatform = new Platform();
        $platformList = $mdPlatform->getList($request);

        return view('admin.platform.list', 
                    compact(
                        'platformList',
                        'pageName',
                    )
                );
    }

    public function registShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ登録フォーム";
        
        return view('admin.platform.regist.form', 
                    compact(
                        'pageName',
                    )
                );
    }

    public function registConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ登録確認画面";
        
        $validated  = $request->validate([
            'name' => ['required', 'string', 'unique:actresses'],
        ],
        [
            'name.required' => '女優名は必須です。',
            'name.string' => '女優名は文字列で記入してください。',
            'name.unique' => 'この女優名は登録してあります。',
        ]);

        $inputData = $request->input();

        return view('admin.platform.regist.confirm', 
                    compact(
                        'pageName',
                        'inputData',
                    )
                );
    }

    public function registExecution(Request $request) {

        $inputData = $request->input();
        $action = $request->input('action');

        if ($action === 'submit') {
            $request->session()->regenerateToken();
            $insertData = $inputData;
            $mdPlatform = new Platform;
            $mdPlatform->insertData($insertData);
        }

        return redirect()->route('administrator.platform.list');
    }

    public function editShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ編集フォーム";
        
        $mdPlatform = new Platform;
        $platformData = $mdPlatform->getDataById($request);

        return view('admin.platform.edit.form', 
                    compact(
                        'platformData',
                        'pageName',
                    )
                );
    }

    public function editConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ編集確認画面";
        
        $validated  = $request->validate([
            'name' => ['required', 'string', Rule::unique('platforms', 'name')->where('delete_flg', config('const.DELETE_FLG_OFF'))->whereNot('id', $request->input('id'))],
        ],
        [
            'name.required' => 'カテゴリーは必須です。',
            'name.string' => 'カテゴリーは文字列で記入してください。',
            'name.unique' => 'このカテゴリーは使われています。',
        ]);

        $inputData = $request->input();

        return view('admin.platform.edit.confirm', 
                    compact(
                        'inputData',
                        'pageName',
                    )
                );
    }

    public function editExecution(Request $request) {

        $inputData = $request->input();
        $action = $request->input('action');

        if ($action === 'submit') {
            $mdPlatform = new Platform();
            $request->session()->regenerateToken();
            $mdPlatform->updateData($inputData);
        }
        return redirect()->route('administrator.platform.list');
    }


    public function deleteExecution(Request $request) {

        $deleteIds = $request->input('delete');

        $request->session()->regenerateToken();
        $mdPlatform = new Platform();
        $mdPlatform->deleteData($deleteIds);

        return redirect()->route('administrator.platform.list');
    }
}
