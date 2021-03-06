<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('executed', 'desc');
    }

    public function getCurrentBalance()
    {
        $latestTransaction = $this->transactions()->select('balance')->latest()->first();

        return ($latestTransaction ? $latestTransaction->balance : 0 );
    }

    public function addTransaction(Transaction $transaction)
    {
        return $this->transactions()->save($transaction);
    }
}
