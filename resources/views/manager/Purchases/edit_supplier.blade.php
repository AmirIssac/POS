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
              <h4 class="card-title"> {{__('purchases.edit_supplier_data')}}   {{$supplier->name}}  </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <form action="{{route('update.supplier')}}" method="POST">
                    @csrf
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('purchases.name')}}  
                      </th>
                      <th>
                        {{__('purchases.address')}}
                      </th>
                      <th>
                        {{__('purchases.phone')}} 
                      </th>
                      <th>
                        {{__('purchases.account_num')}}  
                      </th>
                  </thead>
                  <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="supplier_id" value="{{$supplier->id}}">
                            <input type="text" name="name" class="form-control" placeholder="{{__('purchases.name')}}" id="autofocus" value="{{$supplier->name}}"  required>
                        </td>
                        <td>
                          <input type="text" name="address" class="form-control" placeholder="{{__('purchases.address')}}" value="{{$supplier->address}}" required>
                        </td>
                        <td>
                         <input type="text" name="phone"  class="form-control"  placeholder="{{__('purchases.phone')}}" value="{{$supplier->phone}}" required>
                        </td>
                        <td>
                            <input type="text" name="account_num"  class="form-control"  placeholder="{{__('purchases.account_num')}}" value="{{$supplier->account_num}}" required>
                           </td>
                      </tr>                      
                  </tbody>
                </table>
                <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>

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