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
  <span style="margin-right: 10px" class="badge badge-warning">
  اضغط على الروزنامة للبحث بالتاريخ
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
        <input type="text" name="code" class="form-control" placeholder="ابحث برقم الفاتورة">
        <button type="submit" class="btn btn-success btn-round btn-just-icon">
          <i class="material-icons">search</i>
        </button>
      </div>
    </form>
    @if($invoices->count()>0)
    @foreach($invoices as $invoice)
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> {{$invoice->created_at}}</h4>
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
                    @can('مشاهدة سعر التكلفة')
                    <th>
                      سعر التكلفة  
                    </th>
                    @endcan
                    <th>
                      السعر  
                    </th>
                    <th>
                        الكمية  
                    </th>
                    <th>
                      تم تسليمها  
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
            @if($invoice->recipe)
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
         @endif


              </div>
            </div>
          </div>
        </div>
        
      </div>
      @endforeach
      @else
      <span id="warning" class="badge badge-warning">
        لا يوجد فواتير 
      </span>
      @endif
    </div>
</div>
{{ $invoices->links() }}
@endsection