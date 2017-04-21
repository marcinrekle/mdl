@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Lista kursantów <a href="{{route('register')}}" class="pull-right"><i class="fa fa-plus"></i>Dodaj</a></h3>
          </div>
          <div class="panel-body">
              
            <table class="table table-striped">
              <tr>
                <th>Lp</th>
                <th>Imię Nazwisko</th>
                <th>Adres E-mail</th>
                <th>Rola</th>
                <th>Operacje</th>
              </tr>

                @foreach($users as $user)
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>
                    <a href="{{route('user.show',$user->id)}}">{{ $user->name }}</a>
                  </td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->roles[0]->display_name }}</td>
                  <td>

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