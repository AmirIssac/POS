@extends('layouts.main')
@section('links')
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
        <form method="POST" action="#">
            @csrf
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
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
                            <td>رقم الفاتورة</td>
                            <td><span style="font-size: 22px;" class="badge badge-primary">{{$code}}</span>
                              <input type="hidden" name="code" value="{{$code}}">
                            </td>
                          </tr>
                          <tr>
                            <td>المورد</td>
                            <td>
                              <select name="supplier_id" class="form-control">
                                @foreach($suppliers as $supplier)
                                  <option value="" disabled selected hidden> اختيار المورد من هنا </option>
                                  <option value="{{$supplier->id}}"> {{$supplier->name}} </option>
                                @endforeach
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td> رقم فاتورة المورد </td>
                            <td><input type="text" name="supplier_invoice_num" class="form-control" placeholder="رقم فاتورة المورد"></td>
                          </tr>
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
              <h4 class="card-title ">المشتريات</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="myTable" class="table">
                  <thead class="text-primary">
                    <th>
                      Barcode  
                    </th>
                    <th>
                        الاسم
                    </th>
                    <th>
                      {{__('sales.quantity')}} 
                    </th>
                    <th>
                        سعر الوحدة
                    </th>
                    <th>   {{-- for future use to save every input details in table of repository inputs --}}
                      المجموع
                      <td>
                      <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title=" المجموع =" data-content=" سعر الوحدة X {{__('sales.quantity')}}">live_help</i>
                      </td>
                    </th>
                  </thead>
                  <tbody>
                     <div id="record">
                      <tr>
                        <td>
                            <input type="text" name="barcode[]" class="form-control barcode" placeholder=" {{__('sales.scanner_input')}} " id="autofocus"  required>
                        </td>
                        <td>
                          <input type="text" name="name[]" class="form-control" placeholder="اكتب الاسم هنا" id="ar0" required>
                      
                  
                    <td>
                      <input id="quantity0" type="number" name="quantity[]" min="0" class="form-control" value="1" placeholder="{{__('sales.quantity')}}" required>
                  </td>
                      
                        <td>
                            <input id="price0"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="{{__('sales.price')}}" required>
                        </td>
                        <td>
                            <input id="total_price0" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="{{__('sales.total_price')}}" required>
                            <input type="hidden" name="repo_id" value="{{$repository->id}}">
                        </td>  
                        
                      </tr>
                      @for ($count=1;$count<=100;$count++)
                      <tr id="record{{$count}}" class="displaynone">
                      <td>
                        <input type="text" name="barcode[]" class="form-control barcode" placeholder=" {{__('sales.scanner_input')}}"  id="bar{{$count}}">
                    </td>
                    <td>
                      <input type="text" name="name[]" class="form-control" placeholder="اكتب الاسم هنا" id="ar{{$count}}">
                  </td>
                <td>
                  <input id="quantity{{$count}}" type="number" name="quantity[]" min="0" class="form-control" value="1" placeholder="{{__('sales.quantity')}}">
              </td>
                  
                    <td>
                        <input id="price{{$count}}"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="{{__('sales.price')}}">
                    </td>
                    <td>
                        <input id="total_price{{$count}}" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="{{__('sales.total_price')}}">
                    </td>
                  </tr>
                      @endfor
                     </div>
                  </tbody>
                </table>
                <label style="font-weight: bold; color: black"> المجموع </label>
                <input type="number" name="sum" id="sum" class="form-control" readonly>
                <i id="plus" class="material-icons">add_circle</i>
            </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title ">  عملية الدفع
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
                    <td>آجل</td>
                    <td>
                      <input type="radio" name="pay" class="form-control" checked>
                    </td>
                  </tr>
                  <tr>
                    <td>كاش</td>
                    <td>
                      <input type="radio" class="form-control" id="cashradio" name="pay">
                    </td>
                  </tr>
                  <tr id="cashoption1" class="displaynone">
                    <td>كاش من درج الكاشير (رصيد الدرج {{$repository->cash_balance}})</td>
                    <input type="hidden" id="cash_balance" value="{{$repository->cash_balance}}">
                    <td>
                      <input type="radio" id="cashrad" name="cash_option">
                    </td>
                  </tr>
                  <tr id="cashoption2" class="displaynone">
                    <td>كاش من ميزانية خارجية مخصصة</td>
                    <td>
                      <input type="radio" name="cash_option">
                    </td>
                  </tr>
                 </div>
              </tbody>

            </table>
            <button id="submit"  type="submit" class="btn btn-primary"> {{__('buttons.confirm')}} </button>

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
<script>
  
</script>
<script>
  var intervalId = window.setInterval(function(){
    var sum = 0 ;
  for(var i=0;i<count;i++){
      $('#total_price'+i+'').val($('#price'+i+'').val()*$('#quantity'+i+'').val());
      sum = sum + parseFloat($('#total_price'+i+'').val());
  }
  $('#sum').val(sum);
}, 3000);
</script>

<script>
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
</script>
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
    });
  </script>
@endsection