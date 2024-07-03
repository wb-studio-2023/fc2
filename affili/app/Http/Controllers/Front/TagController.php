<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Article;

class TagController extends Controller
{
    const PAGE_KIND = 'タグ';

    public function getList(Request $request) {

        parent::userPageSetting();

        // $contentsCount = 10;

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

        $mdTag = new Tag;
        $tagList = $mdTag->getFrontDisplayList(null, $arrayRequest);

        // ページ名
        $pageTitle = self::PAGE_KIND . '一覧';
        if (isset($arrayRequest['keyword'])) {
            $pageTitle = '「' . $arrayRequest['keyword'] . '」を含む' . $pageTitle;
        }

        // ルート
        $searchRoute = $request->route()->getName();

        return view('front.' . USER_AGENT . '.tag.list', 
                    compact(
                        'tagList',
                        'pageTitle',
                        'arrayRequest',
                        'searchRoute',
                    )
                );
    }

    public function getArticleList(Request $request) {

        parent::userPageSetting();

        $contentsCount = 32;

        $mdTag = new Tag;
        $tagData = $mdTag->getDataById($request);

        // ページ名
        $pageTitle = '「#' . $tagData->name . '」の動画一覧';

        $mdArticle = new Article;
        $articleList = $mdArticle->getListByRequest($request, $contentsCount);

        // ルート
        $searchRoute = $request->route()->getName();

        return view('front.' . USER_AGENT . '.tag.article_list', 
                    compact(
                        'articleList',
                        'pageTitle',
                        'searchRoute',
                    )
                );
    }
}
