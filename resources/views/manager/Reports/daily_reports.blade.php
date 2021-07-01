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
  font-size: 22px;
}
.button{
  float: left;
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
              <h4 class="card-title">  {{__('reports.daily_report')}} {{$report->created_at->format('d/m/Y')}}<span class="button"><button onclick="window.print();" class="btn btn-danger"> {{__('buttons.print')}} </button> </span>
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
                      {{__('sales.cash')}}    
                      </th>
                      <th>
                        {{__('sales.card')}}    
                        </th>
                        <th>
                          STC-pay    
                          </th>
                     <th>
                      {{__('sales.total_price')}}   
                      </th>
                  </thead>
                  <tbody>
                    <?php $total_sum_invoices = 0 ?>
                      @foreach($report->invoices as $invoice)
                    <tr>
                      <td>
                          {{$invoice->code}}
                      </td>

                        @if($invoice->status=='delivered')
                        <td>
                          {{__('sales.del_badge')}} 
                        </td>
                        @elseif($invoice->status=="pending")
                        <td>
                          {{__('sales.hang_badge')}}
                        </td>
                        @else
                        <td>
                          {{__('sales.retrieved_badge')}}
                        </td>
                        @endif
                      <td>
                        {{$invoice->user->name}}
                      </td>
                      <td>
                        {{$invoice->cash_amount}}
                      </td>
                      <td>
                        {{$invoice->card_amount}}
                      </td>
                      <td>
                        {{$invoice->stc_amount}}
                      </td>
                      <td>
                        {{$invoice->total_price}}
                      </td>
                    </tr>
                    <?php $total_sum_invoices += $invoice->total_price ?>
                    @endforeach
                    <tr class="price">
                      <td>
                        {{__('reports.cashier')}}&nbsp;{{$report->cash_balance+($report->cash_plus-$report->cash_shortage)}}
                      </td>
                      <td>
                        {{__('sales.card')}}&nbsp;{{$report->card_balance+($report->card_plus-$report->card_shortage)}}
                      </td>
                      <td>
                        STC-pay&nbsp;{{$report->stc_balance+($report->stc_plus-$report->stc_shortage)}}
                      </td>
                    </tr>
                    <tr class="price">
                      <td>
                        {{__('reports.decrease_amount_in_cashier')}}   &nbsp;{{$report->cash_shortage}}
                      </td>
                      <td>
                        {{__('reports.decrease_amount_in_card')}} &nbsp;{{$report->card_shortage}}
                      </td>
                      <td>
                        {{__('reports.decrease_amount_in_stc')}} &nbsp;{{$report->stc_shortage}}
                      </td>
                    </tr>
                    <tr class="price">
                      <td>
                        {{__('reports.increase_amount_in_cashier')}}   &nbsp;{{$report->cash_plus}} 
                      </td>
                      <td>
                        {{__('reports.increase_amount_in_card')}} &nbsp;{{$report->card_plus}} 
                      </td>
                      <td>
                        {{__('reports.increase_amount_in_stc')}} &nbsp;{{$report->stc_plus}} 
                      </td>
                    </tr>
                    <tr class="price">
                     {{--  <td>
                       {{__('reports.sum_invoices')}} &nbsp;&nbsp;{{$total_sum_invoices}}
                      </td> --}}
                    </tr>
                    <tr class="price">
                      <td>
                        {{__('reports.total_balance')}} &nbsp;&nbsp;{{$report->cash_balance+($report->cash_plus-$report->cash_shortage) + $report->card_balance+($report->card_plus-$report->card_shortage)}}
                      </td>
                    </tr>
                    <tr class="price">
                      <td>
                        {{__('reports.close_employee')}}  &nbsp;  : &nbsp;{{$report->user->name}}
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td class="button">
                        <button onclick="window.print();" class="btn btn-danger"> {{__('buttons.print')}} </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div id="pagination">
                {{ $reports->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      @endforeach
    </div>
</div>
@endsection