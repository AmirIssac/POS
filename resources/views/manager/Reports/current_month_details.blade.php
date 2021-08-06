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
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">   {{__('reports.current_month')}} <span class="button"><button onclick="window.print();" class="btn btn-danger"> {{__('buttons.print')}} </button> </span>
              </h4>
              <h4>
                  {{$invoices->count()}}  {{__('reports.invoice')}}
              </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                @if(request()->is('print/current/monthly/report/details/*') || request()->is('en/print/current/monthly/report/details/*'))
                <button id="back" onclick="history.back()" class="btn btn-warning">رجوع</button>
                @endif
                <table class="table">
                  
                  <thead class=" text-primary">
                    <th>
                      {{__('reports.cash_income')}}   
                    </th>
                    <th>
                      {{__('reports.card_income')}}    
                     </th>
                     <th>
                      {{__('reports.stc_income')}}    
                      </th>
                      <th>
                        {{__('reports.sales')}}    
                        </th>
                  </thead>
                      <tbody>
                      <tr>
                        <td>
                          {{$statistics->m_in_cash_balance}}
                        </td>
                        <td>
                            {{$statistics->m_in_card_balance}}
                        </td>
                        <td>
                            {{$statistics->m_in_stc_balance}}
                        </td>
                        <td>
                            <?php $total_sum_invoices = 0 ?>
                            @foreach($invoices as $invoice)
                            @if($invoice->status != 'retrieved')
                            <?php $total_sum_invoices += $invoice->total_price ?>
                            @endif
                            @endforeach
                            {{$total_sum_invoices}}
                        </td>
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
                      @if($invoice->status == 'retrieved')
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
                      @if($invoice->status == 'retrieved')
                      <td class="retrieved-td">
                        {{$invoice->total_price}}-
                      </td>
                      @else
                      <td>
                        {{$invoice->total_price}}
                      </td>
                      @endif
                    </tr>
                    @endforeach
                      <tr>
                      <td class="button">
                        <button onclick="window.print();" class="btn btn-danger"> {{__('buttons.print')}} </button>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
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
    </div>
</div>
@if(request()->is('print/current/monthly/report/details/*') || request()->is('en/print/current/monthly/report/details/*'))
@section('scripts')
<script>
  window.onload = (event) => {
    window.print();
  };
  </script>
@endsection
@endif
@endsection