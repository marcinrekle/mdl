@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Role <a href="{{route('permission.create')}}" class="pull-right"><i class="fa fa-plus"></i>Dodaj</a></h3>
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

                @foreach($roles as $role)

                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $role->name }}</td>
                  <td>{{ $role->display_name }}</td>
                  <td>{{ $role->description }}</td>
                  <td>
                  {{ Html::linkRoute('role.edit', 'Edytuj', $role->id, ['class' => 'btn btn-primary'])}}
                  {!! Form::model($role, [
                    'method' => 'DELETE',
                    'route' => ['role.destroy', $role->id],
                    'style' => 'display:inline-block'
                  ]) !!}
                    {{ Html::link('#', 'Usuń', ['class' => 'btn btn-danger'])}}
                  {!! Form::close() !!}
                  {{ Html::linkRoute('role.permission', 'Uprawnienia', $role->id, ['class' => 'btn btn-primary']) }}
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