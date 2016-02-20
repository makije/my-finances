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
        return $this->hasMany(Transaction::class)->orderBy('created_at', 'desc');
    }

    public function getCurrentBalance()
    {
        $latestTransaction = $this->transactions()->select('balance')->latest()->first();

        return ($latestTransaction ? $latestTransaction->balance : 0 );
    }

}
