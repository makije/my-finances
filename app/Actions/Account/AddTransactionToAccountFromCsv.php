<?php

namespace App\Actions\Account;

use App\Account;
use Carbon\Carbon;
use App\Transaction;

class AddTransactionToAccountFromCsv
{

    /**
     * @var Account
     */
    private $account;

    private $csv;

    public function __construct(Account $account, $csv)
    {
        $this->account = $account;
        $this->csv = $csv;
    }

    private function doConvertion($amount)
    {
        $amount = str_replace('.', '', $amount);
        $amount = str_replace(',', '.', $amount);

        return ((float)$amount) * 100;
    }

    /**
     * @return bool
     */
    public function process()
    {
        while($line = fgetcsv($this->csv, 1000, ';'))
        {
            $transaction = Transaction::firstOrNew([
                'statement' => $line[2],
                'amount' => $this->doConvertion($line[3]),
                'balance' => $this->doConvertion($line[4]),
                'executed' => Carbon::createFromFormat('d-m-Y', $line[0]),
                'rate' => Carbon::createFromFormat('d-m-Y', $line[1])
            ]);

            if(!$this->account->addTransaction($transaction))
            {
                return false;
            }
        }

        return true;
    }

}