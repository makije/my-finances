<?php

namespace App\Http\Controllers;

use App\Account;

use App\Actions\Account\AddTransactionToAccountFromCsv;
use App\Transaction;

use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountController extends Controller
{
    public function showAccounts()
    {
        return view('account.list')->with('accounts', request()->user()->accounts);
    }

    public function showAccount(Account $account)
    {
        return view('account.show')->with([
            'account' => $account,
            'transactions' => $account->transactions()->paginate(15),
        ]);
    }

    public function addAccount()
    {
        return view('account.create');
    }

    public function createAccount()
    {
        $account = new Account();
        $account->name = request()->name;
        $account->currency = request()->currency;

        request()->user()->accounts()->save($account);

        return redirect()->action('AccountController@showAccount', ['id' => $account->id]);
    }

    public function addTransaction(Account $account)
    {
        return view('transaction.create')->with('account', $account);
    }

    public function addTransactionToAccount(Account $account)
    {
        $account->addTransaction(
            new Transaction(
                array_merge(
                    request()->all(),
                    [
                        'executed' => Carbon::now(),
                        'rate' => Carbon::now(),
                    ]
                )
            )
        );

        return back();
    }

    public function addTransactionsFromCsvToAccount(Account $account)
    {
        $file = request()->file('csv');
        $handle = fopen($file->getPathname(), 'r');

        $action = new AddTransactionToAccountFromCsv($account, $handle);
        $result = $action->process();

        return back();
    }
}
