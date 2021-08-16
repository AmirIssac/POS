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
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
  @if(request()->is('show/invoices/*') || request()->is('en/show/invoices/*'))
  <span style="margin-right: 10px" class="badge badge-warning">
    {{__('reports.click_calendar_to_search_by_date')}}
  </span>
  <div style="display: flex">
  <form action="{{route('search.invoices',$repository->id)}}" method="GET">
    @csrf
    <div style="width: 300px; margin-right: 20px;" class="input-group no-border">
      <input type="date" name="dateSearch" class="form-control">
      <button type="submit" class="btn btn-success btn-round btn-just-icon">
        <i class="material-icons">search</i>
      </button>
    </div>
  </form>
    <form action="{{route('search.invoices.code',$repository->id)}}" method="GET">
      @csrf
      <div style="width: 300px; margin-right: 20px;" class="input-group no-border">
        <input type="text" name="code" class="form-control" placeholder="{{__('reports.search_by_inv_num')}}">
        <button type="submit" class="btn btn-success btn-round btn-just-icon">
          <i class="material-icons">search</i>
        </button>
      </div>
    </form>
  </div>
  @endif
  {{-- pending invoices options --}}
  @if(request()->is('show/pending/invoices/*') || request()->is('en/show/pending/invoices/*'))
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
    @endif
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
                      {{__('reports.status')}}   
                    </th>
                    <th>
                      {{__('reports.customer')}}  
                    </th> 
                  <th>
                    {{__('reports.total_price')}}  
                  </th>
                  @if(request()->is('show/pending/invoices/*') || request()->is('en/show/pending/invoices/*') || request()->is('filter/pending/invoices/*') || request()->is('en/filter/pending/invoices/*') || request()->is('search/pending/*') || request()->is('en/search/pending/*'))
                  <th>
                    {{__('sales.remaining_price_complete')}}
                  </th>
                  @endif
                  <th>
                    {{__('reports.actions')}}
                </th>
                  </thead>
                  <tbody>
                    <?php $i = 0 ?>
                     @if($invoices->count()>0)
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>
                            {{$invoice->code}}
                        </td>
                        <td>
                          {{$invoice->created_at}}
                        </td>
                        <td>
                          @if($invoice->status == 'delivered')
                          {{__('sales.del_badge')}} 
                          @elseif($invoice->status == 'pending')
                          {{__('sales.hang_badge')}}
                          @elseif($invoice->status == 'retrieved')
                          {{__('sales.retrieve')}}
                          @elseif($invoice->status == 'deleted')
                          {{__('reports.deleted')}}
                          @endif
                        </td>
                       
                        <td>
                            {{$invoice->customer->name}}
                        </td>
                       
                        <td>
                            {{$invoice->total_price}}
                        </td>
                        @if(request()->is('show/pending/invoices/*') || request()->is('en/show/pending/invoices/*') || request()->is('filter/pending/invoices/*') || request()->is('en/filter/pending/invoices/*') || request()->is('search/pending/*') || request()->is('en/search/pending/*'))
                        <td>
                          {{$invoice->total_price - ($invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount)}}
                        </td>
                        @endif
                      <td>
                     <a style="color: #03a4ec" href="{{route('invoice.details',$invoice->id)}}"> <i id="{{$i}}" class="material-icons eye">
                            visibility
                          </i> </a>
                          |
                          <a style="color: #93cb52" href="{{route('print.invoice',$invoice->id)}}"> <i id="{{$i}}" class="material-icons eye">
                            print
                          </i> </a>
                          @can('استكمل فاتورة معلقة')
                          |
                          @if($invoice->status=='pending')
                            <a style="color: #f4c721" href="{{route('complete.invoice.form',$invoice->id)}}" class="active-a"> <i id="{{$i}}" class="material-icons">
                              incomplete_circle
                            </i> </a>
                          @else
                          <a style="color: #344b5e" class="disabled-a">  <i class="material-icons">
                            incomplete_circle
                          </i> </a>
                          @endif
                          @endcan
                          |
                          @if($invoice->daily_report_check==false && $invoice->transform=='no') {{-- change the payment values for today invoices and not edited ones --}}
                          <a style="color: #fc8f04" href="{{route('change.invoice.payment',$invoice->id)}}" class="active-a"> <i id="{{$i}}" class="material-icons">
                            price_change
                          </i> </a>
                          @else
                          <a style="color: #344b5e" class="disabled-a">  <i class="material-icons">
                            price_change
                          </i> </a>
                          @endif
                          |
                          @if($invoice->daily_report_check==false && $invoice->transform=='no') {{-- delete invoices that maked today --}}
                          <a style="color: #ff4454" data-toggle="modal" data-target="#exampleModal{{$invoice->id}}" class="active-a"> <i id="{{$i}}" class="material-icons">
                            delete_forever
                          </i> </a>
                                          <!-- Modal for Delete invoice -->
                        <div class="modal fade" id="exampleModal{{$invoice->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$invoice->id}}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel{{$invoice->id}}">{{__('reports.delete_invoice')}} </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true"></span>
                                </button>
                              </div>
                              <div class="modal-body">
                                   {{__('reports.sure_want_to_delete_invoice')}} ? <p style="color: #ff4454; font-weight: bold">{{$invoice->code}} </p>
                              </div>
                              <div class="modal-footer">
                                <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
                                <form action="{{route('delete.invoice',$invoice->id)}}" method="POST">
                                  @csrf
                                <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                              </form>
                              </div>
                            </div>
                          </div>
                        </div>
                          @else
                          <a style="color: #344b5e" class="disabled-a">  <i class="material-icons">
                            delete_forever
                          </i> </a>
                          @endif
                      </td>
                    </tr>
                    
                    <?php ++$i ?>
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
        {{ $invoices->links() }}

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