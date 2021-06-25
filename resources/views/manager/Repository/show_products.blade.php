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
              <h4 class="card-title">{{__('repository.all_products')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
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
                    @if($repository->isSpecial())
                    <th>
                      {{__('repository.product_type')}} 
                    </th>
                    <th>
                      {{__('repository.accept_min')}}
                    </th>
                    @endif
                    @can('مشاهدة سعر التكلفة')
                    <th>
                      {{__('reports.cost_price')}}   
                  </th>
                  @endcan
                    <th>
                      {{__('sales.sell_price')}}   
                    </th>
                    <th>
                      {{__('repository.quantity_available')}}   
                    </th>
                    <th>
                         
                  </th>
                  <th>
   
                </th>
                  </thead>
                  <tbody>
                    @if($products && $products->count()>0)
                    @foreach($products as $product)
                    <tr>
                     <td>{{$product->barcode}}</td>
                     <td>{{$product->name_ar}}</td>
                     <td>
                        {{$product->name_en}}
                     </td>
                     @if($repository->isSpecial())
                     <td>
                      @if(LaravelLocalization::getCurrentLocale() == 'ar')
                       {{$product->type->name_ar}}
                       @endif
                       @if(LaravelLocalization::getCurrentLocale() == 'en')
                       {{$product->type->name_en}}
                       @endif
                     </td>
                     <td>
                       @if($product->isAcceptMin())
                       {{__('repository.yes')}}
                        @else
                        {{__('repository.no')}}
                       @endif
                     </td>
                     @endif
                     @can('مشاهدة سعر التكلفة')
                     <td>
                      {{$product->cost_price}}
                    </td>
                    @endcan
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
                    <td>
                      <form action="{{route('edit.product')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="hidden" name="repository_id" value="{{$repository->id}}">
                        <button type="submit" class="btn btn-info"> {{__('buttons.edit')}} </button>
                      </form>
                    </td>
                    <td>
                      <form action="{{route('delete.product')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <button type="submit" class="btn btn-danger"> {{__('buttons.delete')}} </button>
                      </form>
                    </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td>
                            <span class="badge badge-warning">
                              {{__('repository.repository_empty')}}
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