@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <h1>
                        welcome : {{auth('web')->user()->name}}
                    </h1>
                    <h1>
                        you are : {{auth('web')->user()->is_seller ? 'Seller' : 'Buyer'}}
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
