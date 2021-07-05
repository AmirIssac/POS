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
    @if ($message = Session::get('fail'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
    </div>
    @endif
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
            <form action="{{route('pay.later.purchase',$purchase->id)}}" method="POST">
                @csrf
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead id="th{{$i}}" class="text-primary displaynone">
                    <th>
                        Barcode
                    </th>
                    <th>
                        الاسم
                    </th>
                    <th>
                        الكمية
                    </th>
                    <th>
                        السعر
                    </th>
                    
                  </thead>
                  <tbody id="tb{{$i}}" class="displaynone">
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

                    <tr class="bold">
                        <td>
                            المورد  
                          </td>
                         
                          <td>
                            موظف التسجيل  
                          </td>
                          <td>
                           رقم فاتورة المورد  
                          </td>
                          <td>
                            المبلغ الاجمالي
                        </td>
                        <td>
                            طريقة الدفع
                      </td>
                    </tr>
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
                            
                            آجل
                            
                           
                        </td>
                    </tr>
                    <tr>
                        <td>
                            كاش <input type="radio" name="payment" value="cashier" checked>
                        </td>
                        <td>
                            ميزانية خارجية <input type="radio" name="payment" value="external">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                    <button type="submit" class="btn btn-danger"> دفع </button>
                        </td>
                        <td>
                        </td>
                    </tr>
                  </tbody>
                </table>
           

              </div>
            </form>
              </div>
            
            </div>
            <?php ++$i ?>
            @endforeach
            @else
            <span id="warning" class="badge badge-warning">
              لا يوجد فواتير آجلة الدفع
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