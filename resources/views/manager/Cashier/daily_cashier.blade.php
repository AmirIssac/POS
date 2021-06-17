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
                          <a class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" id="modalicon"> إغلاق الكاشير </a>
                          </td>
                          <!-- Modal for confirming -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">إغلاق الكاشير</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        هل أنت متأكد أنك تريد إغلاق الكاشير ؟
      </div>
      <div class="modal-footer">
        <a class="btn btn-danger" data-dismiss="modal">تراجع</a>
        <button type="submit" class="btn btn-primary">تأكيد</button>
      </div>
    </div>
  </div>
</div>
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