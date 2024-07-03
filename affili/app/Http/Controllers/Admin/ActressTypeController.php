<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\ActressType;
use Illuminate\Validation\Rule;

class ActressTypeController extends Controller
{
    //

    const PAGE_KIND = '女優タイプ';

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
        
        $mdActressType = new ActressType();
        $actressTypeList = $mdActressType->getList($request);

        if ($actressTypeList->isNotEmpty()) {
            $actressTypeList->appends($arrayRequest);
        }
        $queryString = '&keyword=' . $arrayRequest['keyword'] . '&sk=' . $arrayRequest['sk'] . '&st=' . $arrayRequest['st'];

        return view('admin.actress_type.list', 
                    compact(
                        'actressTypeList',
                        'pageName',
                        'arrayRequest',
                        'queryString',
                    )
                );
    }

    public function registShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ登録フォーム";
        
        return view('admin.actress_type.regist.form', 
                    compact(
                        'pageName',
                    )
                );
    }

    public function registConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ登録確認画面";
        
        $validated  = $request->validate([
            'name' => ['required', 'string', 'unique:actress_types'],
        ],
        [
            'name.required' => '材料名は必須です。',
            'name.string' => '材料名は文字列で記入してください。',
            'name.unique' => 'この食材は登録してあります。',
        ]);

        $inputData = $request->input();

        return view('admin.actress_type.regist.confirm', 
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
            $mdActressType = new ActressType;
            $mdActressType->insertData($insertData);
        }

        return redirect()->route('administrator.actress_type.list');
    }

    public function editShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ編集フォーム";
        
        $mdActressType = new ActressType;
        $actressTypeData = $mdActressType->getDataById($request);

        return view('admin.actress_type.edit.form', 
                    compact(
                        'actressTypeData',
                        'pageName',
                    )
                );
    }

    public function editConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ編集確認画面";
        
        $validated  = $request->validate([
            'name' => ['required', 'string', Rule::unique('actress_types', 'name')->where('delete_flg', config('const.DELETE_FLG_OFF'))->whereNot('id', $request->input('id'))],
        ],
        [
            'name.required' => '食材名は必須です。',
            'name.string' => '食材名は文字列で記入してください。',
            'name.unique' => 'この食材名は使われています。',
        ]);

        $inputData = $request->input();

        return view('admin.actress_type.edit.confirm', 
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
            $mdActressType = new ActressType();
            $request->session()->regenerateToken();
            $mdActressType->updateData($inputData);
        }
        return redirect()->route('administrator.actress_type.list');
    }


    public function deleteExecution(Request $request) {

        $deleteIds = $request->input('delete');

        $request->session()->regenerateToken();
        $mdActressType = new ActressType();
        $mdActressType->deleteData($deleteIds);

        return redirect()->route('administrator.actress_type.list');
    }
}
