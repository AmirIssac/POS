@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
</style>
@endsection
@section('body')
<div class="main-panel">
  
<div class="content">
  <span style="margin-right: 10px" class="badge badge-warning">
  اضغط على الروزنامة للبحث بالتاريخ
  </span>
  <form action="{{route('search.invoices',$repository->id)}}" method="GET">
    @csrf
    <div style="width: 300px; margin-right: 20px;" class="input-group no-border">
      <input type="date" name="dateSearch" class="form-control">
      <button type="submit" class="btn btn-black btn-round btn-just-icon">
        <i class="material-icons">search</i>
      </button>
    </div>
  </form>
    @foreach($invoices as $invoice)
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> فاتورة  {{$invoice->created_at}}</h4>
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
                            {{$detail["detail"]}}
                        </td>
                        <td>
                            {{$detail["price"]}}
                        </td>
                        <td>
                            {{$detail["quantity"]}}
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
              </div>
            </div>
          </div>
        </div>
        
      </div>
      @endforeach
    </div>
</div>
{{ $invoices->links() }}
@endsection