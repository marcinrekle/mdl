@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Płatności <a href="{{route('payment.create')}}" class="pull-right"><i class="fa fa-plus"></i>Dodaj</a></h3>
          </div>
          <div class="panel-body">
              
            <table class="table table-striped">
              <tr>
                <th>Lp</th>
                <th>Kursant</th>
                <th>Data</th>
                <th>Kwota</th>
                <th>Za co</th>
                <th>Operacje</th>
              </tr>

                @foreach($payments as $payment)

                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td>{{ $payment->users->name }}</td>
                  <td>{{ $payment->payment_date }}</td>
                  <td>{{ $payment->amount }}</td>
                  <td>{{ $payment->payment_for }}</td>
                  <td>
                  {{ Html::linkRoute('payment.edit', 'Edytuj', $payment->id, ['class' => 'btn btn-primary'])}}
                  {!! Form::model($payment, [
                    'method' => 'DELETE',
                    'route' => ['payment.destroy', $payment->id],
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