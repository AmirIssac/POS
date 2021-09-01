@extends('layouts.main')
<style>
.green-dot{
  height: 15px;
  width: 15px;
  background-color: #92e930;
  border-radius: 50%;
  display: inline-block;
 }
 .red-dot{
  height: 15px;
  width: 15px;
  background-color: #e93030;
  border-radius: 50%;
  display: inline-block;
 }
 </style>
@section('body')
<div class="main-panel">

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <?php $user = Auth::user(); ?>
        @if($user->hasRole('مالك-مخزن'))
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-warning">
              <h4 class="card-title">  {{__('settings.owner')}}
                </h4>
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
                      {{__('settings.mobile')}} 
                     </th>
                     <th>
                      {{__('settings.info')}} 
                     </th>
                     <th>
                       {{__('reports.monthly_sales')}}
                     </th>
                     <th>
                       {{__('reports.status')}}
                     </th>
                  </thead>
                  <tbody>
                    @foreach($owners as $owner)
                    <tr>
                     <td>{{$owner->name}}</td>
                     <td>{{$owner->email}}</td>
                     <td>{{$owner->phone}}</td>
                     <td>
                      <a style="color: white" href="{{route('edit.worker.info',$owner->id)}}" role="button" class="btn btn-info"> {{__('buttons.edit')}} </a>
                     </td>
                     <td>
                      <a style="color: white" href="{{route('show.worker.sales',[$owner->id,$repository->id])}}" role="button" class="btn btn-info"> {{__('buttons.view')}} </a>
                     </td>
                     <td>
                     @if($owner->is_online)
                     <span class="green-dot"></span>&nbsp;{{__('reports.online')}}
                      @else
                      <span class="red-dot"></span>&nbsp;{{__('reports.offline')}}
                      ({{__('reports.last_logout')}} {{$owner->last_logout()}})
                      @endif
                     </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        @endif

        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">  {{__('settings.employees_in')}}
                @if(LaravelLocalization::getCurrentLocale() == 'ar')
                {{$repository->name}}
               @elseif(LaravelLocalization::getCurrentLocale() == 'en')
                {{$repository->name_en}}
                @else
                {{$repository->name}}
                @endif
                </h4>
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
                      {{__('settings.mobile')}} 
                     </th>
                     <th>
                      {{__('settings.info')}} 
                     </th>
                     <th>
                      {{__('settings.permissions')}} 
                     </th>
                     <th>
                       {{__('reports.monthly_sales')}}
                     </th>
                     <th>
                       {{__('reports.status')}}
                     </th>
                  </thead>
                  <tbody>
                    <?php $user = Auth::user(); ?>
                    @foreach($workers as $worker)
                    <tr>
                     <td>{{$worker->name}}</td>
                     <td>{{$worker->email}}</td>
                     <td>{{$worker->phone}}</td>
                     <td>
                      <a style="color: white" href="{{route('edit.worker.info',$worker->id)}}" role="button" class="btn btn-info"> {{__('buttons.edit')}} </a>
                    </td>
                    @if($user->email == $worker->email)
                    <td>
                      /
                    </td>
                     @else
                     <td>
                         <a style="color: white" href="{{route('show.worker.permissions',$worker->id)}}" role="button" class="btn btn-info"> {{__('settings.customize')}} </a>
                     </td>
                     @endif
                     <td>
                      <a style="color: white" href="{{route('show.worker.sales',[$worker->id,$repository->id])}}" role="button" class="btn btn-info"> {{__('buttons.view')}} </a>
                     </td>
                     <td>
                      @if($worker->is_online)
                      <span class="green-dot"></span>&nbsp;{{__('reports.online')}}
                      @else
                      <span class="red-dot"></span>&nbsp;{{__('reports.offline')}}
                      ({{__('reports.last_logout')}} {{$worker->last_logout()}})
                      @endif
                     </td>
                    </tr>
                    @endforeach
                    @can('اضافة موظف جديد')
                    <tr>
                      <td>
                      <a href="{{route('add.worker',$repository->id)}}" class="btn btn-success">{{__('settings.add_new_employee')}}</a>
                      </td>
                    </tr>
                    @endcan
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