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
#submit{
  position: fixed;
  left: 965px;
  top: 230px;
  z-index: 2;
}
.row{
  margin-right: 100px;
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
  <div  class="container-fluid">
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
                </thead>

                <tbody>
                  @for ($count=0;$count<=90;$count++)
                   <div class="record">
                    <tr>
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
                      <td>
                        <input type="text" id="price{{$count}}"  name="price[]" value="{{old('price.'.$count)}}" class="form-control price blank">
                      </td>
                      <td>
                        @if(old('quantity.'.$count))
                        <input type="text" id="quantity{{$count}}" name="quantity[]" value="{{old('quantity.'.$count)}}" class="form-control" placeholder="الكمية">
                        @else
                        <input type="text" id="quantity{{$count}}" name="quantity[]"  class="form-control" value="1" placeholder="الكمية">
                        @endif
                    </td>
                </tr>
            </div>
            @endfor
         </tbody>
       </table>
       <button id="submit"  type="submit" class="btn btn-success"> عرض الفاتورة</button>
       {{--<i class="material-icons">add_circle</i>--}}
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
{{--<script>
    var count = 1;
    $('form i').on('click',function(){
    $('#myTable tr:last').after('<tr><td><input type="text" name="barcode[]" id="bar'+count+'" class="form-control barcode" placeholder="مدخل خاص ب scanner" required></td> <td><input type="text" name="name[]" id="name'+count+'" class="form-control name" readonly></td><td><input type="text" name="details[]" id="details'+count+'" class="form-control details" readonly></td><td><input type="text" name="price[]" id="price'+count+'" class="form-control price" readonly></td><td><input type="number" id="quantity'+count+'" name="quantity[]" class="form-control" placeholder="الكمية" value="1" required></td> </tr>');
    $('#myTable').find('#bar'+count+'').focus();   // we use find to select new added element
    count = count +1;
    //$('.barcode').last().focus();
  });
</script>--}}
<script>
window.onload=function(){
  $('#bar0').focus();
};
</script>
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
              $('#name'+gold+'').addClass('ajaxSuccess');
              $('#details'+gold+'').val(value.details);
              $('#details'+gold+'').addClass('ajaxSuccess');
              $('#price'+gold+'').val(value.price);
              $('#price'+gold+'').addClass('ajaxSuccess');
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
@endsection