{{ csrf_field() }}
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

<div class="form-group{{ $errors->has('payment_date') ? ' has-error' : '' }}">
{{ Form::label('payment_date', 'Data', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::date('payment_date', old('payment_date'), ['class' => 'form-control', 'required','autofocus']) }}
  @if ($errors->has('payment_date'))
    <span class="help-block">
        <strong>{{ $errors->first('payment_date') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
{{ Form::label('amount', 'Kwota', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::number('amount', old('amount'), ['class' => 'form-control', 'min' => '30', 'max' => '5000', 'step' => '10', 'required',]) }}
  @if ($errors->has('amount'))
    <span class="help-block">
        <strong>{{ $errors->first('amount') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('payment_for') ? ' has-error' : '' }}">
{{ Form::label('payment_for', 'Za co', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::select('payment_for', $payment_for ,old('payment_for'), ['class' => 'form-control', 'required',]) }}
  @if ($errors->has('payment_for'))
    <span class="help-block">
        <strong>{{ $errors->first('payment_for') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group">
  <div class="col-md-6 col-md-offset-4">
  {{ Form::submit($submitBtnText, ['class' => 'btn btn-primary',]) }}
  </div>
</div>
