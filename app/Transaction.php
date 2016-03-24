<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'statement',
        'amount',
        'balance',
        'executed',
        'rate',
    ];

    protected $dates = [
        'executed',
        'rate',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

}
