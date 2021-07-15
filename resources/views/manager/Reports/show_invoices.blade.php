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
  @if(request()->is('show/invoices/*'))
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
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            
              <div class="card-header card-header-primary">
                
              <h4 class="card-title"> </h4>
              <h4> الفواتير <span class="badge badge-success"></span></h4>
              {{--<i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>--}}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                 {{-- <thead id="th{{$i}}" class="text-primary displaynone"> --}}
                    <th>
                      رقم الفاتورة 
                    </th>
                    <th>
                      التاريخ    
                  </th>
                    <th>
                      الحالة   
                    </th>
                    <th>
                      العميل  
                    </th> 
                  <th>
                    المبلغ الاجمالي  
                  </th>
                  <th>
                    عمليات
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
                          تم التسليم
                          @elseif($invoice->status == 'pending')
                          معلقة
                          @elseif($invoice->status == 'retrieved')
                          مسترجعة
                          @endif
                        </td>
                       
                        <td>
                            {{$invoice->customer->name}}
                        </td>
                       
                        <td>
                            {{$invoice->total_price}}
                        </td>
                        
                      <td>
                     <a style="color: #03a4ec" href="{{route('invoice.details',$invoice->id)}}"> <i id="{{$i}}" class="material-icons eye">
                            visibility
                          </i> </a>
                          |
                          <a style="color: #93cb52" href="{{route('print.invoice',$invoice->id)}}"> <i id="{{$i}}" class="material-icons eye">
                            print
                          </i> </a>
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