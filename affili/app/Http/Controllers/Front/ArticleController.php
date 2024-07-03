<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    const PAGE_KIND = '記事';
    //
    public function getList(Request $request)
    {
        parent::userPageSetting();

        $contentsCount = 32;

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

        $mdArticle = new Article;
        $articleList = $mdArticle->getListByRequest($arrayRequest, $contentsCount);

        if ($articleList->isNotEmpty()) {
            $articleList->appends($arrayRequest);
        }

        $queryString = '&keyword=' . $arrayRequest['keyword'];

        // ページ名
        $pageTitle = self::PAGE_KIND . '一覧';
        if (isset($arrayRequest['keyword'])) {
            $pageTitle = '「' . $arrayRequest['keyword'] . '」を含む' . $pageTitle;
        }

        // ルート
        $searchRoute = $request->route()->getName();

        return view('front.' . USER_AGENT . '.article.list', 
                    compact(
                        'articleList',
                        'pageTitle',
                        'arrayRequest',
                        'queryString',
                        'searchRoute',
                    )
                );
    }

    public function articleDetail(Request $request)
    {
        parent::userPageSetting();


        $mdArticle = new Article;
        $articleData = $mdArticle->getDataByIdForFront($request);
        $relativeArticleList = $mdArticle->getRelativeArticleListByIdForFront($articleData);

        return view('front.' . USER_AGENT . '.article.detail', 
                    compact(
                        'relativeArticleList',
                        'articleData',
                    )
                );
    }
}
