@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Accounts</div>

                <div class="panel-body">

                    <table>
                        <thead>
                            <tr>
                                <th class="col-xs-4">Name</th>
                                <th class="col-xs-2">Currency</th>
                                <th class="col-xs-4">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $account)
                                <tr>
                                    <td class="col-xs-4">
                                        {{ $account->name }}
                                    </td>
                                    <td class="col-xs-2">
                                        {{ $account->currency }}
                                    </td>
                                    <td class="col-xs-4">
                                        {{ $account->getCurrentBalance() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="{{ action('AccountController@addAccount') }}">Add Account</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
