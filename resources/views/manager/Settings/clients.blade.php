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
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> العملاء </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      الاسم  
                    </th>
                    <th>
                      الجوال  
                    </th>
                    <th>
                      النقاط  
                    </th>
                    <th>
                      تعديل  
                    </th>
                  </thead>
                  <tbody>
                    @if($customers->count()>0)
                    @foreach($customers as $customer)
                      <tr>
                          <td>
                              {{$customer->name}}
                          </td>
                          <td>
                            {{$customer->phone}}
                          </td>
                          <td>
                            {{$customer->points}}
                          </td>
                          <td>
                            <a href="{{route('edit.client',$customer->id)}}" class="btn btn-info"> تعديل </a>
                          </td>
                      </tr>
                      @endforeach
                      @else
                      <span id="warning" class="badge badge-warning">
                        لا يوجد عملاء بعد 
                      </span>
                      @endif
                  </tbody>
                </table>

              </div>
              </div>
            </div>
           
          </div>
        </div>
        {{ $customers->links() }}

      </div>
     
    </div>
</div>
@endsection