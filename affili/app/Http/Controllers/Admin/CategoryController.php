<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    //

    const PAGE_KIND = 'カテゴリー';

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
        
        $mdCategory = new Category();
        $categoryList = $mdCategory->getList($request);

        if ($categoryList->isNotEmpty()) {
            $categoryList->appends($arrayRequest);
        }
        $queryString = '&keyword=' . $arrayRequest['keyword'] . '&sk=' . $arrayRequest['sk'] . '&st=' . $arrayRequest['st'];

        return view('admin.category.list', 
                    compact(
                        'categoryList',
                        'pageName',
                        'arrayRequest',
                        'queryString',
                    )
                );
    }

    public function registShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ登録フォーム";
        
        return view('admin.category.regist.form', 
                    compact(
                        'pageName',
                    )
                );
    }

    public function registConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ登録確認画面";
        
        $validated  = $request->validate([
            'name' => ['required', 'string', 'unique:categories'],
        ],
        [
            'name.required' => 'カテゴリー名は必須です。',
            'name.string' => 'カテゴリー名は文字列で記入してください。',
            'name.unique' => 'このカテゴリーは登録してあります。',
        ]);

        $inputData = $request->input();

        return view('admin.category.regist.confirm', 
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
            $mdCategory = new Category;
            $mdCategory->insertData($insertData);
        }
        return redirect()->route('administrator.category.list');
    }

    public function editShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ編集フォーム";
        
        $mdCategory = new Category;
        $categoryData = $mdCategory->getDataById($request);

        return view('admin.category.edit.form', 
                    compact(
                        'categoryData',
                        'pageName',
                    )
                );
    }

    public function editConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ編集確認画面";
        
        $validated  = $request->validate([
            'name' => ['required', 'string', Rule::unique('categories', 'name')->where('delete_flg', config('const.DELETE_FLG_OFF'))->whereNot('id', $request->input('id'))],
        ],
        [
            'name.required' => 'カテゴリーは必須です。',
            'name.string' => 'カテゴリーは文字列で記入してください。',
            'name.unique' => 'このカテゴリーは使われています。',
        ]);

        $inputData = $request->input();

        return view('admin.category.edit.confirm', 
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
            $mdCategory = new Category();
            $request->session()->regenerateToken();
            $mdCategory->updateData($inputData);
        }
        return redirect()->route('administrator.category.list');
    }


    public function deleteExecution(Request $request) {

        $deleteIds = $request->input('delete');

        $request->session()->regenerateToken();
        $mdCategory = new Category();
        $mdCategory->deleteData($deleteIds);

        return redirect()->route('administrator.category.list');
    }
}
