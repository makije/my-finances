<?php

use App\User;
use App\Account;
use App\Transaction;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FrontpageTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     */
    public function see_welcome_and_application_name_when_not_logged_in()
    {
        $this->visit('/')
             ->see('Welcome')
             ->see('My Finances')
             ->see('Login')
             ->see('Register')
             ->dontSee('Accounts')
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

    /**
     * @test
     */
    public function when_logged_in_see_users_name()
    {
        $this->createUserAndLoginTheUserIn();

        $this->visit('/')
             ->see($this->user->name);
    }

    /**
     * @test
     */
    public function when_logged_in_see_a_list_of_users_accounts()
    {
        $this->createUserAndLoginTheUserIn();

        $accounts = factory(Account::class, 5)->create();

        $this->user->accounts()->attach($accounts->pluck('id')->all());

        $this->visit('/')
             ->see('Accounts')
             ->see($accounts->first()->name)
             ->see($accounts->first()->currency);
    }

    /**
     * @test
     */
    public function when_logged_in_see_the_balance_next_to_account_currency()
    {
        $this->createUserAndLoginTheUserIn();

        $account = factory(Account::class)->create();

        $this->user->accounts()->attach($account->id);

        $transaction = factory(Transaction::class)->create([
            'account_id' => $account->id,
            'balance' => 1010101,
        ]);

        $this->visit('/')
            ->see('Accounts')
            ->see($account->name)
            ->see($account->currency)
            ->see($transaction->balance);
    }

}
