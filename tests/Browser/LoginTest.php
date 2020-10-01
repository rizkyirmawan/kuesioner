<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * [testLoginUsingAdministrator description]
     * @return [type] [description]
     */
    public function testLoginUsingAdministratorUser()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/')
                ->type('email', 'admin@example.com')
                ->type('password', 'password')
                ->press('#login')
                ->screenshot('Login page')
                ->assertSee('Dasbor');
        });
    }
}
