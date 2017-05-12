@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Edycja uprawnienia</a></h3>
          </div>
          <div class="panel-body">
            {{ Form::model($permission,['route' => ['permission.update', $permission->id], 'method' => 'PATCH', ]) }}
              @include('permission._form',['submitBtnText' => 'Aktualizuj'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop