@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Lista <a href="{{route('register')}}" class="pull-right"><i class="fa fa-plus"></i>Dodaj</a></h3>
          </div>
          <div class="panel-body">
              
            <table class="table table-striped">
              <tr>
                <th>Lp</th>
                <th>Imię Nazwisko</th>
                <th>Adres E-mail</th>
                <th>Status</th>
                <th>Operacje</th>
              </tr>
              @foreach($users as $user)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>
                  <a href="{{route('user.show',$user->id)}}">{{ $user->name }}</a>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->status }}</td>
                <td>
                  @permission(['user-update','user-crud'])
                    <a href="{{route('user.edit',[$user->id])}}" class="edit"><i class="fa fa-pencil fa-2x"></i></a>
                  @endpermission
                  @permission('user-delete','user-crud')
                    {!! Form::model($user, [
                      'method' => 'DELETE',
                      'route' => ['user.destroy',$user->id]
                    ]) !!}
                    <div class="form-group">
                      <a class="delete" href="#"><i class="fa fa-trash-o fa-2x text-danger"></i></a>
                    </div>
                    {!! Form::close() !!} 
                  @endpermission
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