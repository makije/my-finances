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
                                    <th class="col-md-8">
                                        Name
                                    </th>
                                    <th class="col-md-2">
                                        Currency
                                    </th>
                                    <th class="col-md-2">
                                        Balance
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accounts as $account)
                                    <tr>
                                        <td class="col-md-8">
                                            <a href="{{ action('AccountController@showAccount', ['id' => $account->id]) }}">{{ $account->name }}</a>
                                        </td>
                                        <td class="col-md-2">
                                            {{ $account->currency }}
                                        </td>
                                        <td class="col-md-2">
                                            {{ $account->getCurrentBalance() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <a href="{{ action('AccountController@addAccount') }}" class="btn btn-default pull-right">Add Account</a>
            </div>
        </div>
    </div>
@endsection
