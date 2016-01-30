<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FrontpageTest extends TestCase
{
    /**
     * @test
     */
    public function see_welcome_and_laravel()
    {
        $this->visit('/')
             ->see('Welcome')
             ->see('Laravel')
             ->see('Login')
             ->see('Register')
             ->assertResponseOk();
    }

    /**
     * @test
     */
    public function click_register()
    {
        $this->visit('/')
         ->click('Register')
         ->seePageIs('/auth/register');
    }

    /**
     * @test
     */
    public function click_login()
    {
        $this->visit('/')
         ->click('Login')
         ->seePageIs('/auth/login');
    }

}
