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
  
<div class="content">
  @if(request()->is('show/invoices/*'))
  <span style="margin-right: 10px" class="badge badge-warning">
    {{__('reports.click_calendar_to_search_by_date')}}
  </span>
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
    @endif
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          @if($invoices->count()>0)
         @foreach($invoices as $invoice)
          <div class="card">
            
              <div class="card-header card-header-primary">
                
              <h4 class="card-title"> {{$invoice->created_at}}</h4>
              <h4>{{__('sales.invoice_code')}}  <span class="badge badge-success">{{$invoice->code}}</span></h4>
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
                            {{$detail["price"]}}
                        </td>
                        <td>
                            {{$detail["quantity"]}}
                        </td>
                        <td>
                          {{$detail["delivered"]}}
                      </td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td>
                          {{__('sales.total_price')}}
                        </td>
                        <td>
                          {{__('sales.discount')}}
                        </td>
                        <td>
                          {{__('sales.cash')}}
                        </td>
                        <td>
                          {{__('sales.card')}}
                        </td>
                        <td>
                          STC pay
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
                          {{$invoice->discount}}
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
                            @elseif($invoice->status=="pending")
                            <span class="badge badge-warning">
                              {{__('sales.hang_badge')}} 
                            </span>
                            @else
                            <span class="badge badge-secondary">
                              {{__('sales.retrieved_badge')}} 
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
           {{-- @if($invoice->recipe)
            <?php $recipe = unserialize($invoice->recipe) ?>
                <table id="myTable" class="table table-bordered">
                  <thead class="text-primary">
                    <th>
                      ADD  
                    </th>
                    <th>
                      Axis  
                    </th>
                    <th>
                      CYL  
                     </th>   
                    <th>
                      SPH  
                  </th>
                    <th>
                      EYE  
                    </th>
                   
                  </thead>
                  <tbody>
                 <tr>
                  <td>
                    {{$recipe['add_r']}}
                  </td>
                  <td>
                    {{$recipe['axis_r']}}
                  </td>
                  <td>
                    {{$recipe['cyl_r']}}
                  </td>
                  <td>
                    {{$recipe['sph_r']}}
                  </td>
                  <td style="text-align: center; font-weight: bold; font-size: 18px;">
                    RIGHT
                  </td>
                 </tr>
                 <tr>
                  <td>
                    {{$recipe['add_l']}}
                  </td>
                  <td>
                    {{$recipe['axis_l']}}
                  </td>
                  <td>
                    {{$recipe['cyl_l']}}
                  </td>
                  <td>
                    {{$recipe['sph_l']}}
                  </td>
                  <td style="text-align: center; font-weight: bold; font-size: 18px;">
                    LEFT
                  </td>
                 </tr>
                 <tr>
                   <td style="border: none">
                   </td>
                   <td>
                    {{$recipe['ipd']}}
                   </td>
                   <td style="text-align: center; font-weight: bold; font-size: 18px;">
                     IPD
                   </td>
                   <td style="border: none">
                  </td>
                  <td style="border: none">
                  </td>
                 </tr>
           </tbody>
         </table>
         @endif--}}

              </div>
              </div>
            </div>
            @endforeach
            @else
            <span id="warning" class="badge badge-warning">
              {{__('reports.no_invoices')}}
            </span>
            @endif
          </div>
        </div>
        {{ $invoices->links() }}

      </div>
     
    </div>
</div>
@endsection