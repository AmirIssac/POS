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
              <h4 class="card-title"> {{__('repository.edit_product')}}  </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <form action="{{route('update.product')}}" method="POST">
                    @csrf
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                        Barcode
                    </th>
                    <th>
                      {{__('repository.arabic_name')}}  
                    </th>
                    <th>
                      {{__('repository.english_name')}} 
                    </th>
                    @if($repository->isSpecial())  {{-- محل خاص --}}
                    <th>
                      {{__('repository.product_type')}} 
                    </th>
                    <th>
                      {{__('repository.accept_min')}}  
                    </th>
                    @endif
                    <th>
                      {{__('reports.cost_price')}}   
                    </th>
                    <th>
                      {{__('sales.sell_price')}}   
                      </th>
                      <th>
                        {{__('sales.quantity')}}  
                      </th>
                  </thead>
                  <tbody>
                   <tr>
                      
                       <td>
                          <input type="hidden" name="product_id" class="form-control" value="{{$product->id}}">
                          <input type="hidden" name="old_barcode" class="form-control" value="{{$product->barcode}}">
                           <input type="text" name="barcode" class="form-control" value="{{$product->barcode}}" required>
                       </td>
                       <td>
                        <input type="text" name="name" class="form-control" value="{{$product->name_ar}}" required>
                       </td>
                       <td>
                        <input type="text" name="details" class="form-control" value="{{$product->name_en}}">
                       </td>
                     @if($repository->isSpecial())  {{-- محل خاص --}}
                      <td>
                      <select name="type" class="form-control">
                        @if(LaravelLocalization::getCurrentLocale() == 'ar')
                        @foreach($types as $type)
                        @if($product->type_id == $type->id)
                        <option value="{{$type->id}}" selected>{{$type->name_ar}}</option>
                        @else
                        <option value="{{$type->id}}">{{$type->name_ar}}</option>
                        @endif
                        @endforeach
                        @endif

                        @if(LaravelLocalization::getCurrentLocale() == 'en')
                        @foreach($types as $type)
                        @if($product->type_id == $type->id)
                        <option value="{{$type->id}}" selected>{{$type->name_en}}</option>
                        @else
                        <option value="{{$type->id}}">{{$type->name_en}}</option>
                        @endif
                        @endforeach
                        @endif
                      </select>
                      </td>
                      <td>
                        @if($product->isAcceptMin())
                       <input type="checkbox" name="acceptmin" class="form-control" value="1" checked>
                       @else
                       <input type="checkbox" name="acceptmin" class="form-control" value="1">
                       @endif
                      </td>
                     @endif
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
                           <button type="submit" class="btn btn-success"> {{__('buttons.confirm')}} </button>
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