<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use \App\Models\Article;
use \App\Models\ArticleImage;
use \App\Models\Tag;
use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Laravel\Dusk\Chrome\ChromeProcess;
use Facebook\WebDriver\WebDriverExpectedCondition;

class SetContentsToArticlesService
{
    public function process($num)
    {

        $ignoreMovieIds = [
            4406106,
            4395405,
            3470323,
            4372498,
            4369575,
        ];

        $process = (new ChromeProcess())->toProcess();
        $mdArticle = new Article;

        Log::info('$num：' . $num . '起動');
        Log::channel('scrape_' . $num)->debug('$num：' . $num . '起動');

        try {
            // Seleniumの設定
            $driver = $this->settingChrome($process);

            do {
                $articleInfoList = $mdArticle->getArticleListDivideTen($num);
    
                foreach ($articleInfoList as $articleInfo) {
                    if (in_array($articleInfo->movie_id, $ignoreMovieIds)) {
                        continue;
                    }            
                    $this->toArticlePage($driver, $articleInfo, $num);
                }
            } while ($articleInfoList->isNotEmpty());

        } catch (Exception $e) {
            Log::error($e->getMessage() .  "\n");
        }
   }

    private function settingChrome($process) {
        // if ($process->isStarted()) {
        //     $process->stop();
        // }
        $process->start();

        $options = (new ChromeOptions())->addArguments([
            '--disable-gpu',
            // '--headless=new',
            '--enable-automation',
            '--window-size=1200,1000',
            '--no-sandbox',
            '--no-warnings',
        ]);
        $capabilities = DesiredCapabilities::chrome()->setCapability(ChromeOptions::CAPABILITY, $options);
        

        $driver = retry(5, function () use ($capabilities) {
            return RemoteWebDriver::create('http://localhost:9515', $capabilities, 50000, 60000);
        }, 5000);

        return $driver;
    }

    // private function test($driver) {
    //         // Y◯hoo!さんのニュースサイトに潜入します
    //         $driver->get("https://www.yahoo.co.jp/");

    //         dump($driver->getCurrentUrl());

    //         // waiting for 'footer' id load
    //         $driver->wait(10, 1000)->until(
    //             WebDriverExpectedCondition::visibilityOfElementLocated(
    //                 WebDriverBy::id('footer')
    //             )
    //         );

    //         // Yahoo! top topics
    //         $topics = $driver->findElements(
    //             WebDriverBy::cssSelector('#tabpanelTopics1 ul a')
    //         );
    //         foreach ($topics as $topic) {
    //             $url =  $topic->getAttribute("href");
    //             $title = $topic->findElement(
    //                 WebDriverBy::cssSelector('h1 > span')
    //             )->getText();

    //             var_dump($url . " : " . $title);
    //         }
    //     }
    //    private function settingSelenium() {
    //         $capabilities = DesiredCapabilities::chrome();

    //         $driver = retry(5, function () use ($capabilities) {
    //             return RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities, 50000, 60000);
    //         }, 5000);

    //         return $driver;
    //     }

