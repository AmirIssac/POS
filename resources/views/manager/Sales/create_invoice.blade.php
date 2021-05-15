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
  <form method="GET" action="{{route('invoice.details',$repository->id)}}">
    @csrf
  <div class="container-fluid">
    <div class="row">
      
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">اضافة فاتورة جديدة</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="myTable" class="table">
                <thead class="text-primary">
                  <th>
                    Barcode  
                  </th>
                  <th>
                    الكمية 
                  </th>
                </thead>
                <tbody>
                   <div id="record">
                    <tr>
                      <td>
                          <input type="text" name="barcode[]" class="form-control barcode" placeholder="مدخل خاص ب scanner" id="autofocus" required>
                      </td>
                      <td>
                        <input type="text" name="quantity[]" class="form-control" value="1" placeholder="الكمية" required>
                    </td>
                </tr>
            </div>
         </tbody>
       </table>
       <button  type="submit" class="btn btn-primary"> عرض الفاتورة</button>
       <i class="material-icons">add_circle</i>
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
    var count = 1;
    $('form i').on('click',function(){
    $('#myTable tr:last').after('<tr><td><input type="text" name="barcode[]" id="bar'+count+'" class="form-control" placeholder="مدخل خاص ب scanner" required></td> <td><input type="number" id="quantity'+count+'" name="quantity[]" class="form-control" placeholder="الكمية" value="1" required></td> </tr>');
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