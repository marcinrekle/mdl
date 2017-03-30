@foreach($fields as $field)
	<div class="form-group">
		<label for="{{ $field->name }}" class="col-md-4 control-label">{{ $field->slug }}</label>
		<div class="col-md-6">
            <input id="{{ $field->name }}" type="{{ $field->type }}" class="form-control" name="attrs.{{ $field->name }}" {{ $field->require ? 'required' : '' }}>
        </div>
	</div>
@endforeach