@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Uprawnienia <a href="{{route('permission.create')}}" class="pull-right"><i class="fa fa-plus"></i>Dodaj</a></h3>
          </div>
          <div class="panel-body">
              
            <table class="table table-striped">
              <tr>
                <th>Lp</th>
                <th>Nazwa systemowa</th>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Operacje</th>
              </tr>

                @foreach($permissions as $permission)

                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $permission->name }}</td>
                  <td>{{ $permission->display_name }}</td>
                  <td>{{ $permission->description }}</td>
                  <td>
                  {{ Html::linkRoute('permission.edit', 'Edytuj', $permission->id, ['class' => 'btn btn-primary'])}}
                  {!! Form::model($permission, [
                    'method' => 'DELETE',
                    'route' => ['permission.destroy', $permission->id],
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