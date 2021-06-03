@extends('layouts.main')
@section('links')
<style>
form i{
  float: left;
}
form i:hover{
  cursor: pointer;
}
.blank{
  background-color: white !important;
  border: 2px solid white !important;
  border-radius:10px;
}
.ajaxSuccess{
  background-color: rgb(41, 206, 41) !important;
  color: white;
}


input[name=date]{
    border: 1px solid white;
  }
  
  #code,#tax_code,#customer_name,#customer_phone{
    border: 1px solid white;
  }
#invoices,#recipe{
  display: none;
}
.hidden{
    visibility: hidden;
  }
  .visible{
    visibility: visible;
  }
  .displaynone{
    display: none;
  }
  
  #total_price,#final_total_price,#taxfield{
    font-size: 32px;
    background-color: white !important;
  }
  #myTable{
    text-align: center
  }
  #myTable input{
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    border: none;
  }
  #myTable th{
   color: black;
   font-weight: bold;
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
</style>
@endsection
@section('body')

<div class="main-panel">
 
 <div class="content">
  @if (session('sellSuccess'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('sellSuccess') }}</strong>
  </div>
  @endif
  @if (session('fail'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('fail') }}</strong>
  </div>
  @endif
  
  <div  class="container-fluid">
    <form method="GET" action="{{route('create.special.invoice',$repository->id)}}">
      @csrf
    <div class="row">

     {{-- <form method="GET" action="{{route('create.special.invoice',$repository->id)}}">
        @csrf --}}
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">العميل {{isset($customer_name)?$customer_name:''}}/
              <span>الجوال {{isset($phone)?$phone:''}}</span>
            </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th>
                    الجوال  
                  </th>
                  <th>
                    الاسم  
                  </th>
                  <th>
                    البحث  
                  </th>
                </thead>
                <tbody>
               <tr>
                <td>
                  <input type="phone" name="phone" value="" class="form-control" placeholder="اكتب هنا لإدخال عميل آخر" required>
                </td>
                 <td>
                   <input type="text" name="name" value="" class="form-control">
                 </td>
                <td>
                  <button type="submit" class="btn btn-primary"> ابحث </button>
                </td>
               </tr>
         </tbody>
       </table>
   </div>
</div>
</div>
  </div>
  </form>
    </div>
  </div>


  <div  class="container-fluid">
    <div class="row">
  <div class="col-md-12">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="toggle-invoices" >
      اظهار المبيعات السابقة 
  </button>
    <div id="invoices" class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">المبيعات السابقة</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table  class="table">
            <thead class="text-primary">
              <th>
                
              </th>
              
            </thead>
            <tbody>
           <tr>
            
           </tr>
     </tbody>
   </table>
  </div>
  </div>
  </div>
  </div>
    
  
<form action="{{route('sell.special.invoice',$repository->id)}}" method="POST">
  @csrf
  <div class="col-md-12">
    
    <button class="btn btn-secondary dropdown-toggle" type="button" id="toggle-recipe" >
      اظهار الوصفة الطبية 
  </button>
    <div id="recipe" class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title ">الوصفة الطبية</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="myTable" class="table table-bordered">
            <thead class="text-primary">
              <th>
                ADD  
              </th>
              <th>
                Axis  
              </th>
              <th>
                CYL  
               </th>   
              <th>
                SPH  
            </th>
              <th>
                EYE  
              </th>
             
            </thead>
            <tbody>
           <tr>
            <td>
              <input type="number" step="0.01" name="add_r">
            </td>
            <td>
              <input type="number" step="0.01" name="axis_r">
            </td>
            <td>
              <input type="number" step="0.01" name="cyl_r">
            </td>
            <td>
              <input type="number" step="0.01" name="sph_r">
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              RIGHT
            </td>
           </tr>
           <tr>
            <td>
              <input type="number" step="0.01" name="add_l">
            </td>
            <td>
              <input type="number" step="0.01" name="axis_l">
            </td>
            <td>
              <input type="number" step="0.01" name="cyl_l">
            </td>
            <td>
              <input type="number" step="0.01" name="sph_l">
            </td>
            <td style="text-align: center; font-weight: bold; font-size: 18px;">
              LEFT
            </td>
           </tr>
           <tr>
             <td style="border: none">
             </td>
             <td>
              <input type="text" name="ipdval">
             </td>
             <td style="text-align: center; font-weight: bold; font-size: 18px;">
               IPD
             </td>
             <td style="border: none">
            </td>
            <td style="border: none">
            </td>
           </tr>
     </tbody>
   </table>
