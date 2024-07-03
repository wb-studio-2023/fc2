<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actress;
use App\Models\Article;

class ActressController extends Controller
{
    const PAGE_KIND = '女優';

    public function getList(Request $request) {

        parent::userPageSetting();

        $contentsCount = 20;

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

        $mdActress = new Actress;
        $actressList = $mdActress->getFrontDisplayList($contentsCount, $arrayRequest);

        if ($actressList->isNotEmpty()) {
            $actressList->appends($arrayRequest);
        }

        $queryString = '&keyword=' . $arrayRequest['keyword'];

        // ページ名
        $pageTitle = self::PAGE_KIND . '一覧';
        if (isset($arrayRequest['keyword'])) {
            $pageTitle = '「' . $arrayRequest['keyword'] . '」を含む' . $pageTitle;
        }

        // ルート
        $searchRoute = $request->route()->getName();

        return view('front.' . USER_AGENT . '.actress.list', 
                    compact(
                        'actressList',
                        'pageTitle',
                        'arrayRequest',
                        'queryString',
                        'searchRoute',
                    )
                );
    }

    public function getArticleList(Request $request) {

        parent::userPageSetting();

        $contentsCount = 1;

        $mdActress = new Actress;
        $actressData = $mdActress->getDataById($request);

        $mdArticle = new Article;
        $articleList = $mdArticle->getListByRequest($request, $contentsCount);

        return view('front.' . USER_AGENT . '.actress.article_list', 
                    compact(
                        'articleList',
                        'actressData'
                    )
                );
    }
}
