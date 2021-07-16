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
                          {{$purchase->created_at}}
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

