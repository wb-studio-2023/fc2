<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Ingredient;
use Illuminate\Validation\Rule;

class IngredientController extends Controller
{

    const PAGE_KIND = '食材';

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
        
        $mdingredient = new Ingredient();
        $ingredientList = $mdingredient->getList($request);

        if ($ingredientList->isNotEmpty()) {
            $ingredientList->appends($arrayRequest);
        }
        $queryString = '&keyword=' . $arrayRequest['keyword'] . '&sk=' . $arrayRequest['sk'] . '&st=' . $arrayRequest['st'];

        return view('admin.ingredient.list', 
                    compact(
                        'ingredientList',
                        'pageName',
                        'arrayRequest',
                        'queryString',
                    )
                );
    }

    public function registShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ登録フォーム";
        
        return view('admin.ingredient.regist.form', 
                    compact(
                        'pageName',
                    )
                );
    }

    public function registConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ登録確認画面";
        
        $validated  = $request->validate([
            'title' => ['required', 'string', 'unique:ingredients'],
        ],
        [
            'title.required' => '材料名は必須です。',
            'title.string' => '材料名は文字列で記入してください。',
            'title.unique' => 'この食材は登録してあります。',
        ]);

        $inputData = $request->input();

        return view('admin.ingredient.regist.confirm', 
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
            $mdIngredient = new Ingredient;
            $mdIngredient->insertData($insertData);
        }
        return redirect()->route('admin.ingredient.list');
    }

    public function editShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ編集フォーム";
        
        $mdIngredient = new Ingredient;
        $ingredientData = $mdIngredient->getDataById($request);

        return view('admin.ingredient.edit.form', 
                    compact(
                        'ingredientData',
                        'pageName',
                    )
                );
    }

    public function editConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ編集確認画面";
        
        $validated  = $request->validate([
            'title' => ['required', 'string', Rule::unique('ingredients', 'title')->where('delete_flg', config('const.DELETE_FLG_OFF'))->whereNot('id', $request->input('id'))],
        ],
        [
            'title.required' => '食材名は必須です。',
            'title.string' => '食材名は文字列で記入してください。',
            'title.unique' => 'この食材名は使われています。',
        ]);

        $inputData = $request->input();

        return view('admin.ingredient.edit.confirm', 
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
            $mdIngredient = new Ingredient();
            $request->session()->regenerateToken();
            $mdIngredient->updateData($inputData);
        }
        return redirect()->route('admin.ingredient.list');
    }


    public function deleteExecution(Request $request) {

        $deleteIds = $request->input('delete');

        $request->session()->regenerateToken();
        $mdIngredient = new Ingredient();
        $mdIngredient->deleteData($deleteIds);

        return redirect()->route('admin.ingredient.list');
    }
}
