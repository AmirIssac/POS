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
  
<div class="content">
  @if (session('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('success') }}</strong>
  </div>
  @endif
  @if (session('fail'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('fail') }}</strong>
  </div>
  @endif
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">  {{$user->name}} </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <form action="{{route('update.worker.info',$user->id)}}" method="POST">
                    @csrf
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('sales.name')}}
                    </th>
                    <th>
                      {{__('settings.email')}} 
                    </th>
                    <th>
                        {{__('sales.phone')}}  
                    </th>
                  </thead>
                  <tbody>
                   <tr>
                       <td>
                           <input type="text" name="name" class="form-control" value="{{$user->name}}" required>
                       </td>
                       <td>
                        <input type="hidden" name="old_email" class="form-control" value="{{$user->email}}" required>
                        <input type="text" name="email" class="form-control" value="{{$user->email}}" required>
                       </td>
                       <td>
                        <input type="text" name="phone" class="form-control" value="{{$user->phone}}" required>
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