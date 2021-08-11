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
   /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
</style>
@endsection
@section('body')
<div class="main-panel">
  
<div class="content">
    @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
  @if ($message = Session::get('fail'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            
              <div class="card-header card-header-primary">
                
              <h4 class="card-title"> </h4>
              <h4> {{__('sales.edit_payment_values_invoice')}} {{$invoice->created_at}}   <span class="badge badge-success">{{$invoice->code}}</span></h4>
              {{--<i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>--}}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                  <form action="{{route('make.change.invoice.payment',$invoice->id)}}" method="POST">
                      @csrf
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
                          {{__('reports.customer')}} 
                        </td>
                        <td>
                          {{__('sales.customer_mobile')}}  
                        </td>
                        <td>
                          {{__('sales.sales_employee')}}  
                        </td>
                        <td>
                          {{__('sales.note')}}  
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{$invoice->total_price}}
                       </td>
                       <td>
                        <input type="hidden" name="old_cash" step="0.01" min="0" value="{{$invoice->cash_amount}}" class="form-control">
                        <input type="number" name="cash" step="0.01" min="0" value="{{$invoice->cash_amount}}" class="form-control">
                       </td>
                       <td>
                        <input type="hidden" name="old_card" step="0.01" min="0" value="{{$invoice->card_amount}}" class="form-control">
                        <input type="number" name="card" step="0.01" min="0" value="{{$invoice->card_amount}}" class="form-control">
                       </td>
                       <td>
                        <input type="hidden" name="old_stc" step="0.01" min="0" value="{{$invoice->stc_amount}}" class="form-control">
                        <input type="number" name="stc" step="0.01" min="0" value="{{$invoice->stc_amount}}" class="form-control">
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
                          @endif
                        @else {{-- there is a transform --}}
                            @if($invoice->transform == 'p-d')
                            {{__('sales.hang_badge')}} => {{__('sales.del_badge')}} 
                            @elseif($invoice->transform == 'p-r')
                            {{__('sales.hang_badge')}} => {{__('sales.retrieved_badge')}}
                            @elseif($invoice->transform == 'd-r')
                            {{__('sales.del_badge')}}  => {{__('sales.retrieved_badge')}}
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
                    <tr>
                        <td>
                            <button class="btn btn-primary">{{__('buttons.confirm')}}</button>
                        </td>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                  </tbody>
                </table>
                  </form>
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
@endsection