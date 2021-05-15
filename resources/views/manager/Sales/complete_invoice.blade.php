@extends('layouts.main')
@section('links')
<style>
  #total_price,#extra_price{
    font-size: 32px;
    background-color: white !important;
  }
  #paymethods input[type="number"]{
    margin-right: 20px;
    /*color: white;*/
    font-size: 26px;
    width: 100px !important;
    /*background-color: rgb(19, 179, 19)*/
  }
  #paymethods span{
    font-size: 18px;
  }
  .hidden{
    visibility: hidden;
  }
  .visible{
    visibility: visible;
  }
  input[name=date]{
    border: 1px solid white;
  }
@media print{
  *{
    margin: 0;
    font-size: 32px;
    font-weight: bold;
  }

  table{
    visibility: visible;
  }
  table button,a{
    visibility: hidden;
  }
  button{
    visibility: hidden;
  }
  button[type=submit]{
    visibility: hidden;
  }
  .quantity{
    font-size: 32px;
    background-color: white !important;
  }
  /*#paymethods *{
    visibility: hidden;
  }
  #paymethods input[type="number"]{
    display: none;
  }*/
  #card,#cash,#status,#client{
    display: none;
  }
  
}
</style>
@endsection
@section('body')
<div class="main-panel">
 
 <div class="content">
  @if (session('fail'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('fail') }}</strong>
  </div>
  @endif
  <form method="POST" action="{{route('complete.invoice',$invoice->id)}}">
    @csrf
  <div class="container-fluid">
    <div class="row">
      
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">متجر {{$repository->name}}</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="myTable" class="table">
                <thead class="text-primary">
                  <h4>
                  <span class="badge badge-success">
                      تفاصيل الفاتورة  </span> <input type="text" name="date" value="{{$date}}" readonly></h4>
                  <th>
                    الاسم  
                  </th>
                  <th>
                    التفاصيل 
                  </th>
                  <th>
                    السعر 
                  </th>
                  <th>
                    الكمية 
                  </th>
                </thead>
                <tbody>
                   <div id="record">
                       {{-- php $count=0; ?> --}}
                       @foreach(unserialize($invoice->details) as $detail)
                        @if($detail)
                      {{--  inputs we need to sell process --}}
                     {{-- <input type="hidden" name="barcode[]" value="{{$product->barcode}}"> --}}
                      
                     <tr>
                        <td>
                            {{$detail['name']}}
                        </td>
                        <td>
                          {{$detail['detail']}}
                        </td>
                        <td>
                          {{$detail['price']}}
                        </td>
                        <td>
                          {{$detail['quantity']}}
                        </td>
                    </tr>
                    @endif
                    @endforeach
            </div>
         </tbody>
       </table>
       <div>
         <span style="font-size: 22px;" class="badge badge-success">
           المبلغ الإجمالي 
         </span>
         {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
         <input type="number" name="total_price" id="total_price" class="form-control" value="{{$invoice->total_price}}" readonly>
       </div>
       <div>
        <span style="font-size: 22px;" class="badge badge-warning">
            المبلغ المتبقي للدفع 
          </span>
          <input type="number" name="extra_price" id="extra_price" class="form-control" value="{{($invoice->total_price)-($invoice->cash_amount+$invoice->card_amount)}}" readonly>
       </div>
  <div id="paymethods" style="margin:10px 0;">
        <span class="badge badge-secondary"> طرق الدفع </span>
        <div style="display: flex; flex-direction: column; margin-top: 10px">
          <div style="display: flex;">
        <h4> &nbsp;الدفع كاش</h4>
        <input style="margin: 7px 10px 0 0" type="checkbox" name="cash" id="cash" checked>
          </div>
        <input style="margin-right: 0px" type="number" min="0" step="0.1" name="cashVal" id="cashVal" value="{{($invoice->total_price)-($invoice->cash_amount+$invoice->card_amount)}}" class="form-control visible">
        </div>
        <div style="display: flex;flex-direction: column;">
          <div style="display: flex;">
        <h4> &nbsp;الدفع بالبطاقة</h4>
        <input style="margin: 7px 10px 0 0" type="checkbox" id="card" name="card">
          </div>
        <input style="margin-right: 0px" type="number" min="0" step="0.1" name="cardVal" id="cardVal" value="0" class="form-control hidden">
        </div>
</div>
        {{--<button onclick="window.print();" class="btn btn-success"> طباعة </button>--}}
        <button onclick="window.print();" type="submit" class="btn btn-danger"> استكمال الفاتورة وطباعتها </button>
   </div>
</div>
</div>
</div>

</div>
</div>
</form>
</div>
@endsection
@section('scripts')
<script>
  $('input[type="checkbox"]').change(function(){
if($('#cash').is(':checked') && $('#card').is(':checked')){
    $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
    $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
}
if($('#cash').is(':checked') && $('#card').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  //$('#cashVal').val( $('#total_price').val());
  $('#cardVal').val(0);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visibl');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('#cashVal').val(0);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == false){   // error
  $('#cash').prop('checked',true);
  $('input[name="cashVal"]').removeClass('hidden').addClass('visibl');
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('#cashVal').val( $('#extra_price').val());
}
});
</script>

<script>    // cant submit if cash + card != total real price    //Except if we make invoice pending
 $('input[name="quantity[]"],#cashVal,#cardVal,#cash,#card').on("keyup change",function(){
    sum = parseFloat($('#cashVal').val()) + parseFloat($('#cardVal').val());
    if(sum == $('#extra_price').val()){
      $('button[type="submit"]').prop('disabled', false);
    }
    else if(sum != $('#extra_price').val()){
      $('button[type="submit"]').prop('disabled', true);   // cant submit if cash and card not equals the total
    }
  });
</script>

@endsection