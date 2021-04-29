@extends('layouts.main')

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
                      ID
                    </th>
                    <th>
                      معلومات المنتج 
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
                     <td>{{$product->id}}</td>
                     <td>
                        {{$product->details}}
                     </td>
                     <td>
                        {{$product->price}}
                    </td>
                    <td>
                        {{$product->quantity}}
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection