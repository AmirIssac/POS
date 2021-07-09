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
  .bold{
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
          <?php $i = 0 ?>
          @if($purchases->count()>0)
         @foreach($purchases as $purchase)
          <div class="card">
            
              <div class="card-header card-header-primary">
                @if($purchase->created_at!=$purchase->updated_at)  {{-- it was later and then payed --}}
                <h4 class="card-title"> {{$purchase->created_at}} ==> {{$purchase->updated_at}}</h4>
                @else
              <h4 class="card-title"> {{$purchase->created_at}}</h4>
              @endif
              <h4>{{__('sales.invoice_code')}}  <span class="badge badge-success">{{$purchase->code}}</span></h4>
              <i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead id="th{{$i}}" class="text-primary displaynone">
                    <th>
                      Barcode
                  </th>
                  <th>
                    {{__('purchases.name')}}
                  </th>
                  <th>
                    {{__('sales.quantity')}}
                  </th>
                  <th>
                    {{__('purchases.price')}}
                  </th>
                  </thead>
                  <tbody id="tb{{$i}}" class="displaynone">
                    @foreach($purchase->purchaseRecords as $record)
                    <tr>
                        <td>
                            {{$record->barcode}}
                        </td>
                        <td>
                            {{$record->name}}
                        </td>
                        <td>
                            {{$record->quantity}}
                        </td>
                        <td>
                            {{$record->price}}
                        </td>
                    </tr>
                    @endforeach
                    
                    <tr class="bold">
                        
                        <td>
                          {{__('purchases.supplier')}}  
                        </td>
                       
                        <td>
                          {{__('purchases.employee')}}  
                        </td>
                        <td>
                          {{__('purchases.supplier_invoice_num')}}  
                        </td>
                        <td>
                          {{__('purchases.total_price')}}
                      </td>
                      <td>
                        {{__('purchases.payment_proccess')}}
                    </td>
                    </tr>
                    <tr>
                      <td>
                        {{$purchase->supplier->name}}
                      </td>
                      <td>
                          {{$purchase->user->name}}
                      </td>
                      <td>
                          @if($purchase->supplier_invoice_num)
                          {{$purchase->supplier_invoice_num}}
                          @else
                          {{__('purchases.none')}} 
                          @endif
                      </td>
                      <td>
                          {{$purchase->total_price}}
                      </td>
                      
                      <td>
                        @if($purchase->created_at!=$purchase->updated_at)  {{-- it was later and then payed --}}
                            @if($purchase->payment=='later')
                            {{__('purchases.later')}} => {{__('purchases.later')}}
                            @elseif($purchase->payment=='cashier')
                            {{__('purchases.later')}} => {{__('purchases.cashier')}}
                            @else
                            {{__('purchases.later')}} =>   {{__('purchases.cash_from_external_budget')}}  
                            @endif
                        @else
                            @if($purchase->payment=='later')
                            {{__('purchases.later')}}
                            @elseif($purchase->payment=='cashier')
                            {{__('purchases.cashier')}}
                            @else
                            {{__('purchases.cash_from_external_budget')}}  
                            @endif
                        @endif
                      </td>
                  </tr>
                  </tbody>
                </table>
           

              </div>
              </div>
            </div>
            <?php ++$i ?>
            @endforeach
            @else
            <span id="warning" class="badge badge-warning">
              {{__('purchases.no_purchases_invoices')}}
            </span>
            @endif
          </div>
        </div>
        {{ $purchases->links() }}

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