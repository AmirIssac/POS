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
                   <div id="record">
                    <tr>
                      <td>
                        <input type="hidden" name="repo_id" id="repo_id" class="form-control" value="{{$repository->id}}">
                          <input type="text" name="barcode[]" id="bar0" class="form-control barcode" placeholder="مدخل خاص ب scanner" id="autofocus" required>
                      </td>
                      <td>
                        <input type="text" id="name0" name="name[]" class="form-control name" readonly>
                      </td>
                      <td>
                        <input type="text" id="details0" name="details[]" class="form-control details" readonly>
                      </td>
                      <td>
                        <input type="text" id="price0" name="price[]" class="form-control price" readonly>
                      </td>
                      <td>
                        <input type="text" name="quantity[]" class="form-control" value="1" placeholder="الكمية" required>
                    </td>
                </tr>
            </div>
         </tbody>
       </table>
       <button  type="submit" class="btn btn-primary"> عرض الفاتورة</button>
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
    /*var count = 1;*/
     const interval =
     setInterval(function() {
   // method to be executed;
    
    //$('#btn-ajax').on('click',function(){
    
    $('#myTable').find('#bar0,#bar1,#bar2,#bar3,#bar4,#bar5,#bar6,#bar7,#bar8,#bar9,#bar10,#bar11,#bar12,#bar13,#bar14,#bar15,#bar16,#bar17,#bar18,#bar19,#bar20,#bar21,#bar22,#bar23,#bar24,#bar25,#bar26,#bar27,#bar28,#bar29,#bar30,#bar31').on('keyup',function(){
      /*var myJsonData = {repo_id: 1 , barcode:123};
      $.get("{{URL::to('/ajax/get/product')}}" , myJsonData, , function(data){
      console.log(data);
    });*/

   
    /*var count = $('#myTable').find('.barcode').length;
    console.log(count);*/
    //var k;
    //for( k=0 ; k<100 ; k++){
    var barcode = $(this).val();
    //$(this).attr('readonly','readonly');
    //$(this).fadeOut();
    //console.log(barcode);
    var test = $(this).attr("id");  // extract id
    var gold =  test.slice(3);   // remove bar from id to take just the number
    //var barcode = $('#myTable').find('#bar'+k+'').val();
    var repo_id = $('#repo_id').val();
    $.ajax({
           type: "get",
           url: '/ajax/get/product/'+repo_id+'/'+barcode,
           //dataType: 'json',
          success: function(data){    // data is the response come from controller
            $.each(data,function(i,value){
              //for(var j=0 ; j<200 ; j++){
              //console.log(value.name);
              //console.log(gold);
              //console.log(k);
              //console.log($('#myTable').find('.name',k));
              //console.log($('#myTable').find('.name').eq(1).val());
              $('#myTable').find('#name'+gold+'').val(value.name);
              $('#myTable').find('#details'+gold+'').val(value.details);
              $('#myTable').find('#price'+gold+'').val(value.price);
              //$('#myTable').find('.name',k).val(value.name);    // eq(k)
              //$('#myTable').find('.details',k).val(value.details);
             // $('#myTable').find('.price',k).val(value.price);
              //}
           });
          }
    }); // ajax close
    /*if($('#myTable').find('#name'+gold+'').val()!=""){
           $('#myTable tr:last').after('<tr><td><input type="text" name="barcode[]" id="bar'+count+'" class="form-control barcode" placeholder="مدخل خاص ب scanner" required></td> <td><input type="text" name="name[]" id="name'+count+'" class="form-control name" readonly></td><td><input type="text" name="details[]" id="details'+count+'" class="form-control details" readonly></td><td><input type="text" name="price[]" id="price'+count+'" class="form-control price" readonly></td><td><input type="number" id="quantity'+count+'" name="quantity[]" class="form-control" placeholder="الكمية" value="1" required></td> </tr>');
            $('#myTable').find('#bar'+count+'').focus();   // we use find to select new added element
            count = count +1;}*/
          
       //console.log(data);
       
    /*$.ajax({
      url: '/ajax/get/product',
      type: "get",
      data:{ _token: "{{csrf_token()}}", repo_id: 1, barcode: 123 },
      dataType: 'json',
    });*/
  //});
  //} // for k loop
  });
}, 500);
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
  var count = 1;
  $(document).keypress(function(e) {
    if (e.keyCode == 13) {
  $('#myTable tr:last').after('<tr><td><input type="text" name="barcode[]" id="bar'+count+'" class="form-control barcode" placeholder="مدخل خاص ب scanner" required></td> <td><input type="text" name="name[]" id="name'+count+'" class="form-control name" readonly></td><td><input type="text" name="details[]" id="details'+count+'" class="form-control details" readonly></td><td><input type="text" name="price[]" id="price'+count+'" class="form-control price" readonly></td><td><input type="number" id="quantity'+count+'" name="quantity[]" class="form-control" placeholder="الكمية" value="1" required></td> </tr>');
  $('#myTable').find('#bar'+count+'').focus();   // we use find to select new added element
  count = count +1;
    }
  //$('.barcode').last().focus();
});
</script>
@endsection