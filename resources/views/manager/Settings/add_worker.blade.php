@extends('layouts.main')
@section('links')
<style>
  .on{
    border-radius:50%;
    background-color: #44bb54;
    width: 25px;
    height:25px;
  }
  .off{
    border-radius:50%;
    background-color: #e41b35;
    width: 25px;
    height:25px;
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
    <div class="container-fluid">
        <form action="{{route('store.worker',$repository->id)}}" method="POST">
            @csrf
      <div class="row">
        
        <div class="col-md-12">
            
               
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title">{{__('settings.emp_data')}}</h4>
                        </div>
                         <div class="card-body">
                          <div class="table-responsive">
                            <table class="table">
                              <thead class=" text-primary">
                                <th>
                                  {{__('settings.name')}}  
                                </th>
                              <th>
                                {{__('settings.email')}} 
                              </th>
                              <th>
                                {{__('settings.password')}} 
                              </th>
                              <th>
                                {{__('settings.mobile')}}  
                              </th>
                               </thead>
                                 <tbody>

                                 <tr>
                                   <td>
                                       <input type="text" name="name" class="form-control" placeholder="{{__('settings.name')}} " required>
                                   </td>
                                   <td>
                                    <input type="email" name="email" class="form-control" placeholder="{{__('settings.email')}}" required>
                                  </td>
                                  <td>
                                    <input type="password" name="password" class="form-control" placeholder="{{__('settings.password')}}" required>
                                  </td>
                                  <td>
                                    <input type="text" name="phone" class="form-control" placeholder="{{__('settings.mobile')}}" required>
                                     </td>
                                  </tr>
                                      
                                     
                              </tbody>
                            </table>
                            
                              </div>
                            </div>
                          </div>
                </div>
              </div>

              @foreach($categories as $category)
              <div class="row">
        
                <div class="col-md-12">
                    
                          <div class="card">
                            <div class="card-header card-header-primary">
                              <h4 class="card-title">{{$category->name}}</h4>
                                </div>
                                 <div class="card-body">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <thead class=" text-primary">
                                        <th>
                                          الصلاحية  
                                        </th>
                                      <th>
                                        منح\سحب 
                                      </th>
                                      
                                       </thead>
                                         <tbody>
                                            @foreach($category->permissions as $permission)
                                            @if($permissionsOwner->contains('id',$permission->id))  {{-- display the permissions the just owner has --}}
                                            <tr>
                                                <td>
                                                    {{$permission->name}}
                                                </td>
                                                <td>
                                                    <input style="visibility: hidden" type="checkbox" class="btn-check" id="btn-check-{{$permission->id}}" value="{{$permission->name}}" name="permissions[]" autocomplete="off">
                                                    <label class="off" for="btn-check-{{$permission->id}}"></label>
                                                </td>
                                              </tr>
                                              @endif
                                              @endforeach
                                             
                                      </tbody>
                                    </table>
                                    
                                      </div>
                                    </div>
                                  </div>
                        </div>
                      </div>
              @endforeach
              <button class="btn btn-success"> {{__('buttons.save')}} </button>

            </form>

            </div>
        </div>
@endsection
@section('scripts')
<script>
   $(document).ready(function(){
        $('input[type=checkbox]').click(function(){
            if($(this).is(":checked")){
              //$(this).next().html("ON");
              $(this).next().removeClass( "off" ).addClass( "on" );
            }
            else if($(this).is(":not(:checked)")){
             //$(this).next().html("OFF");
              $(this).next().removeClass( "on" ).addClass( "off" );
            }
        });
    });
</script>
@endsection
