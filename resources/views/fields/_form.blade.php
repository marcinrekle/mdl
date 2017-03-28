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
  {{ Form::text('slug', old('slug'), ['class' => 'form-control', 'max' => '64', 'required',]) }}
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
  {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'size' => '30x5', 'required',]) }}
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
    ]) }}
  @if ($errors->has('type'))
    <span class="help-block">
        <strong>{{ $errors->first('type') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
  {{ Form::label('order', 'Order', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::number('order', old('order'), ['class' => 'form-control', 'max' => '24', 'required',]) }}
  @if ($errors->has('order'))
    <span class="help-block">
        <strong>{{ $errors->first('order') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
  {{ Form::label('active', 'Active', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::checkbox('active',1, old('active', $field->active), ['class' => 'form-control',]) }}
  @if ($errors->has('active'))
    <span class="help-block">
        <strong>{{ $errors->first('active') }}</strong>
    </span>
  @endif
  </div>
</div>



<div class="form-group{{ $errors->has('visible') ? ' has-error' : '' }}">
  {{ Form::label('visible', 'Visible', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::checkbox('visible',1, old('visible', $field->visible), ['class' => 'form-control', ]) }}
  @if ($errors->has('visible'))
    <span class="help-block">
        <strong>{{ $errors->first('visible') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group{{ $errors->has('require') ? ' has-error' : '' }}">
  {{ Form::label('require', 'Require', ['class' => 'col-md-4 control-label']) }}
  <div class="col-md-6">
  {{ Form::checkbox('require',1, old('require', $field->require), ['class' => 'form-control',]) }}
  @if ($errors->has('require'))
    <span class="help-block">
        <strong>{{ $errors->first('require') }}</strong>
    </span>
  @endif
  </div>
</div>

<div class="form-group">
  <div class="col-md-6 col-md-offset-4">
  {{ Form::submit($submitBtnText, ['class' => 'btn btn-primary',]) }}
  </div>
</div>
