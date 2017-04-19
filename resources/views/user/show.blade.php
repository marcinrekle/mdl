@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">{{$user->name}}</h3>
          </div>
          <div class="panel-body">

            <table class="table table-striped">
              <tr>
                <th></th>
                <th>Godziny</th>
                <th>Płatności</th>
                <th>Jazdy w tygodniu</th>
                <th>Edycja</th>
              </tr>

                <tr>
                  <td>
                    <div class="placeholder">
                      <img src="{{$user->avatar}}" style="width:50px" class="img-responsive img-circle avatar avatar-big">
                    </div>
                  </td>
                  
                  <td>{{$user->hours->sum('count')+$user->attrs->values['old_hours'] }} / {{ $user->attrs->values['hours'] }}</td>
                  <td>
                  
                  @foreach( $payed as $key => $value )
                  {{ $costNames['cost_'.$key]  }} : {{ $value }} / {{ $user->attrs->values['cost_'.$key]}} @if(!$loop->last) </br> @endif
                  @endforeach
                  </td>
                  <td>
                  {{ $user->dpw }}
                  </td>
                  <td>
                    
                  </td>
                </tr>
                

            </table>

            
          </div>
        </div>
      </div>
    </div>
    
    @if( $user->canDrive )
      <div class="row" id="reservationPanel">
        <div class="col-md-12">
            @include('user._reserve', [$instructors])
        </div>
      </div>
    @endif
  </div>
@stop