</div>
</div>
</div>
</div>



      
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            {{--<h4 class="card-title ">الفاتورة <input type="text" name="date" value="{{isset($date)?$date:''}}" readonly>
              العميل<input type="text" name="customer_name" id="customer_name" value="{{isset($customer_name)?$customer_name:''}}" readonly>
              الجوال<input type="text" name="customer_phone" id="customer_phone" value="{{isset($phone)?$phone:''}}" readonly>
            </h4>--}}
            <input style="display: none" type="text" name="date" value="{{isset($date)?$date:''}}" readonly>
            <input style="display: none" type="text" name="customer_phone" id="customer_phone" value="{{isset($phone)?$phone:''}}" readonly>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                     
                  {{--@if($repository->logo)
                      <img src="{{asset('storage/'.$repository->logo)}}" width="100px" height="100px" alt="logo" id="logo">
                      @else
                     <span id="warning" class="badge badge-warning"> يرجى تعيين شعار المتجر من الإعدادات </span>
                      @endif
                    
                      رقم الفاتورة <input type="text" name="code" id="code" value="{{isset($code)?$code:''}}" readonly>
                      الرقم الضريبي  <input type="text" name="tax_code" id="tax_code" value="{{$repository->tax_code}}" readonly>
                      --}}
                      <input style="display: none" type="text" name="code" id="code" value="{{isset($code)?$code:''}}" readonly>
                  <th>
                    Barcode  
                  </th>
                  <th>
                    الاسم  
                  </th>
                  <th>
                    المواصفات  
                  </th>
                  <th>
                    السعر  
                  </th>
                  <th>
                    الكمية 
                  </th>
                  <th id="del" class="">
                    تم تسليمها  
                  </th>
                </thead>

                <tbody>
                  <div id="record0">
                    <tr>
                      <td>
                        <input type="hidden" name="repo_id" id="repo_id" class="form-control" value="{{$repository->id}}">
                          <input type="text" id="bar0" name="barcode[]" value="{{old('barcode0')}}"  class="form-control barcode" placeholder="مدخل خاص ب scanner" id="autofocus">
                      </td>
                      <td>
                        <input type="text" id="name0"  name="name[]" value="{{old('name0')}}" class="form-control name blank">
                      </td>
                      <td>
                        <input type="text" id="details0"  name="details[]" value="{{old('details0')}}" class="form-control details blank">
                      </td>
                      <td style="display: none;">
                        <input type="hidden" id="cost_price0"  name="cost_price[]" value="{{old('cost_price0')}}" class="form-control blank">
                      </td>
                      <td>
                        <input type="number" id="price0"  name="price[]" value="{{old('price0')}}" class="form-control price blank">
                      </td>
                      <td>
                        @if(old('quantity0'))
                        <input type="number" id="quantity0" name="quantity[]" value="{{old('quantity0')}}" class="form-control quantity" placeholder="الكمية">
                        @else
                        <input type="number" id="quantity0" name="quantity[]"  class="form-control quantity" value="1" placeholder="الكمية">
                        @endif
                    </td>
                    <td>
                      <input type="checkbox" name="del[]"  class="form-control  delivered" value="0" checked>  {{-- need it just in hanging invoices --}}
                  </td>
                </tr>
            </div>
                  @for ($count=1;$count<=10;$count++)
                   <div>
                    <tr id="record{{$count}}" class="displaynone">
                      <td>
                        <input type="hidden" name="repo_id" id="repo_id" class="form-control" value="{{$repository->id}}">
                          <input type="text" id="bar{{$count}}" name="barcode[]" value="{{old('barcode[$count]')}}"  class="form-control barcode" placeholder="مدخل خاص ب scanner" id="autofocus">
                      </td>
                      <td>
                        <input type="text" id="name{{$count}}"  name="name[]" value="{{old('name.'.$count)}}" class="form-control name blank">
                      </td>
                      <td>
                        <input type="text" id="details{{$count}}"  name="details[]" value="{{old('details.'.$count)}}" class="form-control details blank">
                      </td>
                      <td style="display: none;">
                        <input type="hidden" id="cost_price{{$count}}"  name="cost_price[]" value="{{old('cost_price.'.$count)}}" class="form-control blank">
                      </td>
                      <td>
                        <input type="number" id="price{{$count}}"  name="price[]" value="{{old('price.'.$count)}}" class="form-control price blank">
                      </td>
                      <td>
                        @if(old('quantity.'.$count))
                        <input type="number" id="quantity{{$count}}" name="quantity[]" value="{{old('quantity.'.$count)}}" class="form-control quantity" placeholder="الكمية">
                        @else
                        <input type="number" id="quantity{{$count}}" name="quantity[]"  class="form-control quantity" value="1" placeholder="الكمية">
                        @endif
                    </td>
                    <td>
                        <input type="checkbox" name="del[]" value="{{$count}}"  class="form-control delivered" checked>  {{-- need it just in hanging invoices --}}
                    </td>
                </tr>
            </div>
            @endfor
         </tbody>
       </table>
       
       <div id="cash-info">
        <div>
          <h5>
             المجموع 
          </h5>
          {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
          <input type="number" name="sum" id="total_price" class="form-control" value="0" readonly>
        </div>
 
        <div id="tax-container">
          <h5>الضريبة</h5>
         <div style="display: flex; flex-direction: column; margin-top: 3px;">
           <div style="display: flex;">
             <input type="number" value="0"  id="taxfield" class="form-control" readonly>
             <input style="margin-right: 10px;" type="hidden" value="{{$repository->tax}}" name="tax" id="tax" class="form-control">
           </div>
         </div>
       </div>
 
       <div>
         <h5>
           المبلغ الإجمالي 
         </h5>
         {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
         <input type="number" name="total_price" id="final_total_price" class="form-control" value="0" readonly>
       </div>
       </div>
       {{--<i class="material-icons">add_circle</i>--}}
       <div id="settings">
        <div id="min" class="">
          <span class="badge badge-success hidden" id="badgecolor"> الحد الأدنى للدفع <div id="minVal"></div></span>
         {{--<input type="hidden" class="" id="inputmin" value="{{($repository->min_payment*$invoice_total_price)/100}}">--}}
         <input type="hidden" class="" id="inputmin" value="">
         <input type="hidden" class="" id="percent" value="{{$repository->min_payment}}">

       </div>
        <div>
          <div style="display: flex; flex-direction: column; margin-top: 10px">
            <div style="display: flex;">
          <h4> &nbsp;الدفع كاش</h4>
          <input style="margin: 7px 10px 0 0" type="checkbox" name="cash" id="cash" checked>
            </div>
          <input style="margin-right: 0px" type="number" min="0.1" step="0.01" name="cashVal" id="cashVal" value="" class="form-control visible">
          </div>
          <div style="display: flex;flex-direction: column;">
            <div style="display: flex;">
          <h4> &nbsp;الدفع بالبطاقة</h4>
          <input style="margin: 7px 10px 0 0" type="checkbox" id="card" name="card">
            </div>
          <input style="margin-right: 0px" type="number" min="0.1" step="0.01" name="cardVal" id="cardVal" value="" class="form-control hidden">
          </div>
          </div>
          
          <div>
      

          <div id="buttons">
            <button  id="submit" type="submit" class="btn btn-primary">تأكيد</button>
            <a style="color: white" class="btn btn-success">حفظ</a>
            <a style="color: white; float: left;" class="btn btn-danger">الغاء</a>
          </div>

          </div>
       </div>
   </div>
</div>
</div>
</form>

</div>

</div>
</div>
</div>







@endsection
@section('scripts')


<script>    // Ajax
    $('.barcode').on('keyup',function(){
     
    var barcode = $(this).val();
    var id = $(this).attr("id");  // extract id
    var gold =  id.slice(3);   // remove bar from id to take just the number
    var repo_id = $('#repo_id').val();
    $.ajax({
           type: "get",
           url: '/ajax/get/product/'+repo_id+'/'+barcode,
           //dataType: 'json',
          success: function(data){    // data is the response come from controller
            $.each(data,function(i,value){
              $('#name'+gold+'').val(value.name);
              //$('#name'+gold+'').addClass('ajaxSuccess');
              $('#details'+gold+'').val(value.details);
              //$('#details'+gold+'').addClass('ajaxSuccess');
              $('#price'+gold+'').val(value.price);
              //$('#price'+gold+'').addClass('ajaxSuccess');
              if(parseFloat($('#price'+gold+'').val())!=NaN){
                var s = 0 ;
                for(var i=0;i<=10;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0){
                     s = s + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price').val(s);
                //tax
                var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var increment = (tax * total_price) / 100;
                $('#taxfield').val(increment);
                $('#final_total_price').val(increment+parseFloat($('#total_price').val()));
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input

                // update min value when total price change
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  }
                  
              } // end if
              
           });
          }
    }); // ajax close
  });
</script>
<script>   // stop submiting form when click enter
$(document).keypress(function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
});
</script>

<script>
  $(document).keypress(function(e) {
    if (e.keyCode == 13) {
      // Get the focused element:
      var focused = $(':focus');
      var id = focused.attr("id");  // extract id
      var gold =  id.slice(3);   // remove bar from id to take just the number
      var num = parseInt(gold) +1;
      // focus on next element
      $('#bar'+num+'').focus();
    }
  //$('.barcode').last().focus();
});
</script>
<script>
  $('.quantity').on('keyup',function(){
                var s = 0 ;
                for(var i=0;i<=10;i++){   // number of records
                  if(!$('#price'+i+'').val().length == 0){
                     s = s + parseFloat($('#price'+i+'').val()) * parseFloat($('#quantity'+i+'').val());
                  }
                } // end for loop
                $('#total_price').val(s);
                 //tax
                 var tax =  parseFloat($('#tax').val());
                var total_price =  parseFloat($('#total_price').val());
                var increment = (tax * total_price) / 100;
                $('#taxfield').val(increment);
                $('#final_total_price').val(increment+parseFloat($('#total_price').val()));
                //min
                $('#cashVal').val($('#final_total_price').val());     // cash value input

                // update min value when total price change
                var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
                //console.log(newMin);
                $('#inputmin').val(newMin);
                $('#minVal').text(newMin);
                // check min validation
                var cash =  parseFloat($('#cashVal').val());
                var card = parseFloat($('#cardVal').val());
                // min payment
                var min = parseFloat($('#inputmin').val());
                  if(card+cash<min){
                  $('#submit').prop('disabled', true);
                  $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
                  } 
                  else{
                  $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
                  }
                  }
  });
