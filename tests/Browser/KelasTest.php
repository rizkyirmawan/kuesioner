<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class KelasTest extends DuskTestCase
{
    /**
     * [testExample description]
     * @return [type] [description]
     */
    public function testVisitKelas()
    {
        $user = \App\Models\User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit('master/kelas')
                ->assertSee('Data Kelas')
                ->screenshot('Kelas page');
        });
    }

    /**
     * [testCreateKelas description]
     * @return [type] [description]
     */
    public function testCreateKelas()
    {
        $user = \App\Models\User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit('master/kelas')
                ->press('#tambah-data')
                ->type('kode', 'VIP')
                ->type('kelas', 'VIP')
                ->press('#simpan')
                ->assertSee('Berhasil! Data kelas berhasil ditambah.')
                ->screenshot('Kelas create page');
        });
    }

    /**
     * [testCreateKelasDataExist description]
     * @return [type] [description]
     */
    public function testCreateKelasDataExist()
    {
        $user = \App\Models\User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->loginAs($user)
                ->visit('master/kelas')
                ->press('#tambah-data')
                ->type('kode', 'VIP')
                ->type('kelas', 'VIP')
                ->press('#simpan')
                ->assertSee('Kode kelas sudah terdaftar.')
                ->screenshot('Kelas create data exist');
        });
    }
}
