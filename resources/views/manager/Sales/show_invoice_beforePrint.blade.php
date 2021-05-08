@extends('layouts.main')
@section('links')
<style>
  #total_price{
    font-size: 32px;
    background-color: white !important;
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
  <form method="POST" action="{{route('make.sell',$repository->id)}}">
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
                    <i class="fa fa-info"></i> تفاصيل الفاتورة </span> </h4>
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
                       <?php $count=0; ?>
                       @foreach($products as $product)
                    <tr>
                      {{--  inputs we need to sell process --}}
                      <input type="hidden" name="barcode[]" value="{{$product->barcode}}">
                      
                      <td>
                        {{$product->name}}
                      </td>
                      <td>
                        {{$product->details}}
                     </td>
                     <td>
                       <input type="hidden" name="price[]"  class="form-control price" value="{{$product->price}}">
                        {{$product->price}}
                     </td>
                     <td>
                      <input type="number" name="quantity[]"  class="form-control quantity" value="{{$quantities[$count]}}">
                       {{-- {{$quantities[$count]}}  --}}
                     </td>
                </tr>
                <?php $count++ ?>
                @endforeach
            </div>
         </tbody>
       </table>
       <div>
         <span class="badge badge-info">
           <h6>المبلغ الإجمالي</h6> 
         </span>
         {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
         <input type="number" name="total_price" id="total_price" class="form-control" value="{{$invoice_total_price}}" readonly>
       </div>
        {{--<button onclick="window.print();" class="btn btn-success"> طباعة </button>--}}
        <button onclick="window.print();" type="submit" class="btn btn-danger"> تأكيد الفاتورة وطباعتها </button>
        <a href="{{route('create.invoice',$repository->id)}}" class="btn btn-warning"> فاتورة جديدة </a>
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
  var c = $('input[name="barcode[]"]');
  var count = c.length;    // number of records
  var intervalId = window.setInterval(function(){
   // $('#total_price').val(0);
   var sum = 0 ;
  for(var i=0;i<count;i++){
    sum = sum + $('.price').eq(i).val()*$('.quantity').eq(i).val();
    //$('#total_price').val($('#total_price').val()+($('.price').eq(i).val()*$('.quantity').eq(i).val()));
  }
  $('#total_price').val(sum);
}, 1000);
</script>
@endsection