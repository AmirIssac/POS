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
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">  {{$user->name}} </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                
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
                    <th>
                        {{__('settings.roles')}}  
                    </th>
                  </thead>
                  <tbody>
                   <tr>
                       <td>
                           {{$user->name}}
                       </td>
                       <td>
                        {{$user->email}}
                       </td>
                       <td>
                       {{$user->phone}}
                       </td>
                       <td>
                           <select class="form-control">
                               @foreach($user->getRoleNames() as $role)
                                <option>{{$role}}</option>
                                @endforeach
                           </select>
                       </td>

                   </tr>
                  </tbody>
                </table>

              </div>
              </div>
            </div>
           
          </div>

          <div class="col-md-12">
          
            <div class="card">
              <div class="card-header card-header-warning">
                <h4 class="card-title">  {{__('settings.do_you_want_change_password')}} </h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <form action="{{route('change.password',$user->id)}}" method="POST">
                      @csrf
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        {{__('settings.old_password')}}
                      </th>
                      <th>
                        {{__('settings.new_password')}}  
                      </th>
                      <th>
                        {{__('settings.confirm_new_password')}}    
                      </th>
                      
                    </thead>
                    <tbody>
                     <tr>
                         <td>
                             <input type="password" name="old_password" class="form-control">
                         </td>
                         <td>
                            <input type="password" name="new_password" class="form-control">
                        </td>
                         <td>
                            <input type="password" name="confirm_password" class="form-control">
                        </td>
                         <td>
                             <button class="btn btn-danger">{{__('buttons.confirm')}}</button>
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