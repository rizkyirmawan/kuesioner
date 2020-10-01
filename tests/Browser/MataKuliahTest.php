<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MataKuliahTest extends DuskTestCase
{
    /**
     * [testVisitMataKuliah description]
     * @return [type] [description]
     */
    public function testVisitMataKuliah()
    {
        $user = \App\Models\User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit('master/mata-kuliah')
                ->assertSee('Data Mata Kuliah')
                ->screenshot('Mata kuliah page');
        });
    }
}
