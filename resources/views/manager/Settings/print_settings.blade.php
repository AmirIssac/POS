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

    <form action="{{route('confirm.print.settings',$repository->id)}}"  method="post">
      @csrf
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">{{__('settings.print_settings')}}</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>
                  {{__('settings.proccess')}}
                </th>
                <th>
                {{--  {{__('settings.show_hide')}} --}}
                </th>
              </thead>
              <tbody>
                <tr>
                  <td>
                    {{__('settings.prescription')}}
                  </td>
                  <td>
                    @if($repository->setting->print_prescription == false)
                    <input type="checkbox" name="prescription" class="form-control">
                    @else
                    <input type="checkbox" name="prescription" class="form-control" checked>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>
                     {{__('settings.standard_printer')}}
                  </td>
                  <td>
                    @if($repository->setting->standard_printer == false)
                    <input type="radio" name="printer_type" value="standard" class="form-control">
                    @else
                    <input type="radio" name="printer_type" value="standard" class="form-control" checked>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>
                    {{__('settings.thermal_printer')}}
                  </td>
                  <td>
                    @if($repository->setting->thermal_printer == false)
                    <input type="radio" name="printer_type" value="thermal" class="form-control">
                    @else
                    <input type="radio" name="printer_type" value="thermal" class="form-control" checked>
                    @endif
                  </td>
                </tr>
                <tr>
                    <td>
                        {{__('settings.close_time')}}
                       <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title="{{__('settings.note')}}" data-content="{{__('settings.note_content')}}">live_help</i>
                    </td>
                    <td>
                        <input type="time" name="close_time" value="{{$repository->close_time}}" class="form-control" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        {{__('settings.repo_note')}} <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title="{{__('settings.appear_in_invoice')}}">live_help</i>
   
                    </td>
                    <td>
                        <textarea rows="5" cols="60" name="note">
                            {{$repository->note}}
                          </textarea>
                    </td>
                </tr>
               <tr>
                 <td>
                   <button class="btn btn-success">{{__('buttons.confirm')}}</button>
                 </td>
                 <td></td>
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