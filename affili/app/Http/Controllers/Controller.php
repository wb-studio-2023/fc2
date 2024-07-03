<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function userPageSetting() {

        $userAgent = 'pc';
        $topSlideCount = 4;
        $topArticleCount = 8;
        $topActressCount = 10;
        $topCategoryCount = 6;
        $topTagCount = 30;

        //user_agent
        if (preg_match("/iPhone|iPod|Android.*Mobile|Windows.*Phone/", $_SERVER['HTTP_USER_AGENT'])) {
            $userAgent = 'sp';
            $topSlideCount = 4;
            $topArticleCount = 4;
            $topActressCount = 4;
            $topCategoryCount = 4;
            $topTagCount = 4;
        }
        
        define("USER_AGENT", $userAgent);
        define("TOP_SLIDE_ARTICLE_COUNT", $topSlideCount);
        define("TOP_ARTICLE_COUNT", $topArticleCount);
        define("TOP_ACTRESS_COUNT", $topActressCount);
        define("TOP_CATEGORY_COUNT", $topCategoryCount);
        define("TOP_TAG_COUNT", $topTagCount);
    }
}
