<table class="table table-striped">
  <tr class="no-border">
    <th>Data</th>
    <th>1</th>
    <th>2</th>
  </tr>

  @foreach($instructor->drives as $key => $drives)
    @foreach($drives as $drive)
    <tr data-did="{{ $drive->id }}" data-week="{{ $key }}">
      <td>{{ date('Y-m-d', strtotime($drive->date)) }}</td>
      @foreach($drive->hours as $hour)
      <td data-hid="{{$hour->id}}" data-sid="{{ $hour->user->id }}" data-week="{{ $key }}">
        <img src="{{ $hour->user->avatar }}" style="width:25px;display:inline-block" class="img-responsive img-circle avatar avatar-small" />
        <span>
          <a href="{{route('user.show',$hour->user->id)}} ">{{ $hour->user->name." - ".$hour->count." h" }}</a>
        </span>
        @if( Laratrust::can('hours-crud') || Laratrust::can(['hours-edit','user-delete'])) 
        <div class="studentActions">  
          @permission(['hours-crud','hours-update'])
            {{ Html::link('#', 'Edytuj', ['class' => 'btn btn-primary'])}}
          @endpermission
          @permission(['hours-crud','hours-delete'])
          {!! Form::model($hour, [
            'method' => 'DELETE',
            'route' => ['hour.destroy', $hour->id]]) 
          !!}
          <div class="form-group">
            <delete-btn></delete-btn>
          </div>
          {!! Form::close() !!}
        </div>
        @endpermission
        @endif
      </td>
      @endforeach
      @if((count($drive->hours) < 2))
        <td @if(2-count($drive->hours) > 1) colspan="{{2-count($drive->hours)}}" @endif>
        @php ($val = $drive->hours_count - $drive->hours->sum('count'))

          {!! Form::open( [
                'route' => ['hour.store']
          ]) !!}
          {!! Form::hidden('drive_id', $drive->id) !!}
          {{ Form::select('user_id', $canDriveList[$key],old('user_id'), ['class' => 'form-control', 'required','autofocus']) }}
          {{ Form::number('count', old('count',$val), ['class' => 'form-control', 'min' => '0.5', 'max' => $drive->hours_count - $drive->hours->sum('count'), 'step' => '0.5', 'required',]) }}
          {!! Form::button('<span class="fa fa-plus"></span> Dodaj', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
          {!! Form::close() !!}

        </td>
      
      @endif
    </tr>
    @endforeach
  @endforeach
</table>