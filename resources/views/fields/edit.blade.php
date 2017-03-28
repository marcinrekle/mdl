@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Edycja pola</a></h3>
          </div>
          <div class="panel-body">
            {{ Form::model($field,['route' => ['field.update', $field->id], 'method' => 'PATCH', ]) }}
              @include('fields._form',['submitBtnText' => 'Aktualizuj'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop