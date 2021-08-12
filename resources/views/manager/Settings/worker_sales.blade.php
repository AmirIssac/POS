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
            </div>
            <div class="card-body">
              <div class="table-responsive">
                
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                        {{__('reports.invoices_num')}} 
                      </th>
                      <th>
                        {{__('reports.sales')}} 
                      </th>
                  </thead>
                  <tbody>
                    <?php $sales = 0 ; ?>
                   @foreach($invoices as $invoice)
                   @if($invoice->status != 'retrieved' && $invoice->monthlyReports()->count()==0) 
                    <?php $sales+=$invoice->total_price ?>
                    @endif
                   @endforeach
                   <tr>
                      <td>
                        {{$invoices->count()}}
                      </td>
                    <td>
                      {{$sales}}
                    </td>
                   
                   </tr>
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