@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Aktywacja zakończona pomyślnie</div>

                <div class="panel-body">
                    <h4>Gratulujemy Twoje konto zostało aktywowane</h4>
                    <a href="{{ url('/home') }}">Przejdż do swojego profilu</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection