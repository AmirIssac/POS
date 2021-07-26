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
  #back{
    float: left;
  }
   /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
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
                    {{__('sales.invoice_details')}}   </span> <input type="text" name="date" value="{{$date}}" readonly></h4>
                      <h4>{{__('sales.invoice_code')}}  {{$invoice->code}}
                      <input type="hidden" name="code" value="{{$invoice->code}}">
                      </h4>
                  <th>
                     Barcode
                  </th>
                  <th>
                    {{__('sales.name')}}  
                  </th>
                  <th>
                    {{__('sales.price')}} 
                  </th>
                  <th>
                    {{__('sales.quantity')}} 
                  </th>
                  <th>
                    {{__('sales.must_deliver')}}  
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
                        {{$detail['barcode']}}
                        <input type="hidden" name="barcode[]" value="{{$detail['barcode']}}">
                      </td>
                        <td>
                            {{$detail['name_'.LaravelLocalization::getCurrentLocale()]}}
                            <input type="hidden" name="name_ar[]" value="{{$detail['name_ar']}}"> {{-- we print always in arabic --}}
                        </td>
                        
                        <td>
                          {{$detail['price']}}
                          <input type="hidden" name="price[]" value="{{$detail['price']}}">
                        </td>
                        
                        <td>
                          {{$detail['quantity']}}
                          <input type="hidden" name="quan[]" value="{{$detail['quantity']}}">
                        </td>
                        <td>
                          <input type="hidden" name="quantity[]" value="{{$detail['quantity']-$detail['delivered']}}"> {{-- must deliver --}}
                          {{$detail['quantity']-$detail['delivered']}}
                        </td>
                    </tr>
                    @endif
                    @endforeach
            </div>
         </tbody>
       </table>
       <div>
         <span style="font-size: 22px;" class="badge badge-success">
          {{__('sales.total_price')}}  
         </span>
         {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
         <input type="number" name="total_price" id="total_price" class="form-control" value="{{$invoice->total_price}}" readonly>
       </div>
       <div>
        <span style="font-size: 22px;" class="badge badge-warning">
          {{__('sales.remaining_price_complete')}}   
          </span>
          <input type="number" name="extra_price" id="extra_price" class="form-control" value="{{($invoice->total_price)-($invoice->cash_amount+$invoice->card_amount+$invoice->stc_amount)}}" readonly>
       </div>
  <div id="paymethods" style="margin:10px 0;">
        <span class="badge badge-secondary"> {{__('sales.payment_methods')}}  </span>
        <div style="display: flex; flex-direction: column; margin-top: 10px">
          <div style="display: flex;">
        <h4> &nbsp; {{__('sales.cash')}}</h4>
        <input style="margin: 7px 10px 0 0" type="checkbox" name="cash" id="cash" checked>
          </div>
        <input style="margin-right: 0px" type="number" min="0" step="0.1" name="cashVal" id="cashVal" value="{{($invoice->total_price)-($invoice->cash_amount+$invoice->card_amount+$invoice->stc_amount)}}" class="form-control visible">
        </div>
        <div style="display: flex;flex-direction: column;">
          <div style="display: flex;">
        <h4> &nbsp; {{__('sales.card')}}</h4>
        <input style="margin: 7px 10px 0 0" type="checkbox" id="card" name="card">
          </div>
        <input style="margin-right: 0px" type="number" min="0.1" step="0.1" name="cardVal" id="cardVal" value="" class="form-control hidden">
        </div>
        <div style="display: flex;flex-direction: column;">
          <div style="display: flex;">
        <h4> &nbsp; STC-pay</h4>
        <input style="margin: 7px 10px 0 0" type="checkbox" id="stc" name="stc">
          </div>
        <input style="margin-right: 0px" type="number" min="0.1" step="0.01" name="stcVal" id="stcVal" value="" class="form-control hidden">
        </div>
       
</div>
        {{--<button onclick="window.print();" class="btn btn-success"> طباعة </button>--}}
        <button type="submit" class="btn btn-danger">   {{__('buttons.complete')}} </button>
        <a href="javascript:history.back()" class="btn btn-warning" id="back"> {{__('buttons.back')}} </a>
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
if($('#cash').is(':checked') && $('#card').is(':checked') && $('#stc').is(':checked')){
    $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
    $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
    $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
}
if($('#cash').is(':checked') && $('#card').prop('checked') == false && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('#cardVal').val(null);
  $('#stcVal').val(null);
}
if($('#cash').is(':checked') && $('#card').prop('checked') == false && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('#cardVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('#cashVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('#cashVal').val(null);
  $('#stcVal').val(null);
}
if($('#cash').prop('checked') == true && $('#card').prop('checked') == true && $('#stc').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  $('#stcVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == false && $('#stc').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('hidden').addClass('visible');
  $('#cashVal').val(null);
  $('#cardVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == false && $('#stc').prop('checked') == false){   // error
  //$('#cash').prop('checked',true);
  //$('input[name="cashVal"]').removeClass('hidden').addClass('visibl');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="stcVal"]').removeClass('visible').addClass('hidden');
  //$('#cashVal').val( $('#total_price').val());
  $('#cashVal').val(null);
  $('#cardVal').val(null);
  $('#stcVal').val(null);
  $('#submit').prop('disabled', true);
}
});
</script>

<script>    
 $('input[name="quantity[]"],#cashVal,#cardVal,#cash,#card,#stcVal,#stc').on("keyup change",function(){
  var sum;
     var cash =  parseFloat($('#cashVal').val());
     var card = parseFloat($('#cardVal').val());
     var stc = parseFloat($('#stcVal').val());
    
      
     if($('#cashVal').val()=="" && $('#cardVal').val()!="" && $('#stcVal').val()!=""){
     //if(!$('#cashVal').val() && $('#cardVal').val()){
       cash = 0 ;
       sum = card + cash + stc;
     }
    if($('#cardVal').val()=="" && $('#cashVal').val()!="" && $('#stcVal').val()!=""){
     //if(!$('#cardVal').val() && $('#cashVal').val()){
       card = 0 ;
       sum = cash + card + stc;
     }
     
     if($('#cardVal').val()=="" && $('#cashVal').val()!="" && $('#stcVal').val()==""){
     //if(!$('#cardVal').val() && $('#cashVal').val()){
       card = 0 ;
       stc = 0 ;
       sum = cash + card + stc;
     }
     if($('#cardVal').val()=="" && $('#cashVal').val()=="" && $('#stcVal').val()!=""){
     //if(!$('#cardVal').val() && $('#cashVal').val()){
       card = 0 ;
       cash = 0 ;
       sum = cash + card + stc;
     }
     if($('#cardVal').val()!="" && $('#cashVal').val()!="" && $('#stcVal').val()==""){
     //if(!$('#cardVal').val() && $('#cashVal').val()){
       stc = 0 ;
       sum = cash + card + stc;
     }
     if($('#cardVal').val()!="" && $('#cashVal').val()=="" && $('#stcVal').val()==""){
     //if(!$('#cardVal').val() && $('#cashVal').val()){
       cash = 0 ;
       stc = 0 ;
       sum = cash + card + stc;
     }
     if($('#cashVal').val()=="" && $('#cardVal').val()=="" && $('#stcVal').val()==""){
      cash = 0 ;
      card = 0 ;
      stc = 0 ;
     sum = cash + card + stc ;
     }
     if($('#cashVal').val()!="" && $('#cardVal').val()!="" && $('#stcVal').val()!=""){
     //if($('#cashVal').val() && $('#cardVal').val()){
     sum = cash + card + stc ;
     }
    if(sum == $('#extra_price').val()){
      $('button[type="submit"]').prop('disabled', false);
    }
    else if(sum != $('#extra_price').val()){
      $('button[type="submit"]').prop('disabled', true);   // cant submit if cash and card not equals the total
    }
    /*if(cash <=0 || card<=0 || stc<=0){ // dont accept values less or equal to zero
      $('button[type="submit"]').prop('disabled', true);
    }*/
  });
</script>

@endsection