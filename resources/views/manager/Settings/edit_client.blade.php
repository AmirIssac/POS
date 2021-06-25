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
              <h4 class="card-title">  {{$customer->name}} </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <form action="{{route('update.client',$customer->id)}}" method="POST">
                    @csrf
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('sales.customer_mobile')}}  
                    </th>
                    <th>
                      {{__('sales.name')}}  
                    </th>
                    <th>
                      {{__('sales.confirm')}}  
                    </th>
                  </thead>
                  <tbody>
                   <tr>
                      
                       <td>
                           <input type="text" name="phone" class="form-control" value="{{$customer->phone}}">
                       </td>
                       <td>
                        <input type="text" name="name" class="form-control" value="{{$customer->name}}">
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