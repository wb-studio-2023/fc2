<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;

class CategoryController extends Controller
{
    const PAGE_KIND = 'カテゴリー';

    public function getList(Request $request) {

        parent::userPageSetting();

        $contentsCount = 10;

        if ($request->method() === 'POST') {
            $deleteRequest = [];
            $deleteRequest = [
                'page' => null
            ];

            $request->merge($deleteRequest);
        }

        $arrayRequest = [
            'keyword' => $request->input('keyword'),
        ];

        $mdCategory = new Category;
        $categoryList = $mdCategory->getFrontDisplayList($contentsCount, $arrayRequest);

        // ページ名
        $pageTitle = self::PAGE_KIND . '一覧';
        if (isset($arrayRequest['keyword'])) {
            $pageTitle = '「' . $arrayRequest['keyword'] . '」を含む' . $pageTitle;
        }

        // ルート
        $searchRoute = $request->route()->getName();

        return view('front.' . USER_AGENT . '.category.list', 
                    compact(
                        'categoryList',
                        'pageTitle',
                        'arrayRequest',
                        'searchRoute',
                    )
                );
    }

    public function getArticleList(Request $request) {

        parent::userPageSetting();

        $contentsCount = 10;

        $mdCategory = new Category;
        $categoryData = $mdCategory->getDataById($contentsCount);

        // ページ名
        $pageTitle = $categoryData->name . 'の動画一覧';

        $mdArticle = new Article;
        $articleList = $mdArticle->getListByRequest($request, $contentsCount);

        return view('front.' . USER_AGENT . '.category.article_list', 
                    compact(
                        'articleList',
                        'pageTitle',
                    )
                );
    }
}
