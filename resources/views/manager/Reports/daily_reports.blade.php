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
    <div class="container-fluid">
        @foreach($reports as $report)
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> تقرير يومي {{$report->created_at->format('d/m/Y')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                     رقم الفاتورة  
                    </th>
                    <th>
                     حالة الفاتورة   
                     </th>
                     <th>
                        المبلغ   
                      </th>
                  </thead>
                  <tbody>
                      @foreach($report->invoices as $invoice)
                    <tr>
                      <td>
                          {{$invoice->code}}
                      </td>
                      <td>
                        @if($invoice->status=='delivered')
                        <span class="badge badge-success"> تم التسليم </span>
                        @else
                        <span class="badge badge-warning"> معلقة </span>
                        @endif
                      </td>
                      <td>
                        {{$invoice->total_price}}
                      </td>
                    </tr>
                    @endforeach
                    <tr>
                      <td>
                        الدرج&nbsp;<span class="badge badge-info">{{$report->cash_balance+($report->cash_plus-$report->cash_shortage)}}</span>
                      </td>
                      <td>
                        البطاقة&nbsp;<span class="badge badge-info">{{$report->card_balance+($report->card_plus-$report->card_shortage)}}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        مقدار النقص بالدرج &nbsp;<span class="badge badge-danger">{{$report->cash_shortage}}</span>
                      </td>
                      <td>
                        مقدار النقص بالبطاقة &nbsp;<span class="badge badge-danger">{{$report->card_shortage}}</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        مقدار الزيادة بالدرج &nbsp;<span class="badge badge-success">{{$report->cash_plus}} </span>
                      </td>
                      <td>
                        مقدار الزيادة بالبطاقة &nbsp;<span class="badge badge-success">{{$report->card_plus}} </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       موظف الإغلاق  &nbsp;  : &nbsp;{{$report->user->name}}
                      </td>
                    </tr>
                  </tbody>
                </table>
                {{ $reports->links() }}
              </div>
            </div>
          </div>
        </div>
        
      </div>
      @endforeach
    </div>
</div>
@endsection