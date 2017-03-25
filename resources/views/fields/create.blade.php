@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Dodawanie pola</a></h3>
          </div>
          <div class="panel-body">
            {{ Form::open(['route' => ['field.create'], 'method' => 'POST', ]) }}
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {{ Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                {{ Form::text('name', old('name'), ['class' => 'form-control', 'max' => '64', 'required','autofocus']) }}
                @if ($errors->has('name'))
                  <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                {{ Form::label('slug', 'Slug', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                {{ Form::text('slug', old('slug'), ['class' => 'form-control', 'max' => '64', 'required','autofocus']) }}
                @if ($errors->has('slug'))
                  <span class="help-block">
                      <strong>{{ $errors->first('slug') }}</strong>
                  </span>
                @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {{ Form::label('description', 'Description', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'size' => '30x5', 'required','autofocus']) }}
                @if ($errors->has('description'))
                  <span class="help-block">
                      <strong>{{ $errors->first('description') }}</strong>
                  </span>
                @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                {{ Form::label('type', 'Type', ['class' => 'col-md-4 control-label']) }}
                <div class="col-md-6">
                {{ Form::select('type', [
                    'input' => 'Pole tekstowe',
                    'select' => 'Pole wyboru',
                    'textarea' => 'Pole opisowe',
                    'radio' => 'Pole wyboru'],
                    'input', [
                    'class' => 'form-control',
                    'required',
                    'autofocus',
                  ]) }}
                @if ($errors->has('type'))
                  <span class="help-block">
                      <strong>{{ $errors->first('type') }}</strong>
                  </span>
                @endif
                </div>
              </div>

            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop