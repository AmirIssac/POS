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
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>	
                  <strong>{{ $message }}</strong>
          </div>
          @endif
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 style="float: right" class="card-title ">تخصيص صلاحيات &nbsp;{{$role->name}} </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class="text-primary">
                    <th>
                      ID 
                    </th>
                    <th>
                      صلاحية الوصول
                    </th>
                    <th>
                        منح \ سحب
                    </th>
                  </thead>
                  <tbody>
                      <form method="POST" action="{{route('make.edit.role.permissions',$role->id)}}">
                          @csrf
                          @if($permissions && $permissions->count()>0)
                          @foreach($permissions as $permission)
                      <tr>
                        <td>
                          {{$permission->id}}
                      </td>
                        <td>
                            {{$permission->name}}
                        </td>
                        <td>
                            @if($role_permissions->contains('id',$permission->id))  {{-- check if permission taken so checked the button --}}
                            <input style="visibility: hidden" type="checkbox" class="btn-check" id="btn-check-{{$permission->id}}" value="{{$permission->name}}" name="permissions[]" checked autocomplete="off">
                            <label class="on" for="btn-check-{{$permission->id}}"></label>
                            @else
                            <input style="visibility: hidden" type="checkbox" class="btn-check" id="btn-check-{{$permission->id}}" value="{{$permission->name}}" name="permissions[]" autocomplete="off">
                            <label class="off" for="btn-check-{{$permission->id}}"></label>
                            @endif
                        </td>
                      </tr>
                      @endforeach
                      <tr>
                        <td></td>
                        <td></td>
                        <td><button type="submit" class="btn btn-primary">حفظ</button></td>
                      </tr>
                      </form>
                      @else
                      <tr>
                          <td>
                              لا يوجد صلاحيات وصول في النظام
                          </td>
                      </tr>
                      @endif
                      </form>
                  </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
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