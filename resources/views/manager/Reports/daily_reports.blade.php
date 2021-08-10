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
  .displaynone{
    display: none;
  }
  .eye:hover{
    cursor: pointer;
  }
  .active-a:hover{
    cursor: pointer;
  }
  .disabled-a:hover{
    cursor: default;
  }
  #current-month-tr{
    background-color: #93cb52;
    color: #2d3e4f;
    font-weight: bold;
  }
</style>
@endsection
@section('body')
<div class="main-panel">
  
<div class="content">
  
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            
              <div class="card-header card-header-primary">
                
              <h4 class="card-title"> </h4>
              <h4> {{__('reports.daily_reports')}} <span class="badge badge-success"></span></h4>
            
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">                    
                    <th>
                      {{__('reports.date')}}    
                  </th>
                  <th>
                    {{__('reports.sales')}}    
                </th>
                <th>
                  {{__('reports.actions')}}
              </th>
                <th>
                  {{__('purchases.purchases')}}    
              </th>
              <th>
                {{__('reports.actions')}}
            </th>
                  </thead>
                  <tbody>
                    <tr id="current-month-tr"> {{-- current month ((not making report in DB yet)) --}}
                      <td>
                        {{__('reports.current_day')}} 
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
                      <td>
                        <a style="color: #9229ac" href="{{route('view.current.daily.report.details',$repository->id)}}"> <i class="material-icons eye">
                          visibility
                        </i> </a>
                        
                        |
                        <a style="color: #9229ac" href="{{route('print.current.daily.report.details',$repository->id)}}"> <i class="material-icons eye">
                          print
                        </i> </a>
                      </td>
                      <td>
                        <?php $purchasesVal = 0 ?>
                          @foreach($purchases as $purchase)
                          @if($purchase->status == 'done')
                          <?php $purchasesVal += $purchase->total_price ?>
                          @endif
                          @endforeach
                          {{$purchasesVal}}
                      </td>
                      <td>
                        <a style="color: #9229ac" href="{{route('view.current.daily.purchase.report.details',$repository->id)}}"> <i class="material-icons eye">
                          visibility
                        </i> </a>
                        
                        |
                        <a style="color: #9229ac" href="{{route('print.purchase.current.daily.report.details',$repository->id)}}"> <i class="material-icons eye">
                          print
                        </i> </a>
                      </td>
                    </tr>
                    @foreach($reports as $report)
                    <tr>
                        <td>
                            {{$report->created_at->format('d/m/y')}}
                        </td>
                        <td>
                            <?php $total_sum_invoices = 0 ?>
                            @foreach($report->invoices as $invoice)
                            @if($invoice->status != 'retrieved')
                            @if($invoice->transform == 'no' || $invoice->created_at > $report->created_at)  {{-- we dont affect sales by invoices in the report but taked before in another report --}}
                            <?php $total_sum_invoices += $invoice->total_price ?>
                            @elseif($invoice->transform != 'no' && $invoice->dailyReports()->count()<2)
                            <?php $total_sum_invoices += $invoice->total_price ?>
                            @endif
                            @endif
                            @endforeach
                            {{$total_sum_invoices}}
                        </td>
                        <td>
                          <a style="color: #03a4ec" href="{{route('view.daily.report.details',$report->id)}}"> <i class="material-icons eye">
                                 visibility
                               </i> </a>
                               
                               |
                               <a style="color: #93cb52" href="{{route('print.daily.report.details',$report->id)}}"> <i class="material-icons eye">
                                 print
                               </i> </a>
                               
                           </td>
                        <td>
                          <?php $purchasesVal = 0 ?>
                            @foreach($report->purchases as $purchase)
                            @if($purchase->status == 'done')
                            @if($purchase->dailyReports()->count()==1)
                            <?php $purchasesVal += $purchase->total_price; ?>
                            @elseif($purchase->dailyReports()->count()>1)
                            <?php $rep = $purchase->dailyReports->first(); ?>
                            @if($report->id == $rep->id)
                            <?php $purchasesVal += $purchase->total_price; ?>
                            @endif
                            @endif
                            @endif
                            @endforeach
                            {{$purchasesVal}}
                        </td>
                        <td>
                          <a style="color: #03a4ec" href="{{route('view.daily.purchase.report.details',$report->id)}}"> <i class="material-icons eye">
                                 visibility
                               </i> </a>
                               
                               |
                               <a style="color: #93cb52" href="{{route('print.purchase.daily.report.details',$report->id)}}"> <i class="material-icons eye">
                                 print
                               </i> </a>
                               
                           </td>
                    </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
              </div>
            </div>
          </div>
        </div>
        {{ $reports->links() }}

      </div>
     
    </div>
</div>
@endsection

@section('scripts')
<script>
  $('.eye').on('click',function(){
    var id = $(this).attr('id');
    if($('#th'+id).hasClass('displaynone')){  // show
    $('#th'+id).removeClass('displaynone');
    $('#tb'+id).removeClass('displaynone');
    }
    else
    {  // hide
      $('#th'+id).addClass('displaynone');
      $('#tb'+id).addClass('displaynone');
    }
  });
</script>
@endsection