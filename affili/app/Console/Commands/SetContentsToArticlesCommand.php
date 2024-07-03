<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessScrapingJob;
use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use App\Services\SetContentsToArticlesService;


class SetContentsToArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-contents-to-articles-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new SetContentsToArticlesService;
        $service->process(0);

        // $urls = [];
        // for ($i = 0; $i < 10; $i++) {
        //     // 各ループで0～9までのURLを生成
        //     $urls[] = url('/scrape/fc2/setContents/' . $i);
        // }

        // $client = new Client();
        // $requests = function ($urls) use ($client) {
        //     foreach ($urls as $url) {
        //         yield function () use ($client, $url) {
        //             return $client->getAsync($url);
        //         };
        //     }
        // };

        // $pool = new Pool($client, $requests($urls), [
        //     'concurrency' => 5,
        //     'fulfilled' => function ($response, $index) use ($urls) {
        //         echo '成功 url:' . $urls[$index] . PHP_EOL;
        //     },
        //     'rejected' => function ($reason, $index) use ($urls) {
        //         echo '失敗 url:' . $urls[$index] . PHP_EOL;
        //     }
        // ]);

        // // 非同期でリクエストを実行
        // $promise = $pool->promise();
        // $promise->wait();
    }
}
