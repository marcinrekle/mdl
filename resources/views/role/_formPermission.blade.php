{{ csrf_field() }}
@foreach( $permissions as $key => $permission )
  <fieldset>
    <legend>{{ $key }}</legend>
  @foreach( $permission as $item )
      <div class="form-group"> 
    {{ Form::label($item->name, $item->display_name, ['class' => 'col-md-4 control-label']) }}
    {{ Form::checkbox('perms[]',$item->id,$rolePerm->contains($item->name), ['class' => '',]) }}
      </div>
  @endforeach
  </fieldset>
@endforeach


<div class="form-group">
  <div class="col-md-6 col-md-offset-4">
  {{ Form::submit($submitBtnText, ['class' => 'btn btn-primary',]) }}
  </div>
</div>
