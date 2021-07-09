@extends('layouts.main')
@section('links')
<style>
form i{
  float: left;
}
form #plus:hover{
  cursor: pointer;
}
form #tooltip:hover{
  cursor: default;
}
.displaynone{
  display: none;
}
</style>
@endsection
@section('body')
<div class="main-panel">
 
 <div class="content">
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
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
        <form method="POST" action="{{route('store.supplier',$repository->id)}}">
            @csrf
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__('purchases.add_supplier')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="myTable" class="table">
                  <thead class="text-primary">
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
                     <div id="record">
                      <tr>
                        <td>
                            <input type="text" name="name" class="form-control" placeholder="{{__('purchases.name')}}" id="autofocus"  required>
                        </td>
                        <td>
                          <input type="text" name="address" class="form-control" placeholder="{{__('purchases.address')}}" required>
                        </td>
                        <td>
                         <input type="text" name="phone"  class="form-control"  placeholder="{{__('purchases.phone')}}" required>
                        </td>
                        <td>
                            <input type="text" name="account_num"  class="form-control"  placeholder="{{__('purchases.account_num')}}" required>
                           </td>
                    
                        
                      </tr>
                      
                     </div>
                  </tbody>
                </table>
                <button  type="submit" class="btn btn-primary"> {{__('buttons.add')}} </button>
            </div>
        </div>
      </div>
    </div>
</form>
  </div>
</div>
</div>
@endsection
@section('scripts')
<script>
    window.onload=function(){
      $('#autofocus').focus();
    };
</script>
@endsection