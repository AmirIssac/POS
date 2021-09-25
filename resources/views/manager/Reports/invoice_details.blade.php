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
  .delivered{
    background-color: #93cb52;
  }
  .pending{
    background-color: #f4c721;
  }
  .retrieved{
    background-color: #9b9ea0;
  }
  .deleted{
    background-color: #ff4454;
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
              <h4> {{__('sales.invoice_details')}} {{$invoice->created_at}}   <span class="badge badge-success">{{$invoice->code}}</span></h4>
              {{--<i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>--}}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                 {{-- <thead id="th{{$i}}" class="text-primary displaynone"> --}}
                    <th>
                      Barcode  
                    </th>
                    <th>
                      {{__('sales.name')}}    
                  </th>
                    <th>
                      {{__('sales.price')}}   
                    </th>
                    <th>
                      {{__('sales.quantity')}}  
                    </th> 
                  <th>
                    {{__('sales.delivered')}}   
                  </th>
                  </thead>
                  <tbody>
                    <?php $records = unserialize($invoice->details) ?>
                    @for($i=1;$i<count($records);$i++)
                    <tr>
                        <td>
                            {{$records[$i]['barcode']}}
                        </td>
                        <td>
                            {{$records[$i]['name_ar']}}
                        </td>
                        <td>
                            {{$records[$i]['price']}}
                        </td>
                        <td>
                            {{$records[$i]['quantity']}}
                        </td>
                        <td>
                            {{$records[$i]['delivered']}}
                        </td>
                    </tr>
                    @endfor
                    <tr style="font-weight: 900">
                        <td>
                          {{__('sales.total_price')}}
                        </td>
                        <td>
                          {{__('sales.cash')}}
                        </td>
                        <td>
                          {{__('sales.card')}}
                        </td>
                        <td>
                             stc-pay
                        </td>
                        <td>
                          {{__('sales.discount')}}
                        </td>
                        <td>
                          {{__('sales.invoice_status')}}  
                        </td>
                        <td>
                          {{__('sales.prescription')}}
                        </td>
                        <td>
                          {{__('reports.customer')}} 
                        </td>
                        <td>
                          {{__('sales.customer_mobile')}}  
                        </td>
                        <td>
                          {{__('sales.date')}}
                        </td>
                        <td>
                          {{__('sales.sales_employee')}}  
                        </td>
                        <td>
                          {{__('sales.note')}}  
                        </td>
                    </tr>
                    <?php $rec = unserialize($invoice->recipe) ?>
                    @if(isset($invoice_processes) && $invoice_processes->count()>0)  {{-- because mabye invoice will not has any old processes --}}
                    <?php $index = 0 ; ?>
                    @foreach($invoice_processes as $inv_process)
                    @if($inv_process->status == 'delivered')
                    <tr class="delivered">
                      @elseif($inv_process->status == 'pending')
                      <tr class="pending">
                        @elseif($inv_process->status == 'retrieved')
                        <tr class="retrieved">
                          @elseif($inv_process->status == 'deleted')
                          <tr class="deleted">
                            @endif
                      <td style="font-weight: bold">
                        @if($index == 0)
                        {{$invoice->total_price}}
                        @endif
                      </td>
                      <td>
                        @if($index == 0)
                        {{$inv_process->cash_amount}}
                        @else
                        <?php $cash = 0 ; ?>
                        @for($i=$index-1;$i>=0;$i--)
                        <?php $cash = $cash + $invoice_processes[$i]->cash_amount ?>  {{-- cash will contain the sum of all previous invoices from this current invoice_process --}}
                        @endfor
                        {{$inv_process->cash_amount - $cash}}
                        @endif
                      </td>
                      <td>
                        @if($index == 0)
                        {{$inv_process->card_amount}}
                        @else
                        <?php $card = 0 ; ?>
                        @for($i=$index-1;$i>=0;$i--)
                        <?php $card = $card + $invoice_processes[$i]->card_amount ?>  {{-- cash will contain the sum of all previous invoices from this current invoice_process --}}
                        @endfor
                        {{$inv_process->card_amount - $card}}
                        @endif
                      </td>
                      <td>
                        @if($index == 0)
                        {{$inv_process->stc_amount}}
                        @else
                        <?php $stc = 0 ; ?>
                        @for($i=$index-1;$i>=0;$i--)
                        <?php $stc = $stc + $invoice_processes[$i]->stc_amount ?>  {{-- cash will contain the sum of all previous invoices from this current invoice_process --}}
                        @endfor
                        {{$inv_process->stc_amount - $stc}}
                        @endif
                      </td>
                      <td>
                        {{$invoice->discount}}
                      </td>
                      <td>
                        @if($inv_process->status == 'delivered')
                        {{__('sales.del_badge')}} 
                        @elseif($inv_process->status == 'pending')
                        {{__('sales.hang_badge')}}
                        @elseif($inv_process->status == 'retrieved')
                        {{__('sales.retrieved_badge')}}
                        @elseif($inv_process->status == 'deleted')
                        {{__('reports.deleted')}}
                        @endif
                      </td>
                      <td>
                        <?php  
                        $message = '';
                  ?>
                  @if(isset($rec[0]) && is_array($rec[0]))  {{-- new version --}}
                  @if(count($rec)<=1) {{-- وصفة واحدة --}}
                  @foreach($rec as $single_rec)
                  @if(array_key_exists('name', $single_rec))
                  {{$single_rec['name']}}
                  @else
                  {{__('sales.basic_prescription')}}
                  @endif
                  @endforeach
                  @else  {{-- عدة وصفات --}}
                  {{__('reports.multiple')}}
                  @foreach($rec as $single_rec)
                  @if(array_key_exists('name', $single_rec))
                  <?php $message .= $single_rec['name']." / " ?>
                  @else
                  <?php $message .= __('sales.basic_prescription')." / " ?>
                  @endif
                  @endforeach
                  <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title="{{__('reports.multiple')}}" data-content=" {{$message}}">live_help</i>
                  @endif

                  @else  {{-- old version --}}
                  @if(array_key_exists('name', $rec))
                  {{$rec['name']}}
                  @else
                  {{__('sales.basic_prescription')}}
                  @endif
                  @endif
                       </td>
                       <td>
                        {{$invoice->customer->name}}
                       </td>
                       <td>
                        {{$invoice->phone}}
                       </td>
                       <td>
                        {{$inv_process->created_at}}
                       </td>
                       <td>
                        {{$inv_process->user->name}}
                       </td>
                       <td>
                         @if($inv_process->note)
                        {{$inv_process->note}}
                        @else
                        {{__('sales.none')}}
                        @endif
                       </td>
                    </tr>
                    <?php $index++ ?>
                    @endforeach 
                    {{-- latest version of invoice in invoices table --}}
                    @if($invoice->status == 'delivered') 
                    <tr class="delivered">
                      @elseif($invoice->status == 'pending')
                      <tr class="pending">
                        @elseif($invoice->status == 'retrieved')
                        <tr class="retrieved">
                          @elseif($invoice->status == 'deleted')
                          <tr class="deleted">
                            @endif  
                      <td>
                      </td>
                      <td>
                        {{$invoice->cash_amount - $invoice_processes[$invoice_processes->count()-1]->cash_amount}}
                      </td>
                      <td>
                        {{$invoice->card_amount - $invoice_processes[$invoice_processes->count()-1]->card_amount}}
                      </td>
                      <td>
                        {{$invoice->stc_amount - $invoice_processes[$invoice_processes->count()-1]->stc_amount}}
                      </td>
                        <td>
                          {{$invoice->discount}}
                        </td>
                      <td>
                        @if($invoice->status == 'delivered')
                        {{__('sales.del_badge')}} 
                        @elseif($invoice->status == 'pending')
                        {{__('sales.hang_badge')}}
                        @elseif($invoice->status == 'retrieved')
                        {{__('sales.retrieved_badge')}}
                        @elseif($invoice->status == 'deleted')
                        {{__('reports.deleted')}}
                        @endif
                      </td>
                      <td>
                        <?php 
                        $message = '';
                  ?>
                  @if(isset($rec[0]) && is_array($rec[0]))  {{-- new version --}}
                  @if(count($rec)<=1) {{-- وصفة واحدة --}}
                  @foreach($rec as $single_rec)
                  @if(array_key_exists('name', $single_rec))
                  {{$single_rec['name']}}
                  @else
                  {{__('sales.basic_prescription')}}
                  @endif
                  @endforeach
                  @else  {{-- عدة وصفات --}}
                  {{__('reports.multiple')}}
                  @foreach($rec as $single_rec)
                  @if(array_key_exists('name', $single_rec))
                  <?php $message .= $single_rec['name']." / " ?>
                  @else
                  <?php $message .= __('sales.basic_prescription')." / " ?>
                  @endif
                  @endforeach
                  <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title="{{__('reports.multiple')}}" data-content=" {{$message}}">live_help</i>
                  @endif

                  @else  {{-- old version --}}
                  @if(array_key_exists('name', $rec))
                  {{$rec['name']}}
                  @else
                  {{__('sales.basic_prescription')}}
                  @endif
                  @endif
                       </td>
                       <td>
                        {{$invoice->customer->name}}
                       </td>
                       <td>
                        {{$invoice->phone}}
                       </td>
                       <td>
                        {{$invoice->created_at}}
                       </td>
                       <td>
                        {{$invoice->user->name}}
                       </td>
                       <td>
                         @if($invoice->note)
                        {{$invoice->note}}
                        @else
                        {{__('sales.none')}}
                        @endif
                       </td>
                    </tr>
                    @else   {{-- there is no any old processes --}}
                    @if($invoice->status == 'delivered') 
                    <tr class="delivered">
                      @elseif($invoice->status == 'pending')
                      <tr class="pending">
                        @elseif($invoice->status == 'retrieved')
                        <tr class="retrieved">
                          @elseif($invoice->status == 'deleted')
                          <tr class="deleted">
                            @endif  
                            <td style="font-weight: bold">
                            {{$invoice->total_price}}
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
                        @if($invoice->discount==0)
                        {{__('sales.none')}}
                        @else
                        {{$invoice->discount}}
                        @endif
                     </td>
                     <td>
                      @if($invoice->transform == 'no')
                        @if($invoice->status == 'delivered')
                        {{__('sales.del_badge')}} 
                        @elseif($invoice->status == 'pending')
                        {{__('sales.hang_badge')}}
                        @elseif($invoice->status == 'retrieved')
                        {{__('sales.retrieved_badge')}}
                        @elseif($invoice->status == 'deleted')
                        {{__('reports.deleted')}}
                        @endif
                      @else {{-- there is a transform --}}
                          @if($invoice->transform == 'p-d')
                          {{__('sales.hang_badge')}} => {{__('sales.del_badge')}} 
                          @elseif($invoice->transform == 'p-r')
                          {{__('sales.hang_badge')}} => {{__('sales.retrieved_badge')}}
                          @elseif($invoice->transform == 'd-r')
                          {{__('sales.del_badge')}}  => {{__('sales.retrieved_badge')}}
                          @elseif($invoice->transform == 'd-x')
                          {{__('sales.del_badge')}}  => {{__('reports.deleted')}}
                          @elseif($invoice->transform == 'p-x')
                          {{__('sales.hang_badge')}}  => {{__('reports.deleted')}}
                          @endif
                      @endif
                     </td>
                     <td>
                      <?php $rec = unserialize($invoice->recipe); // array of arrays 
                            $message = '';
                      ?>
                      @if(isset($rec[0]) && is_array($rec[0]))  {{-- new version --}}
                      @if(count($rec)<=1) {{-- وصفة واحدة --}}
                      @foreach($rec as $single_rec)
                      @if(array_key_exists('name', $single_rec))
                      {{$single_rec['name']}}
                      @else
                      {{__('sales.basic_prescription')}}
                      @endif
                      @endforeach
                      @else  {{-- عدة وصفات --}}
                      {{__('reports.multiple')}}
                      @foreach($rec as $single_rec)
                      @if(array_key_exists('name', $single_rec))
                      <?php $message .= $single_rec['name']." / " ?>
                      @else
                      <?php $message .= __('sales.basic_prescription')." / " ?>
                      @endif
                      @endforeach
                      <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title="{{__('reports.multiple')}}" data-content=" {{$message}}">live_help</i>
                      @endif

                      @else  {{-- old version --}}
                      @if(array_key_exists('name', $rec))
                      {{$rec['name']}}
                      @else
                      {{__('sales.basic_prescription')}}
                      @endif
                      @endif
                     </td>
                     <td>
                      {{$invoice->customer->name}}
                     </td>
                     <td>
                      {{$invoice->phone}}
                     </td>
                     <td>
                      {{$invoice->created_at}}
                     </td>
                     <td>
                      {{$invoice->user->name}}
                     </td>
                     <td>
                       @if($invoice->note)
                      {{$invoice->note}}
                      @else
                      {{__('sales.none')}}
                      @endif
                     </td>
                  </tr>
                    @endif
                   
                  </tbody>
                </table>
              </div>
              </div>
            </div>
          </div>
        </div>

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
<script>
  window.onload=function(){
    $('#autofocus').focus();
    $(function () {
  $('[data-toggle="popover"]').popover()
  });
  };
  </script>
@endsection