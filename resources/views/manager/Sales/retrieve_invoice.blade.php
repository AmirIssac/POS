@extends('layouts.main')
@section('links')
<style>
 
</style>
@endsection
@section('body')
<<div class="main-panel">
  
    <div class="content">
        <form action="{{route('retrieve.index',$repository->id)}}" method="GET">
          @csrf
          <div style="width: 300px; margin-right: 20px;" class="input-group no-border">
            <input type="search" name="search" class="form-control" placeholder="{{__('sales.mobile_invnum')}}">
            <button type="submit" class="btn btn-success btn-round btn-just-icon">
              <i class="material-icons">search</i>
            </button>
          </div>
        </form>
        
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
                        @can('مشاهدة سعر التكلفة')
                        <th>
                           {{__('reports.cost_price')}}  
                        </th>
                        @endcan
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
                            @can('مشاهدة سعر التكلفة')
                            <td>
                                {{$detail["cost_price"]}}
                             </td>
                             @endcan
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
                              {{__('sales.cash')}}
                            </td>
                            <td>
                              {{__('sales.card')}}
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
                          <td>
                            <button data-toggle="modal" data-target="#exampleModal" class="btn btn-danger"> {{__('sales.retrieve')}} </button> 
                          </td>
                        </tr>
                        <tr>
                          <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                      <h5 class="modal-title" id="exampleModalLabel">{{__('sales.warning')}}</h5>
                    </div>
                    <form action="{{route('retrieve.invoice',$invoice->id)}}" method="POST">
                      @csrf
                      <input type="hidden" name="repo_id" value="{{$repository->id}}">
                    <div class="modal-body">
                      {{__('sales.sure_you_want_retrieve_invoice_for_customer')}} {{$invoice->customer->name}}
                    </div>
                    <div class="modal-footer">
                      <a data-dismiss="modal" class="btn btn-danger">{{__('buttons.cancel')}}</a>
                      <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
                        </tr>
                      </tbody>
                    </table>
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