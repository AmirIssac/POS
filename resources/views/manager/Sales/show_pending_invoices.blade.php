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
  <form action="{{route('search.pending',$repository->id)}}" method="GET">
    @csrf
    <div style="width: 300px; margin-right: 20px;" class="input-group no-border">
      <input type="text" name="phoneSearch" class="form-control" placeholder="ابحث برقم الزبون">
      <button type="submit" class="btn btn-black btn-round btn-just-icon">
        <i class="material-icons">search</i>
      </button>
    </div>
  </form>
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
              <h4>رقم الفاتورة <span class="badge badge-success">{{$invoice->code}}</span></h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      الاسم  
                    </th>
                    <th>
                      التفاصيل  
                    </th>
                    <th>
                      السعر  
                    </th>
                    <th>
                        الكمية  
                    </th>
                  </thead>
                  <tbody>
                    @foreach(unserialize($invoice->details) as $detail)
                    @if($detail)
                    <tr>
                        <td>
                            {{$detail['name']}}
                        </td>
                        <td>
                          {{$detail['detail']}}
                        </td>
                        <td>
                          {{$detail['price']}}
                        </td>
                        <td>
                          {{$detail['quantity']}}
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td>
                            السعر الكلي
                        </td>
                        <td>
                              كاش
                        </td>
                        <td>
                              بطاقة
                        </td>
                        <td>
                            حالة الفاتورة
                        </td>
                        <td>
                            رقم الزبون
                        </td>
                        <td>
                          موظف البيع 
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
                                تم التسليم
                            </span>
                            @else
                            <span class="badge badge-warning">
                                معلقة
                            </span>
                            @endif 
                        </td>
                        <td>
                            @if($invoice->phone)
                            {{$invoice->phone}}
                            @else
                            لا يوجد رقم زبون
                            @endif
                        </td>
                        <td>
                          {{$invoice->user->name}}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <di>
                  المبلغ المتبقي للاستكمال
                    <h2>{{($invoice->total_price)-($invoice->cash_amount+$invoice->card_amount)}}</h2>
                </div>
                  <button type="submit" class="btn btn-danger"> استكمال </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      @else
      <span id="warning" class="badge badge-warning">
        لا يوجد فواتير معلقة
      </span>
      @endif
    </div>
</div>
{{ $invoices->links() }}
@endsection