<?php

use App\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function see_the_profile_page_if_logged_in()
    {
        $this->createUserAndLoginTheUserIn();

        $this->visit('/profile')
             ->seePageIs('/profile')
             ->assertResponseOk();
    }

    /**
     * @test
     */
    public function trying_to_access_profile_without_being_logged_in_redirects_to_login()
    {
        $this->visit('/profile')
             ->seePageIs('/auth/login');
    }

    /**
     * @test
     */
    public function see_account_menu_entry()
    {
        $this->createUserAndLoginTheUserIn();

        $this->visit('/')
             ->see('My Accounts');
    }

}
