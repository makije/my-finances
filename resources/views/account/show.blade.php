@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $account->name }} ({{ $account->currency }})</div>

                    <div class="panel-body">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-7">
                                        Statement
                                    </th>
                                    <th class="col-md-1">
                                        Amount
                                    </th>
                                    <th class="col-md-1">
                                        Balance
                                    </th>
                                    <th class="col-md-3">
                                        At
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="col-md-7">
                                            {{ $transaction->statement }}
                                        </td>
                                        <td class="col-md-1">
                                            {{ number_format($transaction->amount / 100, 2, ',', '.') }}
                                        </td>
                                        <td class="col-md-1">
                                            {{ number_format($transaction->balance / 100, 2, ',', '.') }}
                                        </td>
                                        <td class="col-md-3">
                                            {{ $transaction->executed->toDateString() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="pull-right">
                            <a href="{{ action('AccountController@addTransaction', $account) }}" class="btn btn-primary">Add transaction(s)</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                {!! $transactions->render() !!}
            </div>
        </div>

    </div>
@endsection
