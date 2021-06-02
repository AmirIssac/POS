@extends('layouts.main')
@section('links')
<style>
form i{
  float: left;
}
form i:hover{
  cursor: pointer;
}
</style>
@endsection
@section('body')
<div class="main-panel">
 
 <div class="content">
  @if (session('sellSuccess'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('sellSuccess') }}</strong>
  </div>
  @endif
  @if (session('fail'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('fail') }}</strong>
  </div>
  @endif
  <form method="GET" action="{{route('create.special.invoice',$repository->id)}}">
    @csrf
  <div  class="container-fluid">
    <div class="row">

           
      <div class="col-md-12">
        <div class="card">
           <div class="card-header card-header-primary">
            <h4 class="card-title ">معلومات الزبون</h4>
           </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="myTable" class="table">
                <thead class="text-primary">
                  <th>
                    الجوال (الزامي)  
                  </th>
                  <th>
                    الاسم (غير الزامي)  
                  </th>
                  <th>
                    البحث  
                  </th>
                </thead>
                <tbody>
               <tr>
                <td>
                    <input type="phone" id="phone" name="phone" placeholder="أدخل هنا جوال الزبون" class="form-control" required>
                  </td>
                 <td>
                   <input type="text" name="customer_name" class="form-control" placeholder="أدخل هنا اسم الزبون">
                 </td>
                <td>
                    <button type="submit" class="btn btn-primary">ابحث</button>
                </td>
               </tr>
         </tbody>
       </table>
   </div>
</div>
</div>
  </div>
</form>
@endsection
@section('scripts')
<script>
    window.onload=function(){
        $('#phone').focus();
    }
</script>
@endsection
