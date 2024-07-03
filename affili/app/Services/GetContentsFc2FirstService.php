<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Chrome\ChromeProcess;
use Exception;
use \App\Models\Article;

class GetContentsFc2FirstService
{
    public function getIdsProcess()
    {

        $process = (new ChromeProcess())->toProcess();

        try {
            // $lastTimePageNumber = 3300;
            $lastTimePageNumber = 0;

            // chromeの設定
            $driver = $this->settingChrome($process);

            // login
            $this->login($driver);

            // login→コンテンツリストのページ(新着ページ)へ
            $this->toAffiliListPage($driver);

            // 新着ページから順にデータ取得
            $this->performOperationsWithinPage($driver, $lastTimePageNumber);

        } catch (Exception $e) {
            Log::error($e->getMessage() .  "\n");
        } finally {
            $process->stop();
        }
   }

    private function settingChrome($process) {
        if ($process->isStarted()) {
            $process->stop();
        }
        $process->start();

        $options = (new ChromeOptions())->addArguments([
            '--disable-gpu',
            '--enable-automation',
            '--window-size=1200,1000',
            '--headless',
            '--no-sandbox',
            '--no-warnings',
        ]);
        $capabilities = DesiredCapabilities::chrome()->setCapability(ChromeOptions::CAPABILITY, $options);

        $driver = retry(5, function () use ($capabilities) {
            return RemoteWebDriver::create('http://localhost:9515', $capabilities, 50000, 60000);
        }, 5000);

        return $driver;
    }

    private function login($driver) {
            
        // 新着ページでページ数を取得
        $driver->get(config('asp.FC2.LOGIN_PAGE'));

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

    private function toAffiliListPage($driver) {

        $driver->wait(60)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::cssSelector('.m-hder-1000_inBoxArea .c-btn-201:nth-child(2)')
            )
        );

        $driver->findElement(WebDriverBy::cssSelector('.m-hder-1000_inBoxArea .c-btn-201:nth-child(2)'))->click();

        $driver->wait(60)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::cssSelector('.m-globalMenu-1100_navA li:nth-child(4)')
            )
        );

        $driver->findElement(WebDriverBy::cssSelector('.m-globalMenu-1100_navA li:nth-child(4)'))->click();

        $driver->wait(60)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::cssSelector('.m-globalMenu-1100_navA li:nth-child(4) ul li:nth-child(1)')
            )
        );

        $driver->findElement(WebDriverBy::cssSelector('.m-globalMenu-1100_navA li:nth-child(4) ul li:nth-child(1)'))->click();

        $driver->wait(60)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::cssSelector('.contents_block a[href="?order=new"]')
            )
        );

        $driver->findElement(WebDriverBy::cssSelector('.contents_block a[href="?order=new"]'))->click();
    }


    function performOperationsWithinPage($driver, $lastTimePageNumber) {
        // 次のページが存在するかどうかを確認
        while ($driver->findElement(WebDriverBy::cssSelector('.contents_block .pager .next a'))->isEnabled()) {

            // $pageUrlArray = explode('&page=', $driver->getCurrentURL());
            // $pageNumber = isset($pageUrlArray[1]) ? $pageUrlArray[1] : 1;

            // if ($lastTimePageNumber - 4 > (int)$pageNumber) {
            //     $nextPage = $pageNumber + 3;
            //     $driver->findElement(WebDriverBy::cssSelector('.contents_block .pager .analyticsLinkClick_pagerTo' . (string)$nextPage))->click();
            // } else {
                $this->getContentIds($driver);
    
                // 次のページへ移動する
                $nextPageLink = $driver->findElement(WebDriverBy::cssSelector('.contents_block .pager .next a'));
                $nextPageLink->click();    
            // }
            
        }
    }

    private function getContentIds($driver) {

        $currentUrl = $driver->getCurrentURL();
        echo "現在のURL: $currentUrl\n";
        Log::info('開始：' . $currentUrl);

        $tableRows = $driver->findElements(WebDriverBy::cssSelector('.contents_block table.purchase_history tbody tr'));

        // 各行の情報を取得
        $value = [];

        foreach ($tableRows as $row) {
            // 画像のソースを取得
            $imgSrcElement = $row->findElement(WebDriverBy::cssSelector('td:nth-child(1) img'));
            $imgSrc = $imgSrcElement->getAttribute('src');

            // テキスト情報を取得
            $textElement = $row->findElement(WebDriverBy::cssSelector('td:nth-child(2) a'));
            $text = $textElement->getText();

            // リンクの ID を取得
            $linkElement = $row->findElement(WebDriverBy::cssSelector('td:nth-child(5) a'));
            $linkId = parse_url($linkElement->getAttribute('href'), PHP_URL_QUERY);
            parse_str($linkId, $linkIdParts);
            $linkId = isset($linkIdParts['id']) ? $linkIdParts['id'] : null;

            echo "リンクの ID: $linkId\n";

            $value[] = [
                'site_id' => config('const.SITE.FC2'),
                'movie_id' => $linkId,
                'actress_id' => null,
                'title' => $text,
                'headline' => $text,
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

        $mdArticle = new Article;
        $mdArticle->scrapingBulkInsert($value);

        Log::info('完了：' . $currentUrl);

    }
}
