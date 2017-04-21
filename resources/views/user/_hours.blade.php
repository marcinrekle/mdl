<table class="table table-striped">
  <tr>
    <th>Data</th>
    <th>Ilość</th>
    @permission('hour-crud','hour-edit')<th>Edycja</th>@endpermission
  </tr>
    @foreach($user->hours->sortByDesc('drive.date') as $hour)
    <tr>
      <td>{{ date('Y-m-d', strtotime($hour->drive->date)) }}</td>
      <td>{{ $hour->count }}</td>
      @permission(['hour-crud','hour-edit','hour-delete'])
      <td>
        @permission(['hour-crud','hour-edit'])
        <a href="{{route('hour.edit',[$hour->id])}}" class="edit"><i class="fa fa-pencil fa-2x"></i></a>
        @endpermission
        @permission(['hour-crud','hour-delete'])
        {!! Form::model($hour, [
            'method' => 'DELETE',
            'route' => ['hour.destroy',$hour->id]
            ]) !!}
            <div class="form-group">
              <a class="delete" href="#"><i class="fa fa-trash-o fa-2x text-danger"></i></a>
            </div>
        {!! Form::close() !!}
        @endpermission
      </td>
      @endpermission
    </tr>
    @endforeach
    @if( $user->old_hours > 0)
    <tr>
      <td colspan="2">Wcześniejsze godziny</td>
      <td>{{$user->old_hours}}</td>
    </tr>
    @endif
</table>