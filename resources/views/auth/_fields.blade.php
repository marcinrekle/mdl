@foreach($fields as $field)
	<div class="form-group">
		{{ Form::label($field->name, $field->slug, ['class' => 'col-md-4 control-label']) }}
		<div class="col-md-6">
		@if( $field->type == 'select')
		{{ Form::select("values[$field->name]", $field->options['select'], old("values[$field->name]"), $field->options['attr'] ) }}
		@elseif( $field->type == 'checkbox' ||  $field->type == 'radio')
		{{ Form::{$field->type}("values[$field->name]",1, old('values[$field->name]',''), $field->options['attr']) }}
		@else
		{{ Form::{$field->type}("values[$field->name]",old('values[$field->name]',''), $field->options['attr']) }}
		@endif
        </div>
	</div>
@endforeach