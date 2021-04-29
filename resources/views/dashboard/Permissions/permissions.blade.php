@extends('layouts.main')
@section('links')
<meta charset="utf-8" />
<link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/apple-icon.png')}}">
<link rel="icon" type="image/png" href=".{{asset('img/favicon.png')}}">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>
  Material Dashboard by Creative Tim
</title>
<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<!-- CSS Files -->
<link href="{{asset('css/material-dashboard.css?v=2.1.2')}}" rel="stylesheet" />
<!-- CSS Just for demo purpose, don't include it in your project -->
<link href="{{asset('demo/demo.css')}}" rel="stylesheet" />
@endsection
@section('body')
<div class="main-panel">
   
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title float-right">صلاحيات الوصول</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      الصلاحية
                    </th>
                    <th>
                        المناصب التي تملكها
                    </th>
                  </thead>
                  <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                     <td>{{$permission->name}}</td>
                     <?php $roles = $permission->roles ?>
                     <td>
                         @if($roles && $roles->count()>0)
                         @foreach($roles as $role)
                         {{$role->name}} &nbsp;
                         @endforeach
                         @else
                         لا يوجد مناصب لهذه الصلاحية
                         @endif
                     </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td> صلاحية جديدة </td>
                        <td> <a style="color: white" href="{{route('permission.add.form')}}" role="button" class="btn btn-primary"> إنشاء </a> </td>
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