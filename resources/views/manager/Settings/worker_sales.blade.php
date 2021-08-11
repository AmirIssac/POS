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
</style>
@endsection
@section('body')
<div class="main-panel">
    @if (session('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('success') }}</strong>
    </div>
    @endif
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> {{__('reports.sales')}} {{$user->name}} </h4>
              <span class="badge badge-success">{{$invoices->count()}} {{__('reports.invoice')}}</span>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                        {{__('sales.invoice_code')}} 
                      </th>
                      <th>
                        {{__('sales.invoice_status')}} 
                      </th>
                      <th>
                        {{__('sales.total_price')}}
                      </th>
                      <th>
                        {{__('sales.date')}}
                      </th>
                     
                  </thead>
                  <tbody>
                    @foreach($invoices as $invoice)
                   <tr>
                      <td>
                          {{$invoice->code}}
                      </td>
                      <td>
                        @if($invoice->status == 'delivered')
                        {{__('sales.del_badge')}} 
                        @elseif($invoice->status == 'pending')
                        {{__('sales.hang_badge')}}
                        @elseif($invoice->status == 'retrieved')
                        {{__('sales.retrieve')}}
                        @endif
                    </td>
                    <td>
                        {{$invoice->total_price}}
                    </td>
                    <td>
                        {{$invoice->created_at}}
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
       

      </div>
     {{ $invoices->links() }}
    </div>
</div>
@endsection