@extends('layouts.main')
@section('body')
<div class="main-panel">
   
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title float-right">كل المخازن</h4>
                </div>
                 <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          ID 
                        </th>
                        <th>
                          اسم المخزن
                        </th>
                        <th>
                        مالك المخزن
                      </th>
                       </thead>
                         <tbody>
                         @if($repositories && $repositories->count()>0)
                         @foreach($repositories as $repository)
                         <tr>
                          <td>
                            {{$repository->id}}
                          </td>
                           <td>
                             {{$repository->name}}
                           </td>
                           <td>
                            {{$repository->owner()}}
                           </td>
                          </tr>
                         @endforeach
                         @else
                         <tr>
                           <td>
                            لا يوجد مخازن في النظام
                           </td>
                           <td>
                             لا يوجد
                           </td>
                         </tr>
                         @endif
                             <tr>
                            <td> مخزن جديد </td>
                            <td> <a style="color: white" href="{{route('repositories.create')}}" role="button" class="btn btn-primary"> إنشاء </a> </td>
                        </tr>
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