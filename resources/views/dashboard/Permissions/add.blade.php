@extends('layouts.main')
@section('body')
<div class="main-panel">
 
 <div class="content">
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
    <div class="container-fluid">
      <div class="row">
        <form method="POST" action="{{route('permission.store')}}">
            @csrf
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">اضافة صلاحية جديدة</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class="text-primary">
                    <th>
                      اسم الصلاحية  
                    </th>
                    <th>
                      القسم   
                    </th>
                  </thead>
                  <tbody>
                     
                      <tr>
                        <td>
                            <input type="text" name="permission" class="form-control" placeholder="اكتب اسم الصلاحية هنا">
                        </td>
                        <td>
                          <select name="cat" class="form-control">
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                            <button  type="submit" class="btn btn-primary"> إضافة </button>
                        </td>
                      </tr>
                     
                  </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
</form>
  </div>
</div>
</div>
@endsection
