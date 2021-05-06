@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
</style>
@endsection
@section('body')
<div class="main-panel">

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title float-right">كل المنتجات</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
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
                        السعر  
                    </th>
                    <th>
                        الكمية المتوفرة  
                    </th>
                  </thead>
                  <tbody>
                    @if($products && $products->count()>0)
                    @foreach($products as $product)
                    <tr>
                     <td>{{$product->barcode}}</td>
                     <td>{{$product->name}}</td>
                     <td>
                        {{$product->details}}
                     </td>
                     <td>
                        {{$product->price}}
                    </td>
                    <td>
                      @if($product->quantity<=10)
                        <span class="badge badge-danger">
                        {{$product->quantity}}
                        </span>
                      @elseif ($product->quantity>10 && $product->quantity<50)  
                        <span class="badge badge-warning">
                        {{$product->quantity}}
                        </span>
                      @else
                      <span class="badge badge-success">
                        {{$product->quantity}}
                        </span>
                      @endif
                    </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td>
                            <span class="badge badge-warning">
                            المخزن فارغ لا يوجد أي منتجات
                            </span>
                        </td>
                    </tr>
                    @endif
                  </tbody>
                </table>
                {{ $products->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection