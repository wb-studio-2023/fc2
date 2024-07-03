<?php

namespace App\Console\Commands\Fc2;

use Illuminate\Console\Command;
use App\Services\FC2\GetContentsIdFc2Service;

class GetContentsIdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fc2-get-contents-id-command';

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
        $fc2Service = new GetContentsIdFc2Service();
        $fc2Service->process();
    }
}
