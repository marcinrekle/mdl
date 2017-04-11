{{ csrf_field() }}
<div class="form-group{{ $errors->has('drive_id') ? ' has-error' : '' }}">
{{ Form::label('drive_id', 'Jazda', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::select('drive_id', $drive,old('drive_id'), ['class' => 'form-control', 'required','autofocus']) }}
  @if ($errors->has('drive_id'))
    <span class="help-block">
        <strong>{{ $errors->first('drive_id') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
{{ Form::label('user_id', 'Kursant', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::select('user_id', $user,old('user_id'), ['class' => 'form-control', 'required','autofocus']) }}
  @if ($errors->has('user_id'))
    <span class="help-block">
        <strong>{{ $errors->first('user_id') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('count') ? ' has-error' : '' }}">
{{ Form::label('count', 'Ilość godzin', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::number('count', old('count'), ['class' => 'form-control', 'min' => '0.5', 'max' => '8', 'step' => '0.5', 'required',]) }}
  @if ($errors->has('count'))
    <span class="help-block">
        <strong>{{ $errors->first('count') }}</strong>
    </span>
  @endif
  </div>
</div>


<div class="form-group">
  <div class="col-md-6 col-md-offset-4">
  {{ Form::submit($submitBtnText, ['class' => 'btn btn-primary',]) }}
  </div>
</div>
