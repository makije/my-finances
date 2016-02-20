@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $account->name }} ({{ $account->currency }})</div>

                    <div class="panel-body">

                        <table>
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
                                            {{ $transaction->amount }}
                                        </td>
                                        <td class="col-md-1">
                                            {{ $transaction->balance }}
                                        </td>
                                        <td class="col-md-3">
                                            {{ $transaction->created_at }}
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
            <div class="col-md-4 col-md-offset-4">
                {!! $transactions->render() !!}
            </div>
        </div>

    </div>
@endsection
