@extends('layouts.main')
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
              <h4 style="float: right" class="card-title ">اضافة منصب جديد</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead style="float: right" class="text-primary">
                    <th>
                      اسم المنصب
                    </th>
                  </thead>
                  <tbody>
                      <form method="POST" action="{{route('role.add')}}">
                          @csrf
                      <tr>
                        <td>
                            <input type="text" name="role" class="form-control" placeholder="اكتب اسم المنصب هنا">
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