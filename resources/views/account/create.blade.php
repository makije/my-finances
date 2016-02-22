@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">New account</div>

                    <div class="panel-body">
                        <form method="POST" action="{{ action('AccountController@createAccount') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <input type="text" class="form-control" name="currency" placeholder="Currency">
                            </div>

                            <button type="submit" class="btn btn-default pull-right">Add account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
