<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Chrome\ChromeProcess;
use Exception;
use \App\Models\Article;

class GetContentsFc2Service
{
    public function getIdsProcess()
    {

        $process = (new ChromeProcess())->toProcess();

        try {
            $mdArticle = new Article;
            $latestId = $mdArticle->getMaxOrderArticles();

            // Seleniumの設定
            $driver = $this->settingSelenium();

            // // login
            // $this->login($driver);

            // login→コンテンツリストのページ(新着ページ)へ
            $this->toAffiliListPage($driver);

            // 新着ページから順にデータ取得
            $this->performOperationsWithinPage($driver, $latestId);

        } catch (Exception $e) {
            Log::error($e->getMessage() .  "\n");
        } finally {
            $process->stop();
        }
   }

    private function settingSelenium() {
        $capabilities = DesiredCapabilities::chrome();

        $driver = retry(5, function () use ($capabilities) {
            return RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities, 50000, 60000);
        }, 5000);

        return $driver;
    }

    // private function login($driver) {
            
    //     // 新着ページでページ数を取得
    //     $driver->get(config('asp.FC2.LOGIN_PAGE'));

    //     // 要素が表示されるまで待機
    //     $driver->wait(60)->until(
    //         WebDriverExpectedCondition::visibilityOfElementLocated(
    //             WebDriverBy::id('email')
    //         )
    //     );

    //     // ログイン情報を入力してログイン
    //     $driver->findElement(WebDriverBy::id('email'))->sendKeys(config('asp.FC2.ID'));
    //     $driver->findElement(WebDriverBy::id('pass'))->sendKeys(config('asp.FC2.PASSWORD'));
    //     $keepLoginCheckbox = $driver->findElement(WebDriverBy::id('keep_login'));
    //     if (!$keepLoginCheckbox->isSelected()) {
    //         $keepLoginCheckbox->click();
    //     }

    //     // アラートが表示されるまで待機
    //     $driver->wait(10)->until(WebDriverExpectedCondition::alertIsPresent());

    //     $alert = $driver->switchTo()->alert();
    //     $alert->accept();

    //     $driver->findElement(WebDriverBy::cssSelector('input[type="image"]'))->click();
    // }

    private function toAffiliListPage($driver) {

        // 新着ページでページ数を取得
        $driver->get('https://adult.contents.fc2.com/');

        sleep(3);

        try {
            $driver->findElement(WebDriverBy::cssSelector('.c-modal-101_content .c-btn-102'))->click();        
        } catch (Exception $e) {
        }

        $driver->findElement(WebDriverBy::cssSelector('.Topcontents_Cnt section:nth-of-type(2) a'))->click();
    }

    function performOperationsWithinPage($driver, $latestId) {

        $currentUrl = $driver->getCurrentURL();
        echo "現在のURL: $currentUrl\n";
        Log::info('開始：' . $currentUrl);

        $stopFlg = $this->getContentIds($driver, $latestId);

        // もし $stopFlg が 1 なら処理を終了する
        if ($stopFlg === 1) {
            throw new Exception("Stop flag is set. Exiting process.");
        }

        // URL を解析してクエリパラメーターを取得
        $currentUrl = $driver->getCurrentURL();
        Log::info('完了：' . $currentUrl);
        $query = parse_url($currentUrl, PHP_URL_QUERY);
        parse_str($query, $params);
        $pageNumber = isset($params['page']) ? $params['page'] : 1;
        $nextPageNumber = $pageNumber + 1;

        // 新着ページでページ数を取得
        $href = 'div.c-pager-101 a';
        // 次のページへ移動する
        $nextPageLinksDiv = $driver->findElement(WebDriverBy::cssSelector('.c-pager-101'));
        if ($nextPageLinksDiv) {
            Log::info('ある。');
        } else {
            Log::info('次のページが見つかりませんでした。');
        }
        $nextPageLinks = $nextPageLinksDiv->findElements(WebDriverBy::tagName('a'));

        foreach ($nextPageLinks as $link) {
            $href = $link->getAttribute('href');
            $query = parse_url($href, PHP_URL_QUERY);
            parse_str($query, $params);
            echo $params['page'];
            if ($params['page'] == $nextPageNumber) {
                var_dump('aa');
                $driver->executeScript("arguments[0].click();", [$link]);
                var_dump('11');
                // $link->click();                
                break;
            }
        }
    }

    private function getContentIds($driver, $latestId) {

        $stopFlg = 0;

        $contentsList = $driver->findElements(WebDriverBy::cssSelector('section.search_cntFlexWp .c-cntCard-110-f'));

        // 各行の情報を取得
        $value = [];

        foreach ($contentsList as $contents) {
            // 画像のソースを取得
            $imgSrcElement = $contents->findElement(WebDriverBy::cssSelector('img'));
            $imgSrc = $imgSrcElement->getAttribute('src');

            // title属性を取得
            $title = $contents->findElement(WebDriverBy::cssSelector('a.c-cntCard-110-f_thumb_link'))->getAttribute('title');

            // href属性から数字を抽出
            $href = $contents->findElement(WebDriverBy::cssSelector('a.c-cntCard-110-f_thumb_link'))->getAttribute('href');
            preg_match('/\/(\d+)\//', $href, $matches);
            $id = $matches[1];

            if ($id == $latestId) {
                $stopFlg++;
            }

            echo "リンクの ID: $id\n";

            $value[] = [
                'site_id' => config('const.SITE.FC2'),
                'movie_id' => $id,
                'actress_id' => null,
                'title' => $title,
                'headline' => $title,
                'eyecatch' => $imgSrc,
                'main' => null,
                'category' => null,
                'tag' => null,
                'type' => 0,
                'status' => config('const.ARTICLE.STATUS.PREPARATION.NUMBER'),
                'delete_flg' => config('const.DELETE_FLG_OFF'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // $mdArticle = new Article;
        // $mdArticle->scrapingBulkInsert($value);

        return $stopFlg;
    }
}
