<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * @group routes
     *
     * @return void
     */
    public function testCanViewHome()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee("Temper Analytic");
    }
}
