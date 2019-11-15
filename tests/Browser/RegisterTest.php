<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Test if a user can locate to register page
     * @group register
     *
     * @return void
     */
    public function testAUserCanSeeRegisterPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Register')
                ->assertPathIs('/register');
        });
    }

    /**
     *
     * @group register
     *
     * @return void
     */
    public function testAUserCanRegister()
    {
        $user = [
            'name' =>'test_name',
            'email' => 'abc'.rand(1,100).'@email.com',
            'password' => 'password123',
        ];
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/')
                ->clickLink('Register')
                ->type('name', $user['name'])
                ->type('email', $user['email'])
                ->type('password', $user['password'])
                ->type('password_confirmation', $user['password'])
                ->press('Register')
                ->assertPathIs('/home');
        });
    }
}
