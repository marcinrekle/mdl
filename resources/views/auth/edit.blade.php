@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edycja użytkownika</a></h3>
                </div>
                <div class="panel-body">
                    {{ Form::model($user,['route' => ['userUpdate', $user->id], 'method' => 'PATCH', ]) }}
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) }}
                            <div class="col-md-6">
                                {{ Form::text('name', old('name'), ['class' => 'form-control', 'max' => '128','required','autofocus']) }}
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {{ Form::label('email', 'email', ['class' => 'col-md-4 control-label']) }}
                            <div class="col-md-6">
                                {{ Form::text('email', old('email'), ['class' => 'form-control', 'max' => '64', 'required',]) }}
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="role" class="col-md-4 control-label">Role</label>

                            <div class="col-md-6">
                                <select id="role" class="form-control" name="role" value="{{ old('role') }}" required>
                                @permission('student-crud')
                                    <option value="student">Kursant</option>
                                @endpermission
                                @permission('instructor-crud')
                                    <option value="instructor">Instruktor</option>
                                @endpermission
                                @permission('officce-crud')
                                    <option value="officce">Biuro</option>
                                @endpermission
                                @permission('admin-crud')
                                    <option value="admin">Admin</option>
                                @endpermission
                                </select>
                                @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        {{ Form::label('status', 'Status', ['class' => 'col-md-4 control-label']) }}
                            <div class="col-md-6">
                            {{ Form::select('status', ['active' => 'Aktywny','disabled' => 'Nieaktywny'],old('status'), ['class' => 'form-control', 'required','autofocus']) }}
                            @if ($errors->has('status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
                            @endif
                            </div>
                        </div>
                        @if (isset($fields))
                        @foreach($fields as $field)
                        <div class="form-group">
                            <label for="{{ $field->name }}" class="col-md-4 control-label">{{ $field->slug }}</label>
                            <div class="col-md-6">
                                <input id="{{ $field->name }}" type="{{ $field->type }}" class="form-control" name="values[{{ $field->name }}]" value="{{ old('values[$field->name]',$user->attrs->values[$field->name]) }}" {{ $field->require ? 'required' : '' }}>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {{ Form::submit('Aktualizuj', ['class' => 'btn btn-primary',]) }}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop