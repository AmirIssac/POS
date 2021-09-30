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
        <?php $total_sum_invoices = 0 ;
              $total_sum_purchases = 0 ;
         ?>

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
                @if(request()->is('print/current/daily/report/details/*') || request()->is('en/print/current/daily/report/details/*'))
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
                      @foreach($invoices as $invoice)
                      @if($invoice->status != 'retrieved' && $invoice->dailyReports()->count()==0)
                      <?php $total_sum_invoices += $invoice->total_price ?>
                      @endif
                      @endforeach

                      @foreach($purchases as $purchase)
                            @if($purchase->status == 'done' && $purchase->dailyReports()->count()==0)
                            <?php $total_sum_purchases += $purchase->total_price; ?>
                            @endif
                      @endforeach
                      <td>
                       {{-- {{__('reports.total_balance')}} &nbsp;&nbsp;{{$report->cash_balance+($report->cash_plus-$report->cash_shortage) + $report->card_balance+($report->card_plus-$report->card_shortage)}} --}}
                       {{__('menu.sales')}} &nbsp;&nbsp; {{$total_sum_invoices}}
                      </td>
                      <td>
                        {{__('purchases.purchases')}} {{$total_sum_purchases}}
                      </td>
                    </tr>
                    
                    <tr>
                      <?php
                            $today_invoices_count = 0 ;
                            $prev_invoices_count = 0 ;
                            $delivered = 0 ;
                            $pending = 0 ;
                            $retrieved = 0 ;
                            $deleted = 0 ;
                            $pending_money = 0 ;
                            $gained_money = 0 ;
                            $gained_money_for_today_sales = 0 ;
                            ?>
                      @foreach($invoices as $invoice)
                             @if($invoice->dailyReports()->count()==0)
                              <?php $today_invoices_count+=1; ?>
                              @if($invoice->status == 'delivered')
                              <?php $delivered+=1;
                                   /* $gained_money+=$invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount */
                               ?>
                            @elseif($invoice->status == 'pending')
                              <?php $pending+=1;
                                    $pending_money+=$invoice->total_price - ($invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount);
                                  /*  $gained_money+=$invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount */
                              ?>
                            @elseif($invoice->status == 'retrieved')
                              <?php $retrieved+=1; ?>
                            @elseif($invoice->status == 'deleted')
                              <?php $deleted+=1; ?>
                            @endif
                            @endif
                              
                            @if($invoice->dailyReports()->count()>0)
                            <?php $prev_invoices_count+=1; ?>
                        @endif
                      @endforeach

                      {{-- حساب الاموال المحصلة سواء فواتير اليوم او الفواتير سابقة تم استكمالها اليوم --}}
                      @foreach($invoices as $invoice)
                      @if($invoice->dailyReports()->count()==0) {{-- today --}}
                        @if($invoice->status == 'delivered' || $invoice->status == 'pending')
                        <?php $gained_money += $invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount;
                              $gained_money_for_today_sales +=  $invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount;
                        ?>
                        @endif
                      @elseif($invoice->dailyReports()->count()>0) {{-- prvious invoices --}}
                        @if($invoice->status == 'delivered')
                          <?php $gained_money+= ($invoice->cash_amount - $invoice->invoiceProcesses[0]->cash_amount) + ($invoice->card_amount - $invoice->invoiceProcesses[0]->card_amount) + ($invoice->stc_amount - $invoice->invoiceProcesses[0]->stc_amount) ?>
                        @endif
                      @endif
                      @endforeach
                      <td style="font-weight: bold">{{__('reports.number_of_invoices')}}  {{$today_invoices_count}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <tr>
                      <td>{{__('dashboard.delivered')}} {{$delivered}}</td>
                      <td>{{__('dashboard.hanging')}} {{$pending}}</td>
                      <td>{{__('dashboard.retrieved')}} {{$retrieved}}</td>
                      <td>{{__('reports.deleted')}} {{$deleted}}</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td> {{__('reports.pending_money_thisday_sales')}} {{$pending_money}}</td>
                      <td> {{__('reports.total_gained_money')}} {{$gained_money}}</td>
                      <td>    {{__('reports.thisday_gained_money_sales')}}  {{$gained_money_for_today_sales}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
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
                      @foreach($invoices as $invoice)
                      @if($invoice->dailyReports()->count()==0)

                      @if($invoice->status == 'retrieved' || $invoice->status == 'deleted')
                      <tr class="retrieved">
                      @else
                      <tr>
                      @endif
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
                        @elseif($invoice->status=="retrieved")
                        <td>
                          {{__('sales.retrieved_badge')}}
                        </td>
                        @elseif($invoice->status=="deleted")
                        <td>
                          {{__('reports.deleted')}}
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
                      @if($invoice->status == 'retrieved' || $invoice->status == 'deleted')
                      <td class="retrieved-td">
                        {{$invoice->total_price}}-
                      </td>
                      @else
                      <td>
                        {{$invoice->total_price}}
                      </td>
                      @endif
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
            <td style="font-weight: bold;">{{__('reports.number_of_invoices')}}  {{$prev_invoices_count}}</td>
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
                  @foreach($invoices as $invoice)
                      @if($invoice->dailyReports()->count()>0)

                      @if($invoice->status == 'retrieved' || $invoice->status == 'deleted')
                      <tr class="retrieved">
                      @else
                      <tr>
                      @endif
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
                        @elseif($invoice->status=="retrieved")
                        <td>
                          {{__('sales.retrieved_badge')}}
                        </td>
                        @elseif($invoice->status=="deleted")
                        <td>
                          {{__('reports.deleted')}}
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
                      @if($invoice->status == 'retrieved' || $invoice->status == 'deleted')
                      <td class="retrieved-td">
                        {{$invoice->total_price}}-
                      </td>
                      @else
                      <td>
                        {{$invoice->total_price}}
                      </td>
                      @endif
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
@if(request()->is('print/current/daily/report/details/*') || request()->is('en/print/current/daily/report/details/*'))
@section('scripts')
<script>
  window.onload = (event) => {
    window.print();
  };
  </script>
@endsection
@endif
@endsection