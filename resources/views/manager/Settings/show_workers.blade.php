@extends('layouts.main')

@section('body')
<div class="main-panel">

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">  {{__('settings.employees_in')}}  {{$repository->name}}</h4>
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
                      {{__('settings.customize')}} 
                     </th>
                  </thead>
                  <tbody>
                    @foreach($workers as $worker)
                    <tr>
                     <td>{{$worker->name}}</td>
                     <td>{{$worker->email}}</td>
                     <td>{{$worker->phone}}</td>
                     <td>
                         <a style="color: white" href="{{route('show.worker.permissions',$worker->id)}}" role="button" class="btn btn-info"> {{__('buttons.edit')}} </a>
                     </td>
                    </tr>
                    @endforeach
                    
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