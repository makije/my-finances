<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{

    public function showAccounts()
    {
        return view('account.list')->with('accounts', request()->user()->accounts);
    }

    public function addAccount()
    {

    }
}
