@extends('layouts.main')
@section('links')
<style>
  #total_price{
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
  #paymethods{
    display: flex;
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
  #code{
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
  .quantity,.details,.name,.price{
    font-size: 32px;
    background-color: white !important;
  }
  #phoneinput{
    font-size: 28px;
  }
  /*#paymethods *{
    visibility: hidden;
  }
  #paymethods input[type="number"]{
    display: none;
  }*/
  #card,#cash,#client{
    display: none;
  }
  #status{
    width: 20px;
    height: 20px;
  }
  #code{
    font-size: 28px;
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
  <form id="myform" method="POST" action="{{route('make.sell',$repository->id)}}">
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
                      رقم الفاتورة <input type="text" name="code" id="code" value="{{$code}}" readonly>
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
                       @foreach($products as $product)
                    <tr>
                      {{--  inputs we need to sell process --}}
                      <input type="hidden" name="barcode[]" value="{{$product->barcode}}">
                      
                      <td>
                        <input type="text" name="name[]" class="form-control name" value="{{$product->name}}" readonly>
                        {{--{{$product->name}}--}}
                      </td>
                      <td>
                        <input type="text" name="details[]" class="form-control details" value="{{$product->details}}" readonly>
                        {{--{{$product->details}}--}}
                     </td>
                     <td>
                       <input type="number" name="price[]"  class="form-control price" value="{{$product->price}}" readonly>
                        {{--{{$product->price}}--}}
                     </td>
                     <td>
                      <input type="number" name="quantity[]"  class="form-control quantity" value="{{$product->quantity}}">
                       {{-- {{$quantities[$count]}}  --}}
                     </td>
                </tr>
                {{-- php $count++ ?> --}}
                @endforeach
            </div>
         </tbody>
       </table>
       <div>
         <span style="font-size: 22px;" class="badge badge-info">
           المبلغ الإجمالي 
         </span>
         {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
         <input type="number" name="total_price" id="total_price" class="form-control" value="{{$invoice_total_price}}" readonly>
       </div>
       <div id="paymethods" style="margin:10px 0;">
                    <div>
                    <span class="badge badge-secondary"> طرق الدفع </span>
                    <div style="display: flex; flex-direction: column; margin-top: 10px">
                      <div style="display: flex;">
                    <h4> &nbsp;الدفع كاش</h4>
                    <input style="margin: 7px 10px 0 0" type="checkbox" name="cash" id="cash" checked>
                      </div>
                    <input style="margin-right: 0px" type="number" min="0.1" step="0.1" name="cashVal" id="cashVal" value="{{$invoice_total_price}}" class="form-control visible">
                    </div>
                    <div style="display: flex;flex-direction: column;">
                      <div style="display: flex;">
                    <h4> &nbsp;الدفع بالبطاقة</h4>
                    <input style="margin: 7px 10px 0 0" type="checkbox" id="card" name="card">
                      </div>
                    <input style="margin-right: 0px" type="number" min="0.1" step="0.1" name="cardVal" id="cardVal" value="" class="form-control hidden">
                    </div>
                    </div>
                    <div style="margin-right: 50px;">
                    <div id="deliverde">
                      <span class="badge badge-secondary"> حالة الفاتورة  </span>
                      <div style="display: flex; flex-direction: column; margin-top: 10px">
                        <div style="display: flex;">
                      <input style="margin: 7px 10px 0 0" type="checkbox" name="delivered" id="status" checked>
                      <h4 style="margin-right: 10px;" id="stat"> تسليم</h4>
                        </div>
                    </div>
                    <div id="phone">
                      <span class="badge badge-secondary">  جوال العميل </span>
                      <div style="display: flex; flex-direction: column; margin-top: 10px">
                        <div style="display: flex;">
                      <input style="margin: 7px 10px 0 0" type="checkbox" id="client">
                      <h4 style="margin-right: 10px;">  جوال العميل </h4>
                      <input style="margin-right: 10px; type="text" name="phone" id="phoneinput" class="form-control hidden" placeholder="أدخل رقم الجوال">
                        </div>
                    </div>
                    </div>
                    </div>
        </div>
       </div>
         <div>
        {{--<button onclick="window.print();" class="btn btn-success"> طباعة </button>--}}
        <button id="submit" onclick="window.print();" type="submit" class="btn btn-success"> تأكيد الفاتورة وطباعتها </button>
        <a href="{{route('create.invoice',$repository->id)}}" class="btn btn-danger"> فاتورة جديدة </a>
        <a href="javascript:history.back()" class="btn btn-warning" id="back"> رجوع </a>
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
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  if($('#status').prop('checked') == false){  // pending so we can change value to less value
    $('#cardVal').val(null);
  }
  else{
  $('#cashVal').val( $('#total_price').val());
  $('#cardVal').val(null);
  }
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visibl');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  if($('#status').prop('checked') == false){  // pending so we can change value to less value
    $('#cashVal').val(null);
  }
  else{
  $('#cashVal').val(null);
  $('#cardVal').val($('#total_price').val());
  }
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == false){   // error
  //$('#cash').prop('checked',true);
  //$('input[name="cashVal"]').removeClass('hidden').addClass('visibl');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  //$('#cashVal').val( $('#total_price').val());
  $('#cashVal').val(null);
  $('#cardVal').val(null);
  $('#submit').prop('disabled', true);
}
});
</script>

