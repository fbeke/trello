<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    use DatabaseMigrations;

    private $user;


    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->seed();

        $this->user = User::find(2);
    }


    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_successful_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('#email', $this->user->email)
                ->type('#password', 'test')
                ->press('login')
                ->waitUntilMissingText('login')
                ->assertPathIs('/dashboards');
        });
    }


    public function test_unsuccessful_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('#email', $this->user->email)
                ->type('#password', 'wrong password')
                ->press('login')
                ->assertPathBeginsWith('/');
        });
    }
}
