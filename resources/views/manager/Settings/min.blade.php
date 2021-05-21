@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
   /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
@endsection
@section('body')
<div class="main-panel">
   
<div class="content">
    @if (session('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('success') }}</strong>
    </div>
    @endif
 <form action="{{route('settings.min',$repository->id)}}"  method="post">
     @csrf
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">تحديد الحد الأنى للدفع في الفواتير المعلقة</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                     الحد الأدنى <span class="badge badge-success">{{$repository->min_payment}}</span>  
                    </th>
                    <th>
                      تأكيد  
                    </th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                          <input type="number" name="min" min="1" max="100" class="form-control" placeholder="  اكتب هنا النسبة المئوية مثال 30 تعني 30% ">
                      </td>
                      <td>
                          <button type="submit" class="btn btn-success"> تأكيد </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </form>
    </div>
</div>
@endsection