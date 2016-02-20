<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    public function showWelcome()
    {
        if(request()->user())
        {
            return view('account.list')->with('accounts', request()->user()->accounts);
        }
        else
        {
            return view('welcome');
        }
    }

}
