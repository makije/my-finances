<?php

use App\User;
use App\Account;
use App\Transaction;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function see_the_account_page_if_logged_in()
    {
        $this->createUserAndLoginTheUserIn();

        $this->visit('/account')
            ->seePageIs('/account')
            ->assertResponseOk();
    }

    /**
     * @test
     */
    public function when_logged_in_see_a_list_of_users_accounts()
    {
        $this->createUserAndLoginTheUserIn();

        $accounts = factory(Account::class, 5)->create();

        $this->user->accounts()->attach($accounts->pluck('id')->all());

        $this->visit('/account')
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

        $this->visit('/account')
            ->see('Accounts')
            ->see($account->name)
            ->see($account->currency)
            ->see($transaction->balance);
    }

    /**
     * @test
     */
    public function see_add_account_button()
    {
        $this->createUserAndLoginTheUserIn();

        $this->visit('/account')
            ->see('Accounts')
            ->see('Add Account');
    }

    /**
     * @test
     */
    public function press_add_account_button()
    {
        $this->createUserAndLoginTheUserIn();

        $this->visit('/')
            ->click('Add Account')
            ->seePageIs('/account/add');
    }
}
