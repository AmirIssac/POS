@extends('layouts.withScrollBar')
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
.price{
  font-size: 16px;
}
.button{
  float: left;
}
.retrieved{
  background-color: #adadad;
}
.retrieved-td{
  color: #f14000;
  font-weight: bold
}
@media print{
 /* body, html, #myform { 
          height: 100%;
      }*/
      
  *{
    /*margin: 0;*/
    font-size: 32px;
    font-weight: bold;
  }
  .card-title{
    font-weight: bold;
    color: black !important;
  }
  #pagination,.button{
    visibility: hidden;
  }
  #back{
    display: none;
  }
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
        <?php $total_sum_invoices = 0 ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">                          {{__('reports.current_day')}} 
                <span class="button"><button onclick="window.print();" class="btn btn-danger"> {{__('buttons.print')}} </button> </span>
              </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                @if(request()->is('print/purchase/current/daily/report/details/*') || request()->is('en/print/purchase/current/daily/report/details/*'))
                <button id="back" onclick="history.back()" class="btn btn-warning">رجوع</button>
                @endif
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                  </thead>
                  <tbody>
                    <tr class="price">
                      @foreach($purchases as $purchase)
                      @if($purchase->status != 'retrieved' && $purchase->dailyReports()->count()==0)
                      <?php $total_sum_invoices += $purchase->total_price ?>
                      @endif
                      @endforeach
                      <td>
                       {{-- {{__('reports.total_balance')}} &nbsp;&nbsp;{{$report->cash_balance+($report->cash_plus-$report->cash_shortage) + $report->card_balance+($report->card_plus-$report->card_shortage)}} --}}
                       {{__('purchases.purchases')}} &nbsp;&nbsp; {{$total_sum_invoices}}
                      </td>
                    </tr>
                    
                    
                    <tr class="price">
                     {{--  <td>
                       {{__('reports.sum_invoices')}} &nbsp;&nbsp;{{$total_sum_invoices}}
                      </td> --}}
                    </tr>
                    
                  </tbody>
                </table>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('sales.invoice_code')}}   
                    </th>
                    <th>
                      {{__('sales.invoice_status')}}    
                     </th>
                     <th>
                      {{__('sales.sales_employee')}}    
                      </th>
                     
                      <th>
                        {{__('purchases.payment_proccess')}}     
                        </th>
                        <th>
                            {{__('purchases.supplier')}}    
                          </th>
                   <th>
                    {{__('sales.total_price')}}   
                    </th>
                  </thead>
                  <tbody>
                      @foreach($purchases as $purchase)
                      @if($purchase->dailyReports()->count()==0)

                      @if($purchase->status == 'retrieved')
                      <tr class="retrieved">
                      @else
                      <tr>
                      @endif
                      <td>
                          {{$purchase->code}}
                      </td>

                        @if($purchase->status=='done')
                        <td>
                            {{__('purchases.done')}} 
                        </td>
                        @elseif($purchase->status=="retrieved")
                        <td>
                            {{__('purchases.retrieve_inv')}}
                        </td>
                       
                        @endif
                      <td>
                        {{$purchase->user->name}}
                      </td>
                     <td>
                         {{$purchase->payment}}
                     </td>
                     <td>
                         {{$purchase->supplier->name}}
                     </td>
                     <td>
                         {{$purchase->total_price}}
                     </td>
                    </tr>
                    @endif
                    @endforeach

                    <tr class="price">
                      <td class="button">
                        <button onclick="window.print();" class="btn btn-danger"> {{__('buttons.print')}} </button>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title">    {{__('reports.previous_inv_edited_today')}} 
            </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    {{__('sales.invoice_code')}}   
                  </th>
                  <th>
                    {{__('sales.invoice_status')}}    
                   </th>
                   <th>
                    {{__('sales.sales_employee')}}    
                    </th>
                    <th>
                        {{__('purchases.payment_proccess')}}    
                        </th>
                        <th>
                            {{__('purchases.supplier')}}    
                          </th>
                   <th>
                    {{__('sales.total_price')}}   
                    </th>
                </thead>
                <tbody>
                  @foreach($purchases as $purchase)
                      @if($purchase->dailyReports()->count()>0)

                      @if($purchase->status == 'retrieved')
                      <tr class="retrieved">
                      @else
                      <tr>
                      @endif
                      <td>
                          {{$purchase->code}}
                      </td>

                        @if($purchase->status=='done')
                        <td>
                            {{__('purchases.done')}} 
                        </td>
                        @elseif($purchase->status=="retrieved")
                        <td>
                            {{__('purchases.retrieve_inv')}}
                        </td>
                        
                        @endif
                      <td>
                        {{$purchase->user->name}}
                      </td>
                      
                      <td>
                        {{$purchase->payment}}
                    </td>
                    <td>
                        {{$purchase->supplier->name}}
                    </td>
                    <td>
                        {{$purchase->total_price}}
                    </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
</div>
@if(request()->is('print/purchase/current/daily/report/details/*') || request()->is('en/print/purchase/current/daily/report/details/*'))
@section('scripts')
<script>
  window.onload = (event) => {
    window.print();
  };
  </script>
@endsection
@endif
@endsection