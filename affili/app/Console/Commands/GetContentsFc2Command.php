<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Services\GetContentsFc2Service;
use Tests\Browser\ExampleTest;


class GetContentsFc2Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-contents-fc2-command';
    protected $description = 'Get contents from FC2';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $fc2Service = new GetContentsFc2Service();
        $fc2Service->getIdsProcess();
    }
}
