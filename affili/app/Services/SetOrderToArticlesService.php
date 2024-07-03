<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use \App\Models\Article;
use Exception;

class SetOrderToArticlesService
{
    public function getIdsProcess()
    {

        try {

            $mdArticle = new Article;
            $batchSize = 30000;

            do {
                $articles = $mdArticle->getNullOrderArticles($batchSize);
                $maxNumber = $mdArticle->getMaxOrderArticles();
                $this->setOrderToArticles($maxNumber, $articles);
                $cntArticles = count($articles);
                unset($articles);
                var_dump($cntArticles . '件完了！');
                sleep(5);
            } while ($cntArticles > 0);

        } catch (Exception $e) {
            Log::error($e->getMessage() .  "\n");
        }
   }

    private function setOrderToArticles($maxNumber, $articles) {

        if (count($articles) == 0) {
            Log::info('作成するデータはありません');
            return;
        }

        Log::info('データ作成開始');

        $value = [];

        foreach ($articles as $key => $article) {
            $value[] = [
                'id' => $article->id,
                'order' => $maxNumber + $key + 1,
                'updated_at' => now(),
            ];
        }

        Log::info('データ作成更新');

        $batchSize = 1000; // 100件ずつのバッチに分割
        $updateDataChunks = array_chunk($value, $batchSize);

        $mdArticle = new Article;
        foreach ($updateDataChunks as $updateData) {
            $mdArticle->updateOrderToArticles($updateData);
        }

        Log::info('完了：' . count($articles) . '件');

    }
}
