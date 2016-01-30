<?php

use App\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function register_a_user()
    {
        $this->visit('/auth/register')
         ->type('My Name', 'name')
         ->type('myemail@example.com', 'email')
         ->type('mypassword', 'password')
         ->type('mypassword', 'password_confirmation')
         ->press('Register')
         ->seePageIs('/profile');

         $this->seeInDatabase('users', [
             'name' => 'My Name',
             'email' => 'myemail@example.com'
         ]);
    }

    /**
     * @test
     */
    public function log_a_user_in()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('mypassword')
        ]);

        $this->visit('/auth/login')
         ->type($user->email, 'email')
         ->type('mypassword', 'password')
         ->press('Login')
         ->seePageIs('/profile');
    }

    /**
     * @test
     */
    public function user_forgot_password()
    {
        $this->visit('/auth/login')
         ->click('Forgot Your Password?')
         ->seePageIs('/auth/password/reset');
    }

}