<script>
  var c = $('input[name="barcode[]"]');
  var count = c.length;    // number of records
  /*var intervalId = window.setInterval(function(){
   // $('#total_price').val(0);
   var sum = 0 ;
  for(var i=0;i<count;i++){
    sum = sum + $('.price').eq(i).val()*$('.quantity').eq(i).val();
    //$('#total_price').val($('#total_price').val()+($('.price').eq(i).val()*$('.quantity').eq(i).val()));
  }
  $('#total_price').val(sum);
  $('#cashVal').val(sum);     // cash value input
}, 500);*/

$('input[name="quantity[]"]').on("keyup",function(){
  var sum = 0 ;
  for(var i=0;i<count;i++){
    sum = sum + $('.price').eq(i).val()*$('.quantity').eq(i).val();
    //$('#total_price').val($('#total_price').val()+($('.price').eq(i).val()*$('.quantity').eq(i).val()));
  }
  $('#total_price').val(sum);
  $('#cashVal').val(sum);     // cash value input
});
</script>

<script>    // cant submit if cash + card != total real price    //Except if we make invoice pending
 $('input[name="quantity[]"],#cashVal,#cardVal,#cash,#card').on("keyup change",function(){
    var sum;
    var cash =  parseFloat($('#cashVal').val());
    var card = parseFloat($('#cardVal').val());
    if($('#cashVal').val()=="" && $('#cardVal').val()!=""){
      sum = card + 0;
    }
   if($('#cardVal').val()=="" && $('#cashVal').val()!=""){
      sum = cash + 0;
    }
    if($('#cashVal').val()!="" && $('#cardVal').val()!=""){
    sum = cash + card ;
    }
    if(sum == $('#total_price').val()){
      $('#submit').prop('disabled', false);
    }
    else if(sum != $('#total_price').val() && $('#status').prop('checked') == true){   // delivered
      $('button[type="submit"]').prop('disabled', true);   // cant submit if cash and card not equals the total
    }
    if(cash <=0 || card<=0){ // dont accept values less or equal to zero
      $('#submit').prop('disabled', true);
    }
  });
</script>
<script>
$('#status').change(function(){
    var sum;
    var cash =  parseFloat($('#cashVal').val());
    var card = parseFloat($('#cardVal').val());
    if($('#cashVal').val()=="" && $('#cardVal').val()!=""){
      sum = card + 0;
    }
   if($('#cardVal').val()=="" && $('#cashVal').val()!=""){
      sum = cash + 0;
    }
    if($('#cashVal').val()!="" && $('#cardVal').val()!=""){
    sum = cash + card ;
    }
  if($('#status').prop('checked') == false){    // pending
    //$('#stat').text("معلقة");
    if(sum <= $('#total_price').val())
    $('button[type="submit"]').prop('disabled', false);
    else
    $('button[type="submit"]').prop('disabled', true);
  }
  if(cash <=0 || card<=0){    // dont accept values less or equal to zero
      $('#submit').prop('disabled', true);
    }
  if($('#status').prop('checked') == true){    // delivered
   // $('#stat').text("تم التسليم");
    
    if(sum == $('#total_price').val()){
      $('button[type="submit"]').prop('disabled', false);
    }
    else if(sum != $('#total_price').val() && $('#status').prop('checked') == true){   // delivered
      $('button[type="submit"]').prop('disabled', true);   // cant submit if cash and card not equals the total
    }
    if(cash <=0 || card<=0){    // dont accept values less or equal to zero
      $('#submit').prop('disabled', true);
    }
  }
});
$('#client').change(function(){
  if($('#client').prop('checked') == true){
    $('#phoneinput').removeClass('hidden').addClass('visibl');
  }
  if($('#client').prop('checked') == false){
    $('#phoneinput').removeClass('visible').addClass('hidden');
  }
});
</script>
@endsection