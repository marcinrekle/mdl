@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Godziny <a href="{{route('hour.create')}}" class="pull-right"><i class="fa fa-plus"></i>Dodaj</a></h3>
          </div>
          <div class="panel-body">
              
            <table class="table table-striped">
              <tr>
                <th>Lp</th>
                <th>Kursant</th>
                <th>Ilość godzin</th>
                <th>Instruktor</th>
                <th>Data</th>
                <th>Operacje</th>
              </tr>

                @foreach($hours as $hour)

                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $hour->user->name }}</td>
                  <td>{{ $hour->count }}</td>
                  <td>{{ $hour->drive->user->name }}</td>
                  <td>{{ $hour->drive->date }}</td>
                  <td>
                  {{ Html::linkRoute('hour.edit', 'Edytuj', $hour->id, ['class' => 'btn btn-primary'])}}
                  {!! Form::model($hour, [
                    'method' => 'DELETE',
                    'route' => ['hour.destroy', $hour->id],
                    'style' => 'display:inline-block'
                  ]) !!}
                    <delete-btn></delete-btn>
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