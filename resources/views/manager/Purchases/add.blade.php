@extends('layouts.main')
@section('links')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  {{--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
 
<style>
form i{
  float: left;
}
form #plus:hover{
  cursor: pointer;
}
form #tooltip:hover{
  cursor: default;
}
.displaynone{
  display: none;
}
.success{
  background-color: greenyellow;
}
.success:focus{
  background-color: greenyellow;
}
.failed{
  background-color: #f14000;
}
.failed:focus{
  background-color: #f14000;
}
</style>
@endsection
@section('body')
<div class="main-panel">
 
 <div class="content">
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container-fluid">
      <div class="row">
        @if($custom_date)
        <form method="POST" action="{{route('store.old.purchase',$repository->id)}}">
            @csrf
        @else
        <form method="POST" action="{{route('store.purchase',$repository->id)}}">
          @csrf
        @endif
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  @if($custom_date)
                  {{__('sales.plz_input_date_invoice')}}   
                  <input type="datetime-local" name="date">
                  @endif
                  <h4 class="card-title "></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="myTable" class="table">
                      <thead class="text-primary">
                        
                      </thead>
                      <tbody>
                         <div>
                          <tr>
                            <td>{{__('purchases.invoice_num')}}</td>
                            <td>
                              @if(old('code'))
                              <span style="font-size: 22px;" class="badge badge-primary">{{old('code')}}</span>
                              <input type="hidden" name="code" value="{{old('code')}}">
                              @else
                              <span style="font-size: 22px;" class="badge badge-primary">{{$code}}</span>
                              <input type="hidden" name="code" value="{{$code}}">
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td>{{__('purchases.supplier')}}</td>
                            <td>
                              <select name="supplier_id" class="form-control">
                                @foreach($suppliers as $supplier)
                                  <option value="" disabled selected hidden>   {{__('purchases.choose_supplier')}}  </option>
                                  <option value="{{$supplier->id}}"> {{$supplier->name}} </option>
                                @endforeach
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>  {{__('purchases.supplier_invoice_num')}} </td>
                            <td><input type="text" name="supplier_invoice_num" class="form-control" value="{{old('supplier_invoice_num')}}" placeholder="{{__('purchases.supplier_invoice_num')}}"></td>
                          </tr>
                          @if($custom_date)
                          <tr>
                            <td>{{__('sales.inv_not_belong_to_todays_invoices')}}</td>
                            <td>
                              <input type="checkbox" name="old_purchase" value="yes" checked>
                            </td>
                          </tr>
                          @endif
                         </div>
                      </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__('purchases.purchases')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="myTable" class="table">
                  <thead class="text-primary">
                    <th>
                      Barcode  
                    </th>
                    <th>
                      {{__('purchases.name')}}
                    </th>
                    <th>
                      {{__('sales.quantity')}} 
                    </th>
                    <th>
                      {{__('purchases.unit_price')}} 
                    </th>
                    <th>   {{-- for future use to save every input details in table of repository inputs --}}
                      {{__('purchases.total')}}
                      <td>
                      <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title=" {{__('purchases.total')}} =" data-content="  {{__('purchases.unit_price')}} X {{__('sales.quantity')}}">live_help</i>
                      </td>
                    </th>
                  </thead>
                  <tbody>
                     <div id="record">
                      <tr>
                        <td>
                          <input type="hidden" value="{{$repository->id}}" id="repo_id">
                          <?php $old_index = 0 ; ?>
                            <input type="text" name="barcode[]" class="form-control barcode" value="{{old('barcode.'.$old_index)}}" placeholder=" {{__('sales.scanner_input')}} " id="bar0"  required>
                          {{--  <input id="search" name="search" type="text" class="form-control" placeholder="Search" /> --}}

                        </td>
                        <td>
                          <input type="text" name="name[]" class="form-control" value="{{old('name.'.$old_index)}}" id="ar0" required readonly>
                      
                  
                    <td>
                      @if(old('quantity.'.$old_index))
                      <input id="quantity0" type="number" name="quantity[]" min="0" class="form-control" value="{{old('quantity.'.$old_index)}}" placeholder="{{__('sales.quantity')}}" required>
                      @else
                      <input id="quantity0" type="number" name="quantity[]" min="0" class="form-control" value="1" placeholder="{{__('sales.quantity')}}" required>
                      @endif
                  </td>
                      
                        <td>
                          @if(old('price.'.$old_index))
                            <input id="price0"  type="number" name="price[]" step="0.01" class="form-control target" value="{{old('price.'.$old_index)}}" placeholder="{{__('sales.price')}}" id="price0" required>
                            @else
                            <input id="price0"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="{{__('sales.price')}}" id="price0" required>
                            @endif
                        </td>
                        <td>
                            <input id="total_price0" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="{{__('sales.total_price')}}" readonly>
                            <input type="hidden" name="repo_id" value="{{$repository->id}}">
                        </td>  
                        <td>
                          <a id="delete0" class="delete"><img src="{{asset('public/img/delete-icon.jpg')}}" width="45px" height="45px"></a>
                      </td>
                      </tr>
                      @for ($count=1;$count<=100;$count++)
                      @if(old('name.'.$count)) {{-- this record exist in old input so we dont hide it --}}
                      <tr id="record{{$count}}">
                      @else
                      <tr id="record{{$count}}" class="displaynone">
                      @endif
                      <td>
                        <input type="text" name="barcode[]" class="form-control barcode" value="{{old('barcode.'.$count)}}" placeholder=" {{__('sales.scanner_input')}}"  id="bar{{$count}}">
                    </td>
                    <td>
                      <input type="text" name="name[]" class="form-control" value="{{old('name.'.$count)}}" id="ar{{$count}}" readonly>
                  </td>
                <td>
                  @if(old('quantity.'.$count))
                  <input id="quantity{{$count}}" type="number" name="quantity[]" min="0" class="form-control" value="{{old('quantity.'.$count)}}" placeholder="{{__('sales.quantity')}}">
                  @else
                  <input id="quantity{{$count}}" type="number" name="quantity[]" min="0" class="form-control" value="1" placeholder="{{__('sales.quantity')}}">
                  @endif
              </td>
                  
                    <td>
                        @if(old('price.'.$count))
                        <input id="price{{$count}}"  type="number" name="price[]" step="0.01" class="form-control target" value="{{old('price.'.$count)}}" placeholder="{{__('sales.price')}}">
                        @else
                        <input id="price{{$count}}"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="{{__('sales.price')}}">
                        @endif
                    </td>
                    <td>
                        <input id="total_price{{$count}}" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="{{__('sales.total_price')}}" readonly>
                    </td>
                    <td>
                      <a id="delete{{$count}}" class="delete"><img src="{{asset('public/img/delete-icon.jpg')}}" width="45px" height="45px"></a>
                  </td>
                  </tr>
                      @endfor
                     </div>
                  </tbody>
                </table>
                <label style="font-weight: bold; color: black"> {{__('purchases.total')}} </label>
                <input type="number" name="sum" id="sum" class="form-control" readonly>
            </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title ">  {{__('purchases.payment_proccess')}} 
          </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="myTable" class="table">
              <thead class="text-primary">
              </thead>
              <tbody>
                 <div>
                  <tr>
                    <td>{{__('purchases.later')}}</td>
                    <td>
                      <input type="radio" name="pay" value="later" class="form-control" checked>
                    </td>
                  </tr>
                  <tr>
                    <td>{{__('purchases.cash')}}</td>
                    <td>
                      @if(old('pay')=='cash')
                      <input type="radio" class="form-control" value="cash" id="cashradio" name="pay" checked>
                      @else
                      <input type="radio" class="form-control" value="cash" id="cashradio" name="pay">
                      @endif
                    </td>
                  </tr>
                  @if(old('pay')=='cash')
                  <tr id="cashoption1">
                  @else
                  <tr id="cashoption1" class="displaynone">
                  @endif
                    <td>   {{__('purchases.cash_from_cashier')}} ({{__('purchases.cashier_balance')}}  {{$repository->balance}})</td>
                    <input type="hidden" id="cash_balance" value="{{$repository->balance}}">
                    <td>
                      <input type="radio" id="cashrad" value="cashier" name="cash_option" checked>
                    </td>
                  </tr>
                  @if(old('pay')=='cash')
                  <tr id="cashoption2">
                    @else
                    <tr id="cashoption2" class="displaynone">
                    @endif
                    <td>{{__('purchases.cash_from_external_budget')}}</td>
                    <td>
                      @if(old('cash_option')=='external')
                      <input type="radio" value="external" name="cash_option" checked>
                      @else
                      <input type="radio" value="external" name="cash_option">
                      @endif
                    </td>
                  </tr>
                 </div>
              </tbody>

            </table>
            <button id="submit"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> {{__('buttons.confirm')}} </button>

        </div>
    </div>
  </div>
