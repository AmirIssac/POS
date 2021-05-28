@extends('layouts.main')

@section('body')
<div class="main-panel">

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title float-right"> الموظفين في متجر {{$repository->name}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      الاسم
                    </th>
                    <th>
                       الايميل
                    </th>
                    <th>
                        رقم الجوال
                     </th>
                     <th>
                        تخصيص 
                     </th>
                  </thead>
                  <tbody>
                    @foreach($workers as $worker)
                    <tr>
                     <td>{{$worker->name}}</td>
                     <td>{{$worker->email}}</td>
                     <td>{{$worker->phone}}</td>
                     <td>
                         <a style="color: white" href="{{route('show.worker.permissions',$worker->id)}}" role="button" class="btn btn-info"> تعديل </a>
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