</script>
<script>  // hide and show div
    $('#toggle-recipe').on('click',function(){
    $("#recipe").toggle();
    });
    $('#toggle-invoices').on('click',function(){
    $("#invoices").toggle();
    });
</script>



{{--  scripts from beforeprint blade --}}
<script>
  $('input[type="checkbox"]').change(function(){
if($('#cash').is(':checked') && $('#card').is(':checked')){
    $('input[name="cardVal"]').removeClass('hidden').addClass('visible');
    $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
}
if($('#cash').is(':checked') && $('#card').prop('checked') == false){
  $('input[name="cardVal"]').removeClass('visible').addClass('hidden');
  $('input[name="cashVal"]').removeClass('hidden').addClass('visible');
  $('#cardVal').val(null);
}
if($('#cash').prop('checked') == false && $('#card').prop('checked') == true){
  $('input[name="cardVal"]').removeClass('hidden').addClass('visibl');
  $('input[name="cashVal"]').removeClass('visible').addClass('hidden');
  $('#cashVal').val(null);
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
  //$('#cashVal').val($('#final_total_price').val());
window.onload=function(){
  $('#submit').prop('disabled',true);
  $('#cashVal').val($('#final_total_price').val());
  // tax
  var tax =  parseFloat($('#tax').val());
    var total_price =  parseFloat($('#total_price').val());
    var increment = (tax * total_price) / 100;
    $('#taxfield').val(increment);

    // min init
    var initmin = parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()) / 100 ;
    $('#inputmin').val(initmin);

};
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
 // tax
    var tax =  parseFloat($('#tax').val());
    var total_price =  parseFloat($('#total_price').val());
    var increment = (tax * total_price) / 100;
    $('#taxfield').val(increment);
   $('#final_total_price').val(parseFloat($('#total_price').val())+increment);
   //console.log($('#final_total_price').val());
  $('#cashVal').val($('#final_total_price').val());     // cash value input

   // update min value when total price change
    var newMin = (parseFloat($('#percent').val()) * parseFloat($('#final_total_price').val()))/100;
    //console.log(newMin);
    $('#inputmin').val(newMin);
    $('#minVal').text(newMin);
    // check min validation
    var cash =  parseFloat($('#cashVal').val());
    var card = parseFloat($('#cardVal').val());
     // min payment
     var min = parseFloat($('#inputmin').val());
      if(card+cash<min){
      $('#submit').prop('disabled', true);
      $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
      } 
      else{
      $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
    }
     
});
</script>

