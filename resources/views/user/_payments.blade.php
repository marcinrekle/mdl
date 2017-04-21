<table class="table table-striped">
  <tr>
    <th>Data</th>
    <th>Kwota</th>
    <th>Cel</th>
    @permission(['payment-crud','payment-edit'])<th>Edycja</th>@endpermission
  </tr>
    @foreach($user->payments->sortByDesc('payment_date') as $payment)
    <tr>
      <td>{{ $payment->payment_date }}</td>
      <td>{{ $payment->amount }}</td>
      <td>{{ $costNames['cost_'.$payment->payment_for] }}</td>
      @permission(['payment-crud','payment-edit','payment-delete'])
      <td>
        @permission(['payment-crud','payment-edit'])
        <a href="{{route('payment.edit',[$payment->id])}}" class="edit"><i class="fa fa-pencil fa-2x"></i></a>
        @endpermission
        @permission(['payment-crud','payment-delete'])
        {!! Form::model($payment, [
            'method' => 'DELETE',
            'route' => ['payment.destroy',$payment->id],
            ]) !!}
            <div class="form-group">
              <a class="delete" href="#"><i class="fa fa-trash-o fa-2x text-danger"></i></a>
            </div>
        {!! Form::close() !!}
        @endpermission
      </td>
      @endpermission
    </tr>
    @endforeach
</table>