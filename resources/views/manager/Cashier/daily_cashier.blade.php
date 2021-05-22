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
 <form action="{{route('submit.cashier',$repository->id)}}"  method="post">
     @csrf
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">الإغلاق اليومي للكاشير</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      الواجب توافره في الدرج   <span class="badge badge-success">{{$repository->cash_balance}}</span>  
                      <input type="hidden" name="cash_balance" value="{{$repository->cash_balance}}">
                    </th>
                    <th>
                      الواجب توافره في البطاقة <span class="badge badge-success">{{$repository->card_balance}}</span>
                      <input type="hidden" name="card_balance" value="{{$repository->card_balance}}">  
                    </th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                          كمية النقص في الدرج
                          <input type="number" name="cashNeg"  class="form-control" placeholder="كمية النقص في الدرج في حال وجود نقص">
                      </td>
                      <td>
                          كمية النقص في البطاقة
                          <input type="number" name="cardNeg"  class="form-control" placeholder="كمية النقص في البطاقة في حال وجود نقص">
                      </td>
                    </tr>
                    <tr>
                        <td>
                            كمية الزيادة في الدرج
                            <input type="number" name="cashPos"  class="form-control" placeholder="كمية الزيادة في الدرج في حال وجود زيادة">
                        </td>
                        <td>
                            كمية الزيادة في البطاقة
                            <input type="number" name="cardPos"  class="form-control" placeholder="كمية الزيادة في البطاقة في حال وجود زيادة">
                        </td>
                      </tr>
                      <tr>
                          <td>
                          <button type="submit" class="btn btn-danger"> إغلاق الكاشير </button>
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