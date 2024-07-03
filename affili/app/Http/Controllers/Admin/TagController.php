<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Tag;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    //

    const PAGE_KIND = 'タグ';

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
        
        $mdTag = new Tag();
        $tagList = $mdTag->getList($request);

        if ($tagList->isNotEmpty()) {
            $tagList->appends($arrayRequest);
        }
        $queryString = '&keyword=' . $arrayRequest['keyword'] . '&sk=' . $arrayRequest['sk'] . '&st=' . $arrayRequest['st'];

        return view('admin.tag.list', 
                    compact(
                        'tagList',
                        'pageName',
                        'arrayRequest',
                        'queryString',
                    )
                );
    }

    public function registShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ登録フォーム";
        
        return view('admin.tag.regist.form', 
                    compact(
                        'pageName',
                    )
                );
    }

    public function registConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ登録確認画面";
        
        $validated  = $request->validate([
            'name' => ['required', 'string', 'unique:tags'],
        ],
        [
            'name.required' => '材料名は必須です。',
            'name.string' => '材料名は文字列で記入してください。',
            'name.unique' => 'この食材は登録してあります。',
        ]);

        $inputData = $request->input();

        return view('admin.tag.regist.confirm', 
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
            $mdTag = new Tag;
            $mdTag->insertData($insertData);
        }
        return redirect()->route('administrator.tag.list');
    }

    public function editShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ編集フォーム";
        
        $mdTag = new Tag;
        $tagData = $mdTag->getDataById($request);

        return view('admin.tag.edit.form', 
                    compact(
                        'tagData',
                        'pageName',
                    )
                );
    }

    public function editConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ編集確認画面";
        
        $validated  = $request->validate([
            'name' => ['required', 'string', Rule::unique('tags', 'name')->where('delete_flg', config('const.DELETE_FLG_OFF'))->whereNot('id', $request->input('id'))],
        ],
        [
            'name.required' => '食材名は必須です。',
            'name.string' => '食材名は文字列で記入してください。',
            'name.unique' => 'この食材名は使われています。',
        ]);

        $inputData = $request->input();

        return view('admin.tag.edit.confirm', 
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
            $mdTag = new Tag();
            $request->session()->regenerateToken();
            $mdTag->updateData($inputData);
        }
        return redirect()->route('administrator.tag.list');
    }


    public function deleteExecution(Request $request) {

        $deleteIds = $request->input('delete');

        $request->session()->regenerateToken();
        $mdTag = new Tag();
        $mdTag->deleteData($deleteIds);

        return redirect()->route('administrator.tag.list');
    }
}
