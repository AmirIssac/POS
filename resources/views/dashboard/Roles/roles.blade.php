@extends('layouts.main')

@section('body')
<div class="main-panel">

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title float-right">المناصب</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      المنصب
                    </th>
                    <th>
                      تخصيص صلاحياته
                    </th>
                  </thead>
                  <tbody>
                    @foreach($roles as $role)
                    <tr>
                     <td>{{$role->name}}</td>
                     <td>
                         <a style="color: white" href="{{route('edit.role.permissions',$role->id)}}" role="button" class="btn btn-info"> تعديل </a>
                     </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td> منصب جديد </td>
                        <td> <a style="color: white" href="{{route('role.add.form')}}" role="button" class="btn btn-primary"> إنشاء </a> </td>
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