<script>    // cant submit if cash + card != total real price    //Except if we make invoice pending
 $('input[name="quantity[]"],#cashVal,#cardVal,#cash,#card').on("keyup change",function(){
    var sum;
    var cash =  parseFloat($('#cashVal').val());
    var card = parseFloat($('#cardVal').val());
   
     // min payment
     var min = parseFloat($('#inputmin').val());
    if($('#cashVal').val()=="" && $('#cardVal').val()!=""){
    //if(!$('#cashVal').val() && $('#cardVal').val()){
      cash = 0 ;
      sum = card + cash;
    }
   if($('#cardVal').val()=="" && $('#cashVal').val()!=""){
    //if(!$('#cardVal').val() && $('#cashVal').val()){
      card = 0 ;
      sum = cash + card;
    }
    if($('#cashVal').val()!="" && $('#cardVal').val()!=""){
    //if($('#cashVal').val() && $('#cardVal').val()){
    sum = cash + card ;
    }
    /*if(sum == $('#final_total_price').val()){
      $('#submit').prop('disabled', false);
    }*/
   
     if(sum > $('#final_total_price').val()){   
      $('#submit').prop('disabled', true);
    }
    else{
      if ($('.delivered:checked').length != $('.delivered').length){  // hanging
        $('#badgecolor').removeClass('hidden').addClass('visible');
      // min payment
        if((cash+card)<min){
        //if(sum<min)
        $('#submit').prop('disabled', true);
        $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
      }
      else{
        $('#submit').prop('disabled', false);
        $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
      }
      }  // end hanging
      if ($('.delivered:checked').length == $('.delivered').length){ //delivered
        if(sum == $('#final_total_price').val())   // delivered
        $('#submit').prop('disabled', false);   // cant submit if cash and card not equals the total
        else
        $('#submit').prop('disabled', true);
      }
      //if(cash <= 0 || card <= 0 )
      if(parseFloat(('#cashVal').val()) <=0.00 || parseFloat(('#cardVal').val())<=0.00){ // dont accept values less or equal to zero
          $('#submit').prop('disabled', true);
        }
      
    }
  });
