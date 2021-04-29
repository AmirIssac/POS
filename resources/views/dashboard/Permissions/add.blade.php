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
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
        @endif
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 style="float: right" class="card-title ">اضافة صلاحية وصول جديدة</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead style="float: right" class="text-primary">
                    <th>
                      اسم الصلاحية
                    </th>
                  </thead>
                  <tbody>
                      <form method="POST" action="{{route('permission.add')}}">
                          @csrf
                      <tr>
                        <td>
                            <input type="text" name="permission" class="form-control" placeholder="اكتب اسم الصلاحية هنا">
                        </td>
                        <td>
                            <button  type="submit" class="btn btn-primary"> إضافة </button>
                        </td>
                      </tr>
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