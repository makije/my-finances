<?php

namespace App\Http\Controllers;

use App\Account;

use App\Transaction;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
                request()->all()
            )
        );

        return back();
    }

    public function addTransactionsFromCsvToAccount(Account $account)
    {
        $file = request()->file('csv');

        $handle = fopen($file->getPathname(), 'r');

        while($line = fgetcsv($handle, 1000, ';'))
        {
            $transaction = Transaction::firstOrNew([
                'statement' => $line[2],
                'amount' => $line[3],
                'balance' => $line[4],
            ]);

            $account->addTransaction($transaction);
        }

        return back();
    }
}
