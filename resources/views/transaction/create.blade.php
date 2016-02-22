@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><a href="{{ action('AccountController@showAccount', $account) }}">{{ $account->name }} ({{ $account->currency }})</a></div>

                    <div class="panel-body">

                        <form method="POST" action="{{ action('AccountController@addTransaction', $account) }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="statement">Statement</label>
                                <input type="text" class="form-control" name="statement" placeholder="Statement">
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" min="0" step="1" class="form-control" name="amount" placeholder="Amount">
                            </div>
                            <div class="form-group">
                                <label for="balance">Balance</label>
                                <input type="number" class="form-control" name="balance" placeholder="Balance">
                            </div>

                            <button type="submit" class="btn btn-default pull-right">Add transaction</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
