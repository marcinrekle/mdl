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
                <th>Parametry</th>
                <th>Operacje</th>
              </tr>

                @foreach($fields as $field)

                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $field->name }}</td>
                  <td>{{ $field->slug }}</td>
                  <td>{{ $field->description }}</td>
                  <td>{{ $field->type }}</td>
                  <td>{{ $field->order }}</td>
                  <td>{{ Form::checkbox('required',1, $field->active,['disabled']) }}</td>
                  <td>{{ Form::checkbox('required',1, $field->visible,['disabled']) }}</td>
                  <td>{{ Form::checkbox('required',1, $field->require,['disabled']) }}</td>
                  <td>{{ json_encode($field->options) }}</td>
                  <td>
                  {{ Html::linkRoute('field.edit', 'Edytuj', $field->id, ['class' => 'btn btn-primary'])}}
                  {!! Form::model($field, [
                    'method' => 'DELETE',
                    'route' => ['field.destroy', $field->id],
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