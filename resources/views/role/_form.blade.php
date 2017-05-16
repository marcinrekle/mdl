{{ csrf_field() }}
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
{{ Form::label('name', 'Nazwa systemowa', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::text('name',old('name'), ['class' => 'form-control', 'required','autofocus','placeholder' => '','min' => 3, 'max' => 32]) }}
  @if ($errors->has('name'))
    <span class="help-block">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
{{ Form::label('display_name', 'Nazwa', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::text('display_name',old('display_name'), ['class' => 'form-control', 'required','autofocus','min' => 3, 'max' => 32]) }}
  @if ($errors->has('display_name'))
    <span class="help-block">
        <strong>{{ $errors->first('display_name') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
{{ Form::label('description', 'Opis', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::textarea('description',old('description'), ['class' => 'form-control', 'required','autofocus']) }}
  @if ($errors->has('description'))
    <span class="help-block">
        <strong>{{ $errors->first('description') }}</strong>
    </span>
  @endif
  </div>
</div>


<div class="form-group">
  <div class="col-md-6 col-md-offset-4">
  {{ Form::submit($submitBtnText, ['class' => 'btn btn-primary',]) }}
  </div>
</div>