    private function toArticlePage($driver, $articleInfo, $num) {
            
        Log::channel('scrape_' . $num)->debug('article_id：' . $articleInfo->article_id .  " movie_id：" . $articleInfo->movie_id);
        echo 'article_id：' . $articleInfo->article_id .  " movie_id：" . $articleInfo->movie_id .  "\n";

        // 新着ページでページ数を取得
        $driver->get(config('asp.FC2.ACTICLE_PAGE') . $articleInfo->movie_id . '/');
        $currentUrl = $driver->getCurrentURL();
        echo "スクレイピング開始: $currentUrl\n";
        Log::info('スクレイピング開始：' . $currentUrl);
        $start = microtime(true);

        if (config('asp.FC2.ACTICLE_PAGE') . $articleInfo->movie_id . '/' != $currentUrl) {
            $this->login($driver);
            try {
                $driver->wait(5)->until(
                    WebDriverExpectedCondition::visibilityOfElementLocated(
                        WebDriverBy::cssSelector('.c-modal-101_content .c-btn-102')
                    )
                );
        
                $driver->findElement(WebDriverBy::cssSelector('.c-modal-101_content .c-btn-102'))->click();        
            } catch (Exception $e) {
            }
        } 

        $end = microtime(true);
        $elapsed = $end - $start;
        echo "ページ読み込み時間: " . $elapsed . "秒\n";
        Log::channel('scrape_' . $num)->debug("ページ読み込み時間: " . $elapsed . "秒");

        $tagElementsList = $driver->findElements(WebDriverBy::cssSelector('section.items_article_TagArea a'));
        $tagValue = [];
        foreach ($tagElementsList as $tagElement) {
            $tagValue[] = [
                'name' => $tagElement->getText(),
                'delete_flg' => config('const.DELETE_FLG_OFF'),
                'updated_at' => now(),
            ];
        }

        $end = microtime(true);
        $elapsed = $end - $start;
        echo "Tag取得までの時間: " . $elapsed . "秒\n";
        Log::channel('scrape_' . $num)->debug("Tag取得までの時間: " . $elapsed . "秒");

        // img
        $imgSrcElementsList = $driver->findElements(WebDriverBy::cssSelector('section.items_article_SampleImages ul.items_article_SampleImagesArea li'));
        foreach ($imgSrcElementsList as $imgSrcElement) {
            $imgSrc = $imgSrcElement->findElement(WebDriverBy::cssSelector('img'));
            $imgValues[] = [
                'article_id' => $articleInfo->article_id,
                'site_id' => $articleInfo->site_id,
                'movie_id' => $articleInfo->movie_id,
                'path' => $imgSrc->getAttribute('src'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if (isset($imgValues)) {
            $mdArticleImage = new ArticleImage;
            $mdArticleImage->insertByScraping($imgValues);
        }

        $end = microtime(true);
        $elapsed = $end - $start;
        echo "Image取得＋格納までの時間: " . $elapsed . "秒\n";
        Log::channel('scrape_' . $num)->debug("Image取得＋格納までの時間: " . $elapsed . "秒");

        // tag
        $mdTag = new Tag;
        $tagIds = $mdTag->updateByScraping($tagValue);
        $tagIdsArray = $tagIds->toArray();
        
        // contents
        // ToDo:iflameの中身を取得し、articlesテーブルのmainにinsert
        // $iframeElement = $driver->findElement(WebDriverBy::tagName('iframe'));
        // // iframe要素のsrc属性を取得
        // $iframeSrc = $iframeElement->getAttribute('src');
        // // iframeのsrc属性にアクセスして新しいページを開く
        // $driver->get(config('asp.FC2.ACTICLE_BASE_URL') . $iframeSrc);
        // sleep(30);        
        // // iframe内のHTMLを取得
        // $iframeHtml = $driver->getPageSource();
        // var_dump($iframeHtml);

        $mdArticle = new Article;
        $articleValue = ['movie_id' => $articleInfo->movie_id, 'tag' => implode(',', $tagIdsArray)];
        $tagIds = $mdArticle->updateByScraping($articleValue);

        $end = microtime(true);
        $elapsed = $end - $start;
        echo "Tag格納までの時間: " . $elapsed . "秒\n";
        Log::channel('scrape_' . $num)->debug("Tag格納までの時間: " . $elapsed . "秒");
        Log::channel('scrape_' . $num)->debug('完了：article_id：' . $articleInfo->article_id .  " movie_id：" . $articleInfo->movie_id);
        echo '完了：article_id：' . $articleInfo->article_id .  " movie_id：" . $articleInfo->movie_id .  "\n";

    }

    private function login($driver) {
            
        // 要素が表示されるまで待機
        $driver->wait(60)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::id('email')
            )
        );

        // ログイン情報を入力してログイン
        $driver->findElement(WebDriverBy::id('email'))->sendKeys(config('asp.FC2.ID'));
        $driver->findElement(WebDriverBy::id('pass'))->sendKeys(config('asp.FC2.PASSWORD'));
        $keepLoginCheckbox = $driver->findElement(WebDriverBy::id('keep_login'));
        if (!$keepLoginCheckbox->isSelected()) {
            $keepLoginCheckbox->click();
        }

        // アラートが表示されるまで待機
        $driver->wait(10)->until(WebDriverExpectedCondition::alertIsPresent());

        $alert = $driver->switchTo()->alert();
        $alert->accept();

        $driver->findElement(WebDriverBy::cssSelector('input[type="image"]'))->click();
    }
}
