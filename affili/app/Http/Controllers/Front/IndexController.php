<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Actress;
use App\Models\Category;
use App\Models\Tag;

class IndexController extends Controller
{
    
    public function index(Request $request)
    {
        parent::userPageSetting();

        $mdArticle = new Article;
        // slide用記事取得--新着でいいかな
        $slideArticleList = $mdArticle->getSlideArticleList(TOP_SLIDE_ARTICLE_COUNT);

        // slide用記事取得--新着でいいかな
        $latestArticleList = $mdArticle->getLatestArticleList(TOP_SLIDE_ARTICLE_COUNT);

        // おすすめ記事--取得方法が...
        $recommendArticleList = $mdArticle->getRecommendArticleList(TOP_ARTICLE_COUNT);

        // $mdActress = new Actress;
        // // おすすめ女優リスト取得--取得方法が...一旦、更新日時で
        // $actressList = $mdActress->getFrontDisplayList(TOP_ACTRESS_COUNT);

        // $mdCategory = new Category;
        // // // おすすめカテゴリーリスト取得--取得方法が...一旦、更新日時で
        // $categoryList = $mdCategory->getFrontDisplayList(TOP_CATEGORY_COUNT);

        $mdTag = new Tag;
        $tagList = $mdTag->getFrontDisplayList(TOP_TAG_COUNT);

        return view('front.' . USER_AGENT . '.index.index', 
            compact(
                'slideArticleList',
                'latestArticleList',
                'recommendArticleList',
                'tagList',
            )
        );
    }
}
