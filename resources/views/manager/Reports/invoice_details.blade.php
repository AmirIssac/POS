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
              <h4> الفاتورة {{$invoice->created_at}}   <span class="badge badge-success">{{$invoice->code}}</span></h4>
              {{--<i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>--}}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                 {{-- <thead id="th{{$i}}" class="text-primary displaynone"> --}}
                    <th>
                      Barcode  
                    </th>
                    <th>
                      الاسم    
                  </th>
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
                    <?php $records = unserialize($invoice->details) ?>
                    @for($i=1;$i<count($records);$i++)
                    <tr>
                        <td>
                            {{$records[$i]['barcode']}}
                        </td>
                        <td>
                            {{$records[$i]['name_ar']}}
                        </td>
                        <td>
                            {{$records[$i]['price']}}
                        </td>
                        <td>
                            {{$records[$i]['quantity']}}
                        </td>
                        <td>
                            {{$records[$i]['delivered']}}
                        </td>
                    </tr>
                    @endfor
                    <tr style="font-weight: 900">
                        <td>
                            المبلغ الاجمالي
                        </td>
                        <td>
                             كاش
                        </td>
                        <td>
                             بطاقة
                        </td>
                        <td>
                             stc-pay
                        </td>
                        <td>
                            حالة الفاتورة 
                        </td>
                        <td>
                             العميل 
                        </td>
                        <td>
                            جوال العميل 
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
                        {{$invoice->cash_amount}}
                       </td>
                       <td>
                        {{$invoice->card_amount}}
                       </td>
                       <td>
                        {{$invoice->stc_amount}}
                       </td>
                       <td>
                        @if($invoice->transform == 'no')
                          @if($invoice->status == 'delivered')
                          تم التسليم
                          @elseif($invoice->status == 'pending')
                          معلقة
                          @elseif($invoice->status == 'retrieved')
                          مسترجعة
                          @endif
                        @else {{-- there is a transform --}}
                            @if($invoice->transform == 'p-d')
                            معلقة => تم التسليم
                            @elseif($invoice->transform == 'p-r')
                            معلقة => مسترجعة
                            @elseif($invoice->transform == 'd-r')
                            تم التسليم => مسترجعة
                            @endif
                        @endif
                       </td>
                       <td>
                        {{$invoice->customer->name}}
                       </td>
                       <td>
                        {{$invoice->phone}}
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