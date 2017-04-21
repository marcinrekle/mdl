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
        @if( Entrust::can('hours-crud') || ( Entrust::can('hours-delete') && Auth::user()->id == $hour->user->id)) 
        <div class="studentActions">  
          {!! Form::model($hour, [
            'method' => 'DELETE',
            'route' => ['hour.destroy', $hour->id]]) 
          !!}
          <div class="form-group">
            <a class="deleteStudent" href="#"><i class="fa fa-trash-o fa-2x text-danger"></i></a>
          </div>
          {!! Form::close() !!}
        </div>
        @endif
      </td>
      @endforeach
      @if((count($drive->hours) < 2))
        @if($drive->hours->pluck('user.id')->search($user->id) === false && $user->canDrive[$key] > 0 )
          <td @if(2-count($drive->hours) > 1) colspan="{{2-count($drive->hours)}}" @endif>
          @php ($val = $drive->hours_count - $drive->hours->sum('count'))
          {!! Form::open( [
                'route' => ['hour.store']
          ]) !!}
          {!! Form::hidden('drive_id', $drive->id) !!}
          {!! Form::hidden('user_id', $user->id) !!}
          {{ Form::number('count', old('count',$val), ['class' => 'form-control', 'min' => '0.5', 'max' => $drive->hours_count - $drive->hours->sum('count'), 'step' => '0.5', 'required',]) }}
          {!! Form::button('<span class="fa fa-plus"></span> Dodaj', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
          {!! Form::close() !!}
          </td>
        @else
          <td @if(2-count($drive->hours) > 1) colspan="{{2-count($drive->hours)}}" @endif></td>
        @endif
      @endif
    </tr>
    @endforeach
  @endforeach
</table>