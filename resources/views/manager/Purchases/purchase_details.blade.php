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
              @if($purchase->created_at!=$purchase->updated_at)  {{-- it was later and then payed --}}
                <h4 class="card-title"> {{$purchase->created_at}} ==> {{$purchase->updated_at}}</h4>
                @else
              <h4 class="card-title"> {{$purchase->created_at}}</h4>
              @endif
                 <h4><span class="badge badge-success">{{$purchase->code}}</span></h4>
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
                  </thead>
                  <tbody>
                    @foreach($purchase->purchaseRecords as $record)
                    <tr>
                        <td>
                            {{$record->barcode}}
                        </td>
                        <td>
                            {{$record->name}}
                        </td>
                        <td>
                            {{$record->price}}
                        </td>
                        <td>
                            {{$record->quantity}}
                        </td>
                    </tr>
                    @endforeach
                    <tr style="font-weight: 900">
                        <td>
                          {{__('purchases.supplier')}} 
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
                        <td>
                          {{__('purchases.status')}}
                        </td>
                        <td>
                          {{__('purchases.employee')}}   
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{$purchase->supplier->name}}
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
                       <td>
                        @if($purchase->status=='done')
                          {{__('purchases.done')}}
                        @elseif($purchase->status=='retrieved')
                          {{__('sales.retrieved_badge')}}
                        @endif
                       </td>
                       <td>
                           {{$purchase->user->name}}
                       </td>
                    </tr>
                  </tbody>
                </table>
                @can('استرجاع فاتورة مشتريات')
                @if($purchase->status != 'retrieved')
                <a class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" id="modalicon">  {{__('sales.retrieve')}} </a>
                @endif
                @endcan
                              <!-- Modal for confirming -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{__('purchases.retrieve_inv')}}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                      </button>
                    </div>
                    <div class="modal-body">
                      {{__('purchases.sure_you_want_refund_invoice')}}
                    </div>
                    <div class="modal-footer">
                      <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
                      <form action="{{route('purchase.retrieve',$purchase->id)}}" method="POST">
                        @csrf
                      <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              </div>
            </div>
          </div>
        </div>

      </div>
     
    </div>
</div>
@endsection

