@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Lista kursantów <a href="{{route('home')}}" class="pull-right"><i class="fa fa-plus"></i></a></h3>
          </div>
          <div class="panel-body">
              
            <table class="table table-striped">
              <tr>
                <th>Nazwa</th>
              </tr>

                @foreach($students as $student)
                <tr>
                  <td><img class="img-responsive img-circle avatar avatar-small" src="{{$student->user->avatar}}"/><a href="{{route('student.show',$student->id)}}" >{{ $student->user->name }}</a></td>
                </tr>
                @endforeach

            </table>

            
          </div>
        </div>
      </div>
    </div>
  </div>
@stop