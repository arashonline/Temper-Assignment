<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    use DatabaseMigrations;
    /**
     * @group login-auth
     *
     * @return void
     */

    public function testOnlyAuthUserCanSeeHome()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->assertPathIs('/login');

        });
    }

    /**
     * @group login
     *
     * @return void
     */
    public function testAUserCanLogin()
    {
       $user = factory(User::class)->create();

       $this->browse(function (Browser $browser) use ($user){
           $browser->visit('/login')
               ->type('email',$user->email)
               ->type('password','password')
               ->press('Login')
               ->assertPathIs('/home');
       });
    }

}
