@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Dodatkowe pola <a href="{{route('field.create')}}" class="pull-right"><i class="fa fa-plus"></i>Dodaj</a></h3>
          </div>
          <div class="panel-body">
              
            <table class="table table-striped">
              <tr>
                <th>Lp</th>
                <th>Nazwa</th>
                <th>Slug</th>
                <th>Opis</th>
                <th>Typ pola</th>
                <th>Kolejność</th>
                <th>Aktywne</th>
                <th>Widoczne</th>
                <th>Wymagane</th>
              </tr>

                @foreach($fields as $field)
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $field->name }}</td>
                  <td>{{ $field->slug }}</td>
                  <td>{{ $field->description }}</td>
                  <td>{{ $field->type }}</td>
                  <td>{{ $field->order }}</td>
                  <td>{{ $field->active }}</td>
                  <td>{{ $field->visible }}</td>
                  <td>{{ $field->required }}</td>
                </tr>
                @endforeach

            </table>

            
          </div>
        </div>
      </div>
    </div>
  </div>
@stop