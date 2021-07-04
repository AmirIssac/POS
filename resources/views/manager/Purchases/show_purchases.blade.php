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
  .bold{
      font-weight: bold;
  }
</style>
@endsection
@section('body')
<div class="main-panel">
  
<div class="content">
  
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php $i = 0 ?>
          @if($purchases->count()>0)
         @foreach($purchases as $purchase)
          <div class="card">
            
              <div class="card-header card-header-primary">
                
              <h4 class="card-title"> {{$purchase->created_at}}</h4>
              <h4>{{__('sales.invoice_code')}}  <span class="badge badge-success">{{$purchase->code}}</span></h4>
              <i style="float: left" id="{{$i}}" class="material-icons eye">
                visibility
              </i>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead id="th{{$i}}" class="text-primary displaynone">
                    <th>
                      المورد  
                    </th>
                   
                    <th>
                      موظف التسجيل  
                    </th>
                    <th>
                     رقم فاتورة المورد  
                    </th>
                    <th>
                      المبلغ الاجمالي
                  </th>
                  <th>
                      طريقة الدفع
                </th>
                  </thead>
                  <tbody id="tb{{$i}}" class="displaynone">
                    
                    <tr>
                        <td>
                          {{$purchase->supplier->name}}
                        </td>
                        <td>
                            {{$purchase->user->name}}
                        </td>
                        <td>
                            @if($purchase->supplier_invoice_num)
                            {{$purchase->supplier_invoice_num}}
                            @else
                            لا يوجد
                            @endif
                        </td>
                        <td>
                            {{$purchase->total_price}}
                        </td>
                        
                        <td>
                            @if($purchase->payment=='later')
                            آجل
                            @elseif($purchase->payment=='cashier')
                            الدرج
                            @else
                            ميزانية خارجية مخصصة
                            @endif
                        </td>
                    </tr>
                    <tr class="bold">
                        <td>
                            Barcode
                        </td>
                        <td>
                            الاسم
                        </td>
                        <td>
                            الكمية
                        </td>
                        <td>
                            السعر
                        </td>
                    </tr>
                    @foreach($purchase->purchaseRecords as $record)
                    <tr>
                        <td>
                            {{$record->barcode}}
                        </td>
                        <td>
                            {{$record->name}}
                        </td>
                        <td>
                            {{$record->quantity}}
                        </td>
                        <td>
                            {{$record->price}}
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
           

              </div>
              </div>
            </div>
            <?php ++$i ?>
            @endforeach
            @else
            <span id="warning" class="badge badge-warning">
              لا يوجد فواتير مشتريات
            </span>
            @endif
          </div>
        </div>
        {{ $purchases->links() }}

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