</script>
<script>
/*$('#status').change(function(){
    var sum;
    var cash =  parseFloat($('#cashVal').val());
    var card = parseFloat($('#cardVal').val());
    // min payment
    var min = parseFloat($('#inputmin').val());
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
    $('#del').removeClass('hidden').addClass('visible');
    $('.delivered').removeClass('hidden').addClass('visible');
    $('#min').removeClass('hidden').addClass('visible');
    if(sum <= $('#final_total_price').val())
    $('button[type="submit"]').prop('disabled', false);
    else
    $('button[type="submit"]').prop('disabled', true);
    // min payment
    if($('#cashVal').val()=="" && $('#cardVal').val()!=""){
    if(card<min){
      $('button[type="submit"]').prop('disabled', true);
      $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
    }
    }
    if($('#cashVal').val()!="" && $('#cardVal').val()==""){
    if(cash<min){
      $('button[type="submit"]').prop('disabled', true);
      $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
    }
    }
    if($('#cashVal').val()!="" && $('#cardVal').val()!=""){
    if(card+cash<min){
      $('button[type="submit"]').prop('disabled', true);
      $('#badgecolor').removeClass('badge-success').addClass('badge-danger');
    }
    else{
      $('#badgecolor').removeClass('badge-danger').addClass('badge-success');
    }
    }
  }
  if(cash <=0 || card<=0){    // dont accept values less or equal to zero
      $('#submit').prop('disabled', true);
    }
  if($('#status').prop('checked') == true){    // delivered
   // $('#stat').text("تم التسليم");
    $('#del').removeClass('visible').addClass('hidden');
    $('.delivered').removeClass('visible').addClass('hidden');
    $('#min').removeClass('visible').addClass('hidden');
    if(sum == $('#final_total_price').val()){
      $('button[type="submit"]').prop('disabled', false);
    }
    else if(sum != $('#final_total_price').val() && $('#status').prop('checked') == true){   // delivered
      $('button[type="submit"]').prop('disabled', true);   // cant submit if cash and card not equals the total
    }
    if(cash <=0 || card<=0){    // dont accept values less or equal to zero
      $('#submit').prop('disabled', true);
    }
  }
});
*/
</script>

<script>   // stop submiting form when click enter
  $(document).keypress(function(e) {
      if (e.keyCode == 13) {
          e.preventDefault();
          return false;
      }
  });
  </script>

<script>
window.onload=function(){
  var count_press = 0;
  $(document).keypress(function(e) {
      if (e.keyCode == 13) {
        count_press = count_press + 1 ;
        var gold =  count_press;
        $('#record'+gold).removeClass('displaynone');
        // focus on next element
        $('#bar'+gold+'').focus();
      }
  });
}
</script>

<script>   // stop submiting form when click enter
  $(document).keypress(function(e) {
      if (e.keyCode == 13) {
          e.preventDefault();
          return false;
      }
  });
  </script>
  <script>   // hanging
    $('.delivered').on('change',function(){
      if ($('.delivered:checked').length != $('.delivered').length)
        $('#badgecolor').removeClass('hidden').addClass('visible');
        else
        $('#badgecolor').removeClass('visible').addClass('hidden');
    });
  </script>
@endsection
