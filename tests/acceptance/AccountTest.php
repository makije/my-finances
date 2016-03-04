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

    /**
     * @test
     */
    public function fill_the_add_account_form()
    {
        $this->createUserAndLoginTheUserIn();

        $this->visit('/account/add')
             ->see('New account')
             ->see('Name')
             ->see('Currency')
             ->type('My new account', '#name')
             ->type('my currency', '#currency')
             ->press('Add account')
             ->seeInDatabase('accounts', ['name' => 'My new account', 'currency' => 'my currency'])
             ->seeInDatabase('account_user', ['account_id' => 1, 'user_id' => 1])
             ->seePageIs('/account/1')
             ->assertResponseOk();
    }

    /**
     * @test
     */
    public function on_the_account_page_see_the_account_name()
    {
        $this->createUserAndLoginTheUserIn();

        $account = new Account();
        $account->name = 'Name';
        $account->currency = 'currency';

        $this->user->accounts()->save($account);

        $this->visit('/account/' . $account->id)
             ->see('name')
             ->see('currency');
    }

    /**
     * @test
     */
    public function on_the_account_page_see_transactions()
    {
        $this->createUserAndLoginTheUserIn();

        $account = factory(Account::class)->create();

        $transactions = factory(Transaction::class, 10)->create(['account_id' => $account->id]);

        $this->visit('/account/' . $account->id)
            ->see($account->name)
            ->see($account->currency);

        foreach($transactions as $transaction)
        {
            $this->see($transaction->statement);
            $this->see($transaction->amount);
            $this->see($transaction->balance);
        }
    }

    /**
     * @test
     */
    public function click_on_account_goes_to_account_details()
    {
        $this->createUserAndLoginTheUserIn();

        $account = factory(Account::class)->create();

        $this->user->accounts()->attach($account->id);

        factory(Transaction::class)->create([
            'account_id' => $account->id,
            'balance' => 1010101,
        ]);

        $this->visit('/account')
            ->click($account->name)
            ->seePageIs('/account/' . $account->id);
    }

    /**
     * @test
     */
    public function see_add_transactions_button()
    {
        $this->createUserAndLoginTheUserIn();

        $account = factory(Account::class)->create();

        $this->visit('/account/' . $account->id)
            ->see('Add transaction(s)');
    }

    /**
     * @test
     */
    public function press_the_add_transactions_button()
    {
        $this->createUserAndLoginTheUserIn();

        $account = factory(Account::class)->create();

        $this->visit('/account/' . $account->id)
            ->click('Add transaction(s)')
            ->seePageIs('/account/' . $account->id . '/add-transaction');
    }

    /**
     * @test
     */
    public function see_the_add_transaction_form()
    {
        $this->createUserAndLoginTheUserIn();

        $account = factory(Account::class)->create();

        $this->visit('/account/' . $account->id . '/add-transaction')
            ->see('Statement')
            ->see('Balance')
            ->see('Amount')

            ->type('Statement', 'statement')
            ->type(10000, 'amount')
            ->type(100000, 'balance')
            ->press('Add transaction')

            ->seeInDatabase('transactions', [
                'statement' => 'Statement',
                'amount' => 10000,
                'balance' => 100000
            ]);
    }

    /**
     * @test
     */
    public function see_the_add_transaction_from_csv()
    {
        $this->createUserAndLoginTheUserIn();

        $account = factory(Account::class)->create();

        $this->visit('/account/' . $account->id . '/add-transaction')
             ->see("Add transactions from CSV")
             ->see("CSV")
             ->see("Add transactions");
    }
}
