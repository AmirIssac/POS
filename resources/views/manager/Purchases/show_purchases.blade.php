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
</style>
@endsection
@section('body')
<div class="main-panel">
  
<div class="content">
  <div style="display: flex">
    <form action="{{route('search.purchases.by.date',$repository->id)}}" method="GET">
      @csrf
      <div style="width: 300px; margin-right: 20px;" class="input-group no-border">
        <input type="date" name="dateSearch" class="form-control">
        <button type="submit" class="btn btn-success btn-round btn-just-icon">
          <i class="material-icons">search</i>
        </button>
      </div>
    </form>
      <form action="{{route('search.purchases',$repository->id)}}" method="GET">
        @csrf
        <div style="width: 300px; margin-right: 20px;" class="input-group no-border">
          <input type="text" name="search" class="form-control" placeholder="رقم الفاتورة | اسم المورد">
          <button type="submit" class="btn btn-success btn-round btn-just-icon">
            <i class="material-icons">search</i>
          </button>
        </div>
      </form>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            
              <div class="card-header card-header-primary">
                
              <h4 class="card-title"> </h4>
              <h4> {{__('reports.invoices')}} <span class="badge badge-success"></span></h4>
              {{--<i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>--}}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                 {{-- <thead id="th{{$i}}" class="text-primary displaynone"> --}}
                    <th>
                      {{__('reports.invoice_num')}}  
                    </th>
                    <th>
                      {{__('reports.date')}}    
                  </th>
                    <th>
                      {{__('purchases.supplier')}}   
                    </th>
                    <th>
                      {{__('purchases.total_price')}}   
                    </th> 
                  <th>
                    {{__('reports.actions')}}
                </th>
                  </thead>
                  <tbody>
                     @if($purchases->count()>0)
                    @foreach($purchases as $purchase)
                    <tr>
                        <td>
                            {{$purchase->code}}
                        </td>
                        <td>
                          @if($purchase->created_at!=$purchase->updated_at)  {{-- it was later and then payed --}}
                            <span class="badge-secondary"> {{$purchase->created_at}} </span>   <span class="badge-success"> {{$purchase->updated_at}} </span>
                            @else
                            <span class="badge-success"> {{$purchase->created_at}} </span>
                            @endif
                        </td>
                        <td>
                            {{$purchase->supplier->name}}
                        </td>
                       
                        <td>
                            {{$purchase->total_price}}
                        </td>
                        
                      <td>
                       
                     <a style="color: #03a4ec" href="{{route('show.purchase.details',$purchase->id)}}"> <i class="material-icons eye">
                            visibility
                          </i> </a>
                          @can('استرجاع فاتورة مشتريات')
                          |
                          @if($purchase->status != 'retrieved')
                          
                          <a style="color: #f14000" data-toggle="modal" data-target="#exampleModal{{$purchase->id}}" id="modalicon" class="active-a">  <i class="material-icons">
                            swap_horizontal_circle
                          </i> </a>
                          @else
                          
                          <a style="color: #344b5e" class="disabled-a">  <i class="material-icons">
                            swap_horizontal_circle
                          </i> </a>
                          @endif
                          @endcan
                                        <!-- Modal for confirming -->
                        <div class="modal fade" id="exampleModal{{$purchase->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$purchase->id}}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel{{$purchase->id}}">{{__('purchases.retrieve_inv')}}</h5>
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
                          
                      </td>
                    </tr>
                    
                    @endforeach
                    @else
                    <tr>
                      <td>
                    <span id="warning" class="badge badge-warning">
                      {{__('reports.no_invoices')}}
                    </span>
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
        {{ $purchases->links() }}

      </div>
     
    </div>
</div>
@endsection

