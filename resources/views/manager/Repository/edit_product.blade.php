@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
  #warning{
    font-size: 38px;
  }
  #code{
    float: left;
  }
  #myTable th{
   color: black;
   font-weight: bold;
  }
  #myTable td{
   color: black;
   font-weight: bold;
  }
</style>
@endsection
@section('body')
<div class="main-panel">
    @if (session('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('success') }}</strong>
    </div>
    @endif
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> تعديل منتج </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <form action="{{route('update.product')}}" method="POST">
                    @csrf
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                        الباركود
                    </th>
                    <th>
                      الاسم  
                    </th>
                    <th>
                      التفاصيل  
                    </th>
                    <th>
                        سعر التكلفة  
                    </th>
                    <th>
                        سعر البيع  
                      </th>
                      <th>
                        الكمية  
                      </th>
                  </thead>
                  <tbody>
                   <tr>
                      
                       <td>
                          <input type="hidden" name="product_id" class="form-control" value="{{$product->id}}">
                           <input type="text" name="barcode" class="form-control" value="{{$product->barcode}}" required>
                       </td>
                       <td>
                        <input type="text" name="name" class="form-control" value="{{$product->name}}" required>
                       </td>
                       <td>
                        <input type="text" name="details" class="form-control" value="{{$product->details}}" required>
                       </td>
                       <td>
                        <input type="number" name="cost_price" min="0.01" step="0.01" class="form-control" value="{{$product->cost_price}}" required>
                       </td>
                       <td>
                        <input type="number" name="price" min="0.01" step="0.01"  class="form-control" value="{{$product->price}}" required>
                       </td>
                       <td>
                        <input type="number" name="quantity" min="0" class="form-control" value="{{$product->quantity}}" required>
                       </td>
                       <td>
                           <button type="submit" class="btn btn-success"> تأكيد </button>
                       </td>
                   </tr>
                  </tbody>
                </table>
            </form>

              </div>
              </div>
            </div>
           
          </div>
        </div>
       

      </div>
     
    </div>
</div>
@endsection