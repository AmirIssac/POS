@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
   /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
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
    @if (session('errors'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('errors') }}</strong>
    </div>
    @endif
 
    <div class="container-fluid">
      <form action="{{route('submit.settings.app',$repository->id)}}"  method="post" enctype="multipart/form-data">
        @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{__('settings.repository_logo')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('settings.repository_logo')}}
                    </th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                          <input type="file" name="logo" class="form-control">
                      </td>
                      <td>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      


     {{-- @if($repository->isSpecial())
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{__('settings.prod_types')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('settings.determine_types')}} 
                    </th>
                  </thead>
                  <tbody>
                    <tr>
                      <select class="form-control">  
                      @foreach($repository->types as $type)
                      <option value="" disabled selected hidden> {{__('settings.click_here_to_see_types')}} </option>
                      <option disabled> {{$type->name}} </option>
                      @endforeach
                      </select>
                    </tr>
                    <tr>
                      <td>
                        {{__('settings.add_new_type')}}
                      </td>
                      <td>
                          <input type="text" name="type_name" class="form-control" placeholder=" {{__('settings.type_here_the_new_type')}} ">
                      </td>
                      <td>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif --}}
      <button type="submit" class="btn btn-success"> {{__('buttons.confirm')}} </button>
      </form>



      </div>
    
    </div>
</div>
@endsection