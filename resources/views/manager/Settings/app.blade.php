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
textarea{
  border:2px solid #9229ac;
  border-radius: 10px;
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
      
      <div class="row">
        <form action="{{route('submit.settings.app',$repository->id)}}"  method="post" enctype="multipart/form-data">
          @csrf
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
                        <button type="submit" class="btn btn-success"> {{__('buttons.confirm')}} </button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      @if($repository->logo)
                      <img style="border-radius: 50%;" src="{{asset('public/storage/'.$repository->logo)}}" width="100px;" height="100px">
                      @else
                        {{__('settings.no_logo_please_upload_one')}}
                      @endif
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </form>

      <form action="{{route('general.settings',$repository->id)}}"  method="post">
        @csrf
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">{{__('settings.general_settings')}}</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    {{__('settings.store_name')}}
                 </th>
                 <th>
                  {{__('settings.address')}} 
               </th>
                  <th>
                    {{__('settings.close_time')}}
                   <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title="{{__('settings.note')}}" data-content="{{__('settings.note_content')}}">live_help</i>
                  </th>
                  <th>
                     {{__('settings.repo_note')}} <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title="{{__('settings.appear_in_invoice')}}">live_help</i>

                 </th>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <input type="text" name="repo_name" value="{{$repository->name}}" class="form-control">
                    </td>
                    <td>
                      <input type="text" name="address" value="{{$repository->address}}" class="form-control">
                  </td>
                    <td>
                      <input type="time" name="close_time" value="{{$repository->close_time}}" class="form-control">
                  </td>
                  <td>
                    <textarea rows="5" cols="60" name="note">
                      {{$repository->note}}
                    </textarea>
                    {{--<input type="text" name="note" value="{{$repository->note}}" class="form-control">--}}
                </td>
                    <td>
                      <button type="submit" class="btn btn-danger"> {{__('buttons.confirm')}} </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </form>

      </div>



      </div>
    
    </div>
</div>
@endsection
@section('scripts')
<script>
  window.onload=function(){
    $(function () {
  $('[data-toggle="popover"]').popover()
  });
  };
  </script>
@endsection