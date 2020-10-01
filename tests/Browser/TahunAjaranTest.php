<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TahunAjaranTest extends DuskTestCase
{
    /**
     * [testExample description]
     * @return [type] [description]
     */
    public function testExample()
    {
        $user = \App\Models\User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit('master/tahun-ajaran')
                ->assertSee('Data Tahun Ajaran')
                ->screenshot('Tahun ajaran page');
        });
    }
}
