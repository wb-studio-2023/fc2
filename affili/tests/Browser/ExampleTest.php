<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testGoogleSearch()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://www.google.com')
                    ->waitFor('input[name="q"]', 10) // 10秒待つ
                    ->type('q', 'Laravel Dusk')
                    ->press('input[name="btnK"]')
                    ->waitForText('Laravel Dusk', 10) // 検索結果が表示されるまで待つ
                    ->assertSee('Laravel Dusk');
        });
    }
}
