@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
  #warning{
    font-size: 38px;
  }
</style>
@endsection
@section('body')
<div class="main-panel">
  
<div class="content">
  @if (session('completeSuccess'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ session('completeSuccess') }}</strong>
  </div>
  @endif
  <div style="display: flex">
  <form action="{{route('search.pending',$repository->id)}}" method="GET">
    @csrf
    <div style="width: 300px; margin-right: 20px;" class="input-group no-border">
      <input type="text" name="search" class="form-control" placeholder="{{__('sales.mobile_invnum')}}">
      <button type="submit" class="btn btn-success btn-round btn-just-icon">
        <i class="material-icons">search</i>
      </button>
    </div>
  </form>
  {{-- filter --}}
  <form action="{{route('filter.pending.invoices',$repository->id)}}" method="GET">
    @csrf
    <div style="display: flex; margin-right: 10px;">
  <select name="filter" class="form-control">
    {{--<option value="" disabled selected hidden>الفلتر</option>--}}
    @if(request()->query('filter')=='payed')
    <option value="payed" selected>{{__('sales.payed')}}</option>
    <option value="notpayed">{{__('sales.not_payed')}}</option>
    @elseif(request()->query('filter')=='notpayed')
    <option value="payed">{{__('sales.payed')}}</option>
    <option value="notpayed" selected>{{__('sales.not_payed')}}</option>
    @else
    <option value="payed" selected>{{__('sales.payed')}}</option>
    <option value="notpayed">{{__('sales.not_payed')}}</option>
    @endif
  </select>
  <button type="submit" class="btn btn-success btn-round btn-just-icon">
    <i class="material-icons">search</i>
  </button>
    </div>
  </form>
  </div>
  @if($invoices->count()>0)
    @foreach($invoices as $invoice)
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form action="{{route('complete.invoice.form',$invoice->id)}}" method="GET">
            @csrf
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">   {{$invoice->created_at}}</h4>
              <h4> {{__('sales.invoice_code')}}<span class="badge badge-success">{{$invoice->code}}</span></h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
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
                    @foreach(unserialize($invoice->details) as $detail)
                    @if($detail)
                    <tr>
                        <td>
                            {{$detail['name_'.LaravelLocalization::getCurrentLocale()]}}
                        </td>
                        <td>
                          {{$detail['price']}}
                        </td>
                        <td>
                          {{$detail['quantity']}}
                        </td>
                        <td>
                          {{$detail['delivered']}}
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
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
                          STC-pay
                        </td>
                        <td>
                          {{__('sales.invoice_status')}} 
                        </td>
                        <td>
                          {{__('sales.customer_mobile')}} 
                        </td>
                        <td>
                          {{__('sales.sales_employee')}}  
                      </td>
                    </tr>
                    <tr>
                        <td>
                            {{$invoice->total_price}}
                        </td>
                        
                        <td>
                          @if($invoice->cash_amount>0)
                          <span class="badge badge-success">
                          {{$invoice->cash_amount}}
                          </span>
                          @else
                          <span class="badge badge-danger">
                            {{$invoice->cash_amount}}
                            </span>
                          @endif
                      </td>
                      <td>
                        @if($invoice->card_amount>0)
                        <span class="badge badge-success">
                        {{$invoice->card_amount}}
                        </span>
                        @else
                        <span class="badge badge-danger">
                          {{$invoice->card_amount}}
                          </span>
                        @endif
                        
                      </td>
                      <td>
                        @if($invoice->stc_amount>0)
                        <span class="badge badge-success">
                        {{$invoice->stc_amount}}
                        </span>
                        @else
                        <span class="badge badge-danger">
                          {{$invoice->stc_amount}}
                          </span>
                        @endif
                      </td>
                        <td>
                            @if($invoice->status=="delivered")
                            <span class="badge badge-success">
                                {{__('sales.del_badge')}} 
                            </span>
                            @else
                            <span class="badge badge-warning">
                              {{__('sales.hang_badge')}}
                            </span>
                            @endif 
                        </td>
                        <td>
                            @if($invoice->phone)
                            {{$invoice->phone}}
                            @else
                            {{__('sales.no_number')}}
                            @endif
                        </td>
                        <td>
                          {{$invoice->user->name}}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <di>
                  {{__('sales.remaining_price_complete')}}
                    <h2>{{($invoice->total_price)-($invoice->cash_amount+$invoice->card_amount+$invoice->stc_amount)}}</h2>
                </div>
                  <button type="submit" class="btn btn-danger"> {{__('sales.complete')}} </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      @else
      <span id="warning" class="badge badge-warning">
        {{__('sales.no_hanging_invoices')}}
      </span>
      @endif
    </div>
    {{ $invoices->links() }}
</div>
@endsection
@section('scripts')
<script> 
  
</script>
@endsection
