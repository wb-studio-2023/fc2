<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SetOrderToArticlesService;

class SetOrdertoArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-orderto-articles-command';

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
        //
        $fc2Service = new SetOrderToArticlesService();
        $fc2Service->getIdsProcess();

    }
}