</div>
     
                             <!-- Modal for confirming -->
                             <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{__('purchases.confirm_prodcedure')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true"></span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    {{__('purchases.sure_you_want_to_make_this_proccess')}}
                                  </div>
                                  <div class="modal-footer">
                                    <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
                                    <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                                  </div>
                                </div>
                              </div>
                            </div>

</form>

             

  </div>
</div>
</div>
@endsection
@section('scripts')
{{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
    <script>
  var intervalId = window.setInterval(function(){
    var sum = 0 ;
    var count = 100;
  for(var i=0;i<count;i++){
      $('#total_price'+i+'').val($('#price'+i+'').val()*$('#quantity'+i+'').val());
      sum = sum + parseFloat($('#total_price'+i+'').val());
  }
  $('#sum').val(sum);
}, 3000);
</script>

{{--<script>
    var count = 1;
    $('form #plus').on('click',function(){
      $('#record'+count).removeClass('displaynone');
      $('#bar'+count).focus();
      $('#bar'+count).prop('required',true);
      $('#ar'+count).prop('required',true);
      $('#quantity'+count).prop('required',true);
      $('#price'+count).prop('required',true);
      $('#total_price'+count).prop('required',true);
      count = count + 1;
    });
</script>--}}
<script>
  window.onload=function(){
    $('#autofocus').focus();
    $(function () {
  $('[data-toggle="popover"]').popover()
  });
  };
  </script>
  <script>
    $('input[type="radio"]').on('change',function(){
      if($('#cashradio').is(':checked')){
          $('#cashoption1').removeClass('displaynone');
          $('#cashoption2').removeClass('displaynone');
      }
      else{
        $('#cashoption1').addClass('displaynone');
        $('#cashoption2').addClass('displaynone');
      }
    });
  </script>
  <script>   // check the sum by the cashier balance
    $('#sum').on('change',function(){
      
      if($('#cashradio').is(':checked') && $('#cashrad').is(':checked'))
      {
          if(parseFloat($('#sum').val()) > parseFloat($('#cash_balance').val()))
              $('#submit').prop('disabled',true);
              else
              $('#submit').prop('disabled',false);
      }
      else
          $('#submit').prop('disabled',false);

      if(parseFloat($('#sum').val())==0) // no records
        $('#submit').prop('disabled',true);  
    });
  </script>
  <script>    // Ajax
    
    $('.barcode').on('keyup input',function(){
    var barcode = $(this).val();
    var id = $(this).attr("id");  // extract id
    var gold =  id.slice(3);   // remove bar from id to take just the number
    var repo_id = $('#repo_id').val();
    $.ajax({
           type: "get",
           url: '/ajax/get/purchase/product/'+repo_id+'/'+barcode,
           //dataType: 'json',
          success: function(data){    // data is the response come from controller
              if(data != 'no_data'){
              $('#'+id).addClass('success').removeClass('failed');
              $('#ar'+gold+'').val(data.name_ar);
              $('#price'+gold+'').val(data.price);
              $('#price'+gold+'').prop('readonly',false);
              }
              else{
                $('#'+id).addClass('failed').removeClass('success');
                $('#ar'+gold+'').val(null);
                $('#price'+gold+'').val(0);
                $('#price'+gold+'').prop('readonly',true);
              }
          }
    }); // ajax close
  });

</script>

<script>
  
     $(".barcode").autocomplete({
        
         source: function(request, response) {
             $.ajax({
             url: "{{url('autocomplete/purchase/products')}}",
             data: {
                     term : request.term,
                     repos_id : $('#repo_id').val(),
              },
             dataType: "json",
             success: function(data){
               //alert(data);
                var resp = $.map(data,function(obj){
                     return obj.barcode;
                }); 
 
                response(resp);
             }
             
         });
         
     },
     select: function (event, ui) {     // listen to the event when we select an option  
      setTimeout(    // wait 1 second then get the barcode id
      function() 
      {     
            //alert('yes');
            var barcode = $(':focus').val();
            var id = $(':focus').attr("id");  // extract id
            var gold =  id.slice(3);   // remove bar from id to take just the number
            var repo_id = $('#repo_id').val();
    $.ajax({
           type: "get",
           url: '/ajax/get/purchase/product/'+repo_id+'/'+barcode,
           //dataType: 'json',
          success: function(data){    // data is the response come from controller
              if(data != 'no_data'){
              $('#'+id).addClass('success').removeClass('failed');
              $('#ar'+gold+'').val(data.name_ar);
              $('#price'+gold+'').val(data.price);
              $('#price'+gold+'').prop('readonly',false);
              }
              else{
                $('#'+id).addClass('failed').removeClass('success');
                $('#ar'+gold+'').val(null);
                $('#price'+gold+'').val(0);
                $('#price'+gold+'').prop('readonly',true);
              }
          }
    }); // ajax close
  }, 100);
            },
     minLength: 1
  });

 
 </script>   
<script>   // stop submiting form when click enter
  $('form').keypress(function(e) {
      if (e.keyCode == 13) {
          e.preventDefault();
          return false;
      }
  });
  </script>
  {{--
  <script>
  $('form').keypress(function(e) {
    if (e.keyCode == 13) {
      // Get the focused element:
      var focused = $(':focus');
      var id = focused.attr("id");  // extract id
      var gold =  id.slice(3);   // remove bar from id to take just the number
      var count = parseInt(gold) +1;
      // focus on next element
      $('#record'+count).removeClass('displaynone');
      $('#bar'+count+'').focus();
      //$('#bar'+count).prop('required',true);
      $('#ar'+count).prop('required',true);
      $('#quantity'+count).prop('required',true);
      $('#price'+count).prop('required',true);
      $('#total_price'+count).prop('required',true);
    }
    });
  </script> --}}
  <script>
    $('form').keypress(function(e) {
      if (e.keyCode == 13) {
        // Get the focused element:
        var focused = $(':focus');
        var id = focused.attr("id");  // extract id
        var string = id.slice(0, 3); // take first 3 character from id to check its bar or pri we are focused in
        if(string == 'bar')
        var gold =  id.slice(3);   // remove bar from id to take just the number
        else // we are focused on price input
        var gold =  id.slice(5);   // remove price from id to take just the number
        var count = parseInt(gold) +1;
        // focus on next element
        $('#record'+count).removeClass('displaynone');
        $('#bar'+count+'').focus();
        //$('#bar'+count).prop('required',true);
        $('#ar'+count).prop('required',true);
        $('#quantity'+count).prop('required',true);
        $('#price'+count).prop('required',true);
        $('#price'+count).prop('readonly',true);
        $('#total_price'+count).prop('required',true);
      }
      });
    </script>
  <script>  // delete record by clicking the icon
    $('.delete').on('click',function(){
      var id = $(this).attr("id");  // extract id
      var gold =  id.slice(6);   // remove bar from id to take just the number
              $('#bar'+gold+'').val(null);
              $('#ar'+gold+'').val(null);
              $('#price'+gold+'').val(0);
              $('#price'+gold+'').prop('readonly',true);
              $('#bar'+gold).removeClass('failed').removeClass('success');
    });
  </script>
@endsection