<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \App\Models\Platform;
use \App\Models\Site;

class SiteController extends Controller
{
    //
    const PAGE_KIND = 'ターゲットサイト';

    public function getList(Request $request) {

        $pageName = self::PAGE_KIND . "一覧";
        
        $mdSite = new Site();
        $siteList = $mdSite->getList($request);

        return view('admin.site.list', 
                    compact(
                        'siteList',
                        'pageName',
                    )
                );
    }

    public function registShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ登録フォーム";
        
        $mdPlatform = new Platform();
        $platformList = $mdPlatform->getList($request);

        return view('admin.site.regist.form', 
                    compact(
                        'pageName',
                        'platformList',
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

        $mdPlatform = new Platform();
        $platformList = $mdPlatform->getList($request);

        return view('admin.site.regist.confirm', 
                    compact(
                        'pageName',
                        'inputData',
                        'platformList',
                    )
                );
    }

    public function registExecution(Request $request) {

        $inputData = $request->input();
        $action = $request->input('action');

        if ($action === 'submit') {
            $request->session()->regenerateToken();
            $insertData = $inputData;
            $mdSite = new Site();
            $mdSite->insertData($insertData);
        }

        return redirect()->route('administrator.site.list');
    }

    public function editShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ編集フォーム";
        
        $mdSite = new Site();
        $siteData = $mdSite->getDataById($request);

        $mdPlatform = new Platform();
        $platformList = $mdPlatform->getList($request);

        return view('admin.site.edit.form', 
                    compact(
                        'siteData',
                        'platformList',
                        'pageName',
                    )
                );
    }

    public function editConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ編集確認画面";
        
        $validated  = $request->validate([
            'name' => ['required', 'string', Rule::unique('sites', 'name')->where('delete_flg', config('const.DELETE_FLG_OFF'))->whereNot('id', $request->input('id'))],
        ],
        [
            'name.required' => 'カテゴリーは必須です。',
            'name.string' => 'カテゴリーは文字列で記入してください。',
            'name.unique' => 'このカテゴリーは使われています。',
        ]);

        $inputData = $request->input();

        $mdPlatform = new Platform();
        $platformList = $mdPlatform->getList($request);

        return view('admin.site.edit.confirm', 
                    compact(
                        'inputData',
                        'pageName',
                        'platformList',
                    )
                );
    }

    public function editExecution(Request $request) {

        $inputData = $request->input();
        $action = $request->input('action');

        if ($action === 'submit') {
            $mdSite = new Site();
            $request->session()->regenerateToken();
            $mdSite->updateData($inputData);
        }
        return redirect()->route('administrator.site.list');
    }

    public function deleteExecution(Request $request) {

        $deleteIds = $request->input('delete');

        $request->session()->regenerateToken();
        $mdSite = new Site();
        $mdSite->deleteData($deleteIds);

        return redirect()->route('administrator.site.list');
    }
}
