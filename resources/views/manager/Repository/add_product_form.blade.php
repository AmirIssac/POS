@extends('layouts.main')
@section('links')
<style>
form i{
  float: left;
}
form i:hover{
  cursor: pointer;
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
        <form method="POST" action="{{route('store.product')}}">
            @csrf
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">اضافة منتج للمخزون</h4>
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
                      التفاصيل 
                    </th>
                    <th>
                      الكمية 
                    </th>
                    <th>
                      سعر التكلفة 
                    </th>
                    <th>
                      السعر 
                    </th>
                    <th>   {{-- for future use to save every input details in table of repository inputs --}}
                      المبلغ الإجمالي 
                    </th>
                  </thead>
                  <tbody>
                     <div id="record">
                      <tr>
                        <td>
                            <input type="text" name="barcode[]" class="form-control barcode" placeholder="مدخل خاص ب scanner" id="autofocus"  required>
                        </td>
                        <td>
                          <input type="text" name="name[]" class="form-control" placeholder="اسم المنتج" required>
                      </td>
                      <td>
                        <input type="text" name="details[]" class="form-control" placeholder="تفاصيل المنتج" required>
                    </td>
                    <td>
                      <input id="quantity0" type="number" name="quantity[]" class="form-control" value="1" placeholder="الكمية" required>
                  </td>
                      <td>
                        <input id="cost_price0"  type="number" name="cost_price[]" step="0.01" class="form-control" value="0" placeholder="سعر التكلفة" required>
                      </td>
                        <td>
                            <input id="price0"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="السعر" required>
                        </td>
                        <td>
                            <input id="total_price0" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="المبلغ الإجمالي" required>
                            <input type="hidden" name="repo_id" value="{{$repository->id}}">
                        </td>
                        
                            
                        
                      </tr>
                     </div>
                  </tbody>
                </table>
                <button  type="submit" class="btn btn-primary"> إضافة </button>
                <i class="material-icons">add_circle</i>
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
   /* $("input[name=price]").keyup(function(){
    $('input[name=total_price]').val($('input[name=price]').val()*$('input[name=quantity]').val());
    });
    $("input[name=quantity]").keyup(function(){
    $('input[name=total_price]').val($('input[name=price]').val()*$('input[name=quantity]').val());
    });
  */
</script>
<script>
  var intervalId = window.setInterval(function(){
  for(var i=0;i<count;i++){
      $('#myTable').find('#total_price'+i+'').val($('#myTable').find('#cost_price'+i+'').val()*$('#myTable').find('#quantity'+i+'').val());
  }
}, 500);
</script>
<script>

  // create new input record after click + button and focus into scanner input
  //$('.target').last().focus(function() {
    var count = 1;
    $('form i').on('click',function(){
    $('#myTable tr:last').after('<tr><td><input type="text" name="barcode[]" id="bar'+count+'" class="form-control" placeholder="مدخل خاص ب scanner" required></td> <td><input type="text" name="name[]" class="form-control" placeholder="اسم المنتج" required></td><td><input type="text" name="details[]" class="form-control" placeholder="تفاصيل المنتج" required></td><td><input type="number" id="quantity'+count+'" name="quantity[]" class="form-control" placeholder="الكمية" required></td><td><input id="cost_price'+count+'"  type="number" name="cost_price[]" step="0.01" class="form-control" value="0" placeholder="سعر التكلفة" required></td><td><input  type="number" id="price'+count+'" name="price[]" step="0.01" class="form-control target" value="0" placeholder="السعر" required></td><td><input type="number" id="total_price'+count+'" name="total_price[]" step="0.01" class="form-control" placeholder="المبلغ الإجمالي"><input type="hidden" name="repo_id" value="{{$repository->id}}"></td></tr>');
    $('#myTable').find('#bar'+count+'').focus();   // we use find to select new added element
    count = count +1;
    //$('.barcode').last().focus();
  });
</script>
<script>
  window.onload=function(){
    $('#autofocus').focus();
  };
  </script>
@endsection