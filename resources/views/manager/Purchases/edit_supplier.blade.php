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
    @if (session('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('success') }}</strong>
    </div>
    @endif
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> تعديل بيانات المورد {{$supplier->name}}  </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <form action="{{route('update.supplier')}}" method="POST">
                    @csrf
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                        الاسم  
                      </th>
                      <th>
                          العنوان
                      </th>
                      <th>
                          رقم الجوال
                      </th>
                      <th>
                          رقم الحساب 
                      </th>
                  </thead>
                  <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="supplier_id" value="{{$supplier->id}}">
                            <input type="text" name="name" class="form-control" placeholder="اسم المورد" id="autofocus" value="{{$supplier->name}}"  required>
                        </td>
                        <td>
                          <input type="text" name="address" class="form-control" placeholder="عنوان المورد" value="{{$supplier->address}}" required>
                        </td>
                        <td>
                         <input type="text" name="phone"  class="form-control"  placeholder="رقم الجوال" value="{{$supplier->phone}}" required>
                        </td>
                        <td>
                            <input type="text" name="account_num"  class="form-control"  placeholder="رقم الحساب" value="{{$supplier->account_num}}" required>
                           </td>
                      </tr>                      
                  </tbody>
                </table>
                <button type="submit" class="btn btn-primary">تأكيد</button>

            </form>

              </div>
              </div>
            </div>
           
          </div>
        </div>
       

      </div>
     
    </div>
</div>
@endsection