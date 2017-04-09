{{ csrf_field() }}
<div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
{{ Form::label('user_id', 'Instruktor', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::select('user_id', $user,old('user_id'), ['class' => 'form-control', 'required','autofocus']) }}
  @if ($errors->has('user_id'))
    <span class="help-block">
        <strong>{{ $errors->first('user_id') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
{{ Form::label('date', 'Data', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::date('date[date]', old('date[date]',\Carbon\Carbon::now()->format('Y-m-d')), ['class' => 'form-control', 'required','autofocus']) }}
  {{ Form::time('date[time]', old('date[time]','07:00'), ['class' => 'form-control', 'required','autofocus']) }}
  @if ($errors->has('date'))
    <span class="help-block">
        <strong>{{ $errors->first('date') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('hours_count') ? ' has-error' : '' }}">
{{ Form::label('hours_count', 'Ilość godzin', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::number('hours_count', old('hours_count'), ['class' => 'form-control', 'min' => '0.5', 'max' => '8', 'step' => '0.5', 'required',]) }}
  @if ($errors->has('hours_count'))
    <span class="help-block">
        <strong>{{ $errors->first('hours_count') }}</strong>
    </span>
  @endif
  </div>
</div>


<div class="form-group">
  <div class="col-md-6 col-md-offset-4">
  {{ Form::submit($submitBtnText, ['class' => 'btn btn-primary',]) }}
  </div>
</div>
