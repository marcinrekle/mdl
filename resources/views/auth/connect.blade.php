@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">LUB</div>
                <div class="panel-body">
                    <a href="{{url('/auth/facebook')}}" class="btn btn-primary" role="button"><i class="fa fa-facebook-official fa-lg"></i> Połącz z Facebook</a>
                    <a href="{{url('/auth/google')}}" class="btn btn-danger" role="button"><i class="fa fa-google fa-lg"></i> Połacz z Gmail</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
