<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Article;
use Illuminate\Validation\Rule;
use \App\Models\Tag;
use \App\Models\Material;
use \App\Models\Actress;
use \App\Models\Category;
use \App\Models\Site;
use Carbon\Carbon;
use DateTime;
use Storage;

class ArticleController extends Controller
{
    //

    const PAGE_KIND = '記事';

    public function getList(Request $request) {

        $pageName = self::PAGE_KIND . "一覧";

        $status = null;
        $statusString = null;
        if ($request->method() === 'POST') {
            $deleteRequest = [];
            $deleteRequest = [
                'st' => null,
                'sk' => null,
                'page' => null
            ];
            $request->merge($deleteRequest);
            $status = $request->input('status');
            if ($request->input('status')) {
                $statusString = join(',', $request->input('status'));
            }
        } else {
            $status = explode(',', $request->input('status'));
            $statusString = $request->input('status');
        }

        $arrayRequest = [
            'keyword' => $request->input('keyword'),
            'status' => $statusString,
            'sk' => $request->input('sk'),
            'st' => $request->input('st'),
        ];
        
        $convertRequest = [
            'status' => $status,
        ];
        
        $mdArticle = new Article();
        $articleList = $mdArticle->getList($arrayRequest, $convertRequest);

        if ($articleList->isNotEmpty()) {
            $articleList->appends($arrayRequest);
        }

        $queryString = '&keyword=' . $arrayRequest['keyword'] . '&status=' . $statusString . '&sk=' . $arrayRequest['sk'] . '&st=' . $arrayRequest['st'];
        return view('admin.article.list', 
                    compact(
                        'articleList',
                        'pageName',
                        'arrayRequest',
                        'queryString',
                        'convertRequest',
                    )
                );
    }

    public function registShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ登録フォーム";

        $mdActress = new Actress();
        $actressList = $mdActress->getListForArticle();
        $mdCategory = new Category();
        $categoryList = $mdCategory->getListForArticle();
        $mdTag = new Tag();
        $tagList = $mdTag->getListForArticle();
        $mdSIte = new Site();
        $siteList = $mdSIte->getListForArticle();

        return view('admin.article.regist.form', 
                    compact(
                        'pageName',
                        'actressList',
                        'categoryList',
                        'tagList',
                        'siteList',
                    )
                );
    }

    public function registConfirm(Request $request) {

        $pageName = self::PAGE_KIND . "データ登録確認画面";
        $inputData = $this->checkConfirmData($request);
        $eyecatchUrl = "";
        // バケットの`example`フォルダへアップロードする
        $image = $request->file('eyecatch');

        if (isset($image)) {
            $path = Storage::disk('s3')->putFile('/article_eyecatch', $image, 'public');
            // アップロードした画像のフルパスを取得
            $eyecatchUrl = Storage::disk('s3')->url($path);
        }

        $mdActress = new Actress();
        $actressList = $mdActress->getListForArticle();
        $mdCategory = new Category();
        $categoryList = $mdCategory->getListForArticle();
        $mdTag = new Tag();
        $tagList = $mdTag->getListForArticle();
        $mdSIte = new Site();
        $siteList = $mdSIte->getListForArticle();

        return view('admin.article.regist.confirm', 
                    compact(
                        'pageName',
                        'inputData',
                        'actressList',
                        'categoryList',
                        'tagList',
                        'siteList',
                        'eyecatchUrl',
                    )
                );
    }

    public function registExecution(Request $request) {

        $inputData = $request->input();
        $action = $request->input('action');

        if ($action === 'submit') {
            $request->session()->regenerateToken();
            $insertData = $this->adjustInputData($inputData);
            $mdArticle = new Article;
            $insertArticleId = $mdArticle->insertData($insertData);
        }

        return redirect()->route('administrator.article.list');
    }

    public function editShowForm(Request $request) {

        $pageName = self::PAGE_KIND . "データ編集フォーム";
        
        $mdArticle = new Article;
        $baseArticleData = $mdArticle->getDataById($request);
        $articleData = $this->convertDBData($baseArticleData);

        $mdActress = new Actress();
        $actressList = $mdActress->getListForArticle();
        $mdCategory = new Category();
        $categoryList = $mdCategory->getListForArticle();
        $mdTag = new Tag();
        $tagList = $mdTag->getListForArticle();
        $mdSIte = new Site();
        $siteList = $mdSIte->getListForArticle();

        return view('admin.article.edit.form', 
                    compact(
                        'articleData',
                        'pageName',
                        'actressList',
                        'categoryList',
                        'tagList',
                        'siteList',
                    )
                );
    }

    public function editConfirm(Request $request) {
        
        $pageName = self::PAGE_KIND . "データ編集確認画面";
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

        $mdActress = new Actress();
        $actressList = $mdActress->getListForArticle();
        $mdCategory = new Category();
        $categoryList = $mdCategory->getListForArticle();
        $mdTag = new Tag();
        $tagList = $mdTag->getListForArticle();
        $mdSIte = new Site();
        $siteList = $mdSIte->getListForArticle();

        return view('admin.article.edit.confirm', 
                    compact(
                        'inputData',
                        'pageName',
                        'actressList',
                        'categoryList',
                        'tagList',
                        'eyecatchUrl',
                        'siteList',
                    )
                );
    }

    public function editExecution(Request $request) {

        $inputData = $request->input();
        $action = $request->input('action');

        if ($action === 'submit') {
            $mdArticle = new Article();
            $request->session()->regenerateToken();
            $updateData = $this->adjustInputData($inputData);
            $mdArticle->updateData($updateData);
        }

        return redirect()->route('administrator.article.list');
    }


    public function deleteExecution(Request $request) {

        $deleteIds = $request->input('delete');

        $request->session()->regenerateToken();
        $mdArticle = new Article();
        $mdArticle->deleteData($deleteIds);

        return redirect()->route('administrator.article.list');
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

        //公開時
        if ($request->input('status') == config('const.ARTICLE.STATUS.RELEASED.NUMBER')) {
            $validated  = $request->validate(
                [
                    'title' => ['required', 'string'],
                    'headline' => ['required', 'string'],
                    'main' => ['required'],
                ],
                config('validate.MESSAGE_ADMIN')
            );
        }

        return $inputData;
    }


    private function adjustInputData($inputData)
    {
        $ret = [];
        //
        $keepValueList = ['site_id', 'movie_id', 'title', 'headline', 'eyecatch', 'main', 'category', 'status'];
        if ($inputData['kind_flg'] == 'edit') {
            $keepValueList[] = 'id';
        }
        foreach ($keepValueList as $keepValueKey) {
            $ret[$keepValueKey] = null;
            if ( isset($inputData[$keepValueKey]) ) {
                $ret[$keepValueKey] = $inputData[$keepValueKey];
            }
        }

        //食材・タグ・特徴
        $multipleChoiceList = ['ingredient', 'tag', 'feature', 'actress'];
        foreach ($multipleChoiceList as $multipleChoiceKey) {
            $ret[$multipleChoiceKey] = null;
            if ( isset($inputData[$multipleChoiceKey]) ) {
                $ret[$multipleChoiceKey] = join(',', $inputData[$multipleChoiceKey]);
            }
        }

        // //ステータス
        // $ret['status'] = $inputData['status'];
        // if ($inputData['status'] == config('const.ARTICLE.STATUS.WAITING.SEARCH_NUMBER')) {
        //     $ret['status'] = config('const.ARTICLE.STATUS.WAITING.NUMBER');
        // }

        // //公開時間
        // $ret['release_at'] = $inputData['release_year'] . '-' . str_pad($inputData['release_month'], 2, 0, STR_PAD_LEFT) . '-' . str_pad($inputData['release_day'], 2, 0, STR_PAD_LEFT) . ' ' . str_pad($inputData['release_hour'], 2, 0, STR_PAD_LEFT) . ':' . str_pad($inputData['release_minute'], 2, 0, STR_PAD_LEFT);

        // //材料
        // if ( isset($inputData['material_name']) && !(count($inputData['material_name']) == 1 && $inputData['material_name'][0] == null ) ) {
        //     foreach ($inputData['material_name'] as $key => $value) {
        //         $ret['material'][$key] = [
        //             'name' => $value,
        //             'quantity' => $inputData['material_quantity'][$key],
        //             'unit' => $inputData['material_unit'][$key],
        //         ];
        //     }
        // }

        return $ret; 
    }

    private function convertDBData($inputData)
    {
        $ret = new \stdClass();

        $keepValueList = ['id', 'site_id', 'movie_id', 'title', 'headline', 'eyecatch', 'main', 'category', 'status', 'type'];
        foreach ($keepValueList as $keepValueKey) {
            $ret->$keepValueKey = null;
            if ( isset($inputData->$keepValueKey) ) {
                $ret->$keepValueKey = $inputData->$keepValueKey;
            }
        }

        //食材・タグ・特徴
        $multipleChoiceList = ['ingredient', 'tag', 'feature', 'actress_id'];
        foreach ($multipleChoiceList as $multipleChoiceKey) {
            $ret->$multipleChoiceKey = null;
            if ( isset($inputData->$multipleChoiceKey) ) {
                $ret->$multipleChoiceKey = explode(',', $inputData->$multipleChoiceKey);
            }
        }

        //食材・タグ・特徴
        $multipleChoiceList = ['actress_id'];
        foreach ($multipleChoiceList as $multipleChoiceKey) {
            $ret->actress = null;
            if ( isset($inputData->$multipleChoiceKey) ) {
                $ret->actress = explode(',', $inputData->$multipleChoiceKey);
            }
        }

        // //ステータス
        // $ret->status = $inputData->status;
        // $currentDateTime = Carbon::now();
        // if (
        //     $inputData->status == config('const.ARTICLE.STATUS.RELEASED.NUMBER')
        //     && $inputData->release_at > $currentDateTime
        // ) {
        //     $ret->status = config('const.ARTICLE.STATUS.WAITING.NUMBER');
        // }

        // //公開時間
        // $releaseAt = new DateTime($inputData->release_at);
        // $ret->release_year = $releaseAt->format('Y');
        // $ret->release_month = $releaseAt->format('m');
        // $ret->release_day = $releaseAt->format('d');
        // $ret->release_hour = $releaseAt->format('H');
        // $ret->release_minute = $releaseAt->format('i');

        return $ret; 
    }
}
