@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Jazdy <a href="{{route('drive.create')}}" class="pull-right"><i class="fa fa-plus"></i>Dodaj</a></h3>
          </div>
          <div class="panel-body">
              
            <table class="table table-striped">
              <tr>
                <th>Lp</th>
                <th>Instruktor</th>
                <th>Data</th>
                <th>Ilość godzin</th>
                <th>Kursańci</th>
                <th>Operacje</th>
              </tr>

                @foreach($drives as $drive)

                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $drive->user->name }}</td>
                  <td>{{ $drive->date }}</td>
                  <td>{{ $drive->hours_count }}</td>
                  <td>
                    @if( $drive->hours->count() )
                      @foreach( $drive->hours as $hour )
                        {{$hour->user->name}} 
                      @endforeach
                    @endif
                  </td>
                  <td>
                  {{ Html::linkRoute('drive.edit', 'Edytuj', $drive->id, ['class' => 'btn btn-primary'])}}
                  {!! Form::model($drive, [
                    'method' => 'DELETE',
                    'route' => ['drive.destroy', $drive->id],
                    'style' => 'display:inline-block'
                  ]) !!}
                    {{ Html::link('#', 'Usuń', ['class' => 'btn btn-danger'])}}
                  {!! Form::close() !!}
                  </td>
                </tr>
                @endforeach

            </table>

            
          </div>
        </div>
      </div>
    </div>
  </div>
@stop