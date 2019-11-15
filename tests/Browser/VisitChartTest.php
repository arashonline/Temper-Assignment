<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VisitChartTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Users with admin@temper.works is a temper admin, so he should be able to see the temper chart
     * @group temper
     *
     * @return void
     */
    public function testOnlyTemperUserAdminCanSeeChart()
    {
        $temper_user =  [
            'email' => 'admin@temper.works',
        ];
        $user = factory(User::class)->create($temper_user);
        $this->browse(function (Browser $browser) use ($user){
            $browser->loginAs($user)
                ->visit('/analytic/')
                ->assertSee('Temper Chart')
            ;
        });
    }
    use DatabaseMigrations;

    /**
     * Users which not Temper admin can't see the chart
     * @group temper
     *
     * @return void
     */
    public function testNonTemperUserCanNotSeeChart()
    {

        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user){
            $browser->loginAs($user)
                ->visit('/analytic/')
                ->assertSee('Only Temper admins are allowed to visit this page.')
            ;
        });
    }

}
