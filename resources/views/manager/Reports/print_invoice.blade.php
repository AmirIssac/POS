@extends('layouts.withScrollBar')
@section('links')
<style>
  
  .displaynone{
    display: none;
  }
  @media print{
 /* body, html, #myform { 
          height: 100%;
      }*/
     /* body * {
    visibility: hidden;
  } */
  *{
    /*margin: 0;*/
    font-size: 44px !important;
    font-weight: 900 !important;
    color: black !important;
  }
  .barcode,.quantity,.delivered,.blank{
    font-size: 32px;
    background-color: white !important;
  }
  input[type="number"]{
    font-size: 32px;
    background-color: white !important;
  }
  #print-content, #print-content * {
    visibility: visible;
  }
  #logorep{
    width: 150px !important;
    height: 150px !important;
    border-radius: 50%;
  }
  #mod{
    display: none;
  }
  hr{
    border: 1px solid black;
  }
  #back{
    display: none;
  }
  /*#print-content {
    position: absolute;
    left: 0;
    top: 0;
  }*/
}
</style>
@endsection
@section('body')

<div class="main-panel">
 <div class="content" id="content">
    
                      <div id="print-content" class="table-responsive">
                          <button id="back" onclick="history.back()" class="btn btn-warning">رجوع</button>
                        <div style="display: flex; justify-content: space-between;">
                          <h4> متجر {{$repository->name}}</h4>
                          </div>
                        <div style="display: flex; justify-content: space-between">
                          <h4>رقم الفاتورة {{$invoice->code}}</h4>
                          <h4>التاريخ {{$invoice->created_at}}</h4>
                          <h4>الرقم الضريبي {{$repository->tax_code}}</h4>
                        </div>
                        <hr>
                        <table class="table">
                          <thead class="text-primary">
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
                            <th id="del" class="">
                              تم تسليمها  
                            </th>
                          </thead>
          
                          <tbody>
                              <?php $records = unserialize($invoice->details) ?>
                            @for($i=1;$i<count($records);$i++)
                             <div>
                              <tr>
                                <td>
                                    <input type="hidden" value="{{count($records)}}" id="num">
                                    <input type="text"  name="barcode[]" value="{{$records[$i]['barcode']}}"  class="form-control barcode" readonly>
                                </td>
                                <td>  {{-- في الطباعة تم الطلب بعرض الاسم بالعربية فقط دوما --}}
                                  <input type="text"   name="name[]" value="{{$records[$i]['name_ar']}}" class="form-control name blank" readonly>
                                </td>
                                <td style="display: none;">
                                  <input type="hidden"  name="cost_price[]" value="{{$records[$i]['cost_price']}}" class="form-control blank" readonly>
                                </td>
                                <td>
                                  <input type="number"   name="price[]" value="{{$records[$i]['price']}}" id="price{{$i}}" class="form-control price blank" readonly>
                                </td>
                                <td>
                                  <input type="number" name="quantity[]" value="{{$records[$i]['quantity']}}" id="quantity{{$i}}" class="form-control quantity" readonly>
                              </td>
                              <td>
                                  @if($records[$i]['delivered'] != 0)
                                  <input type="text" name="del[]" value="نعم" class="form-control delivered" readonly>
                                  @else
                                  <input type="text" name="del[]" value="لا" class="form-control delivered" readonly>
                                  @endif
                              </td>
                          </tr>
                      </div>
                      @endfor
                   </tbody>
                 </table>
                 <hr>
                 <div id="cash-info">
                  <div style="display: flex; justify-content: space-between">
                    <div>
                      <h5>
                         المجموع 
                      </h5>
                      {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
                      <input type="number" name="sum" id="total_price" class="form-control" value="" readonly>
                    </div>
             
                    <div id="tax-container">
                      <h5>الضريبة</h5>
                     <div style="display: flex; flex-direction: column; margin-top: 3px;">
                       <div style="display: flex;">
                         <input type="number" value="{{$invoice->tax}}"  id="taxfield" class="form-control" readonly>
                       </div>
                     </div>
                   </div>
             
                   <div>
                    <h5>الحسم</h5>
                   <div style="display: flex; flex-direction: column; margin-top: 3px;">
                     <div style="display: flex;">
                        <input type="hidden" name="discountval" value="{{$invoice->discount}}" id="discountVal">
                       %<input type="number" value="" class="form-control" id="discount" readonly>
                     </div>
                   </div>
                 </div>
                     </div>
                 <div>
                   <h3>
                     المبلغ الإجمالي 
                   </h3>
                   {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
                   <input type="number" name="total_price" id="final_total_price" class="form-control" value="{{$invoice->total_price}}" readonly>
                 </div>
                 </div>
                 <hr>
                 {{--<i class="material-icons">add_circle</i>--}}
                 <div id="settings">
                  <div style="display: flex; justify-content: space-between;">
                    <div style="display: flex; flex-direction: column; margin-top: 10px">
                      <div style="display: flex;">
                    <h4> &nbsp;الدفع كاش</h4>
                      </div>
                    <input type="number" min="0.1" step="0.01" name="cashVal" id="cashVal" value="{{$invoice->cash_amount}}" class="form-control" readonly>
                    </div>
                    <div style="display: flex;flex-direction: column;">
                      <div style="display: flex;">
                    <h4> &nbsp;الدفع بالبطاقة</h4>
                      </div>
                    <input type="number" min="0.1" step="0.01" name="cardVal" id="cardVal" value="{{$invoice->card_amount}}" class="form-control" readonly>
                    </div>
                    <div style="display: flex;flex-direction: column;">
                      <div style="display: flex;">
                    <h4> &nbsp; STC-pay </h4>
                      </div>
                    <input type="number" min="0.1" step="0.01" name="stcVal" id="stcVal" value="{{$invoice->stc_amount}}" class="form-control" readonly>
                    </div>
                    <?php $remaining_amount = $invoice->total_price - ($invoice->cash_amount+$invoice->card_amount+$invoice->stc_amount) ?>
                    @if($remaining_amount > 0)
                    <div style="display: flex;flex-direction: column;">
                      <div style="display: flex;">
                    <h4> &nbsp; المبلغ المتبقي للدفع </h4>
                      </div>
                    <input type="number" step="0.01"  value="{{$remaining_amount}}" class="form-control" readonly>
                    </div>
                    @endif
                    </div> 
        </div>
        <hr>
        <div style="display: flex; justify-content: space-between">
          <h4>العميل {{$invoice->customer->name}}</h4>
          <h4>جوال العميل {{$invoice->phone}}</h4>
        </div>
        <div style="display: flex; justify-content: space-between">
          <h4>موظف البيع {{$invoice->user->name}}</h4>
        </div>
        @if($invoice->note)
        <div>
          <h4>{{$invoice->note}}</h4>
        </div>
        @endif
        @if($repository->note)
        <div>
          <h4>{{$repository->note}}</h4>
        </div>
        @endif
        
    </div>
 
 
@section('scripts')
<script>
$(document).ready(function() {
  $('#exampleModal').modal('show');
});
</script>
<script>
  $('#print').on('click',function(){
    $('#mod').addClass('displaynone');
  });
</script>
<script>
window.onload = (event) => {
  var num = parseFloat($('#num').val()); // number of records
  var sum = 0;
  for(var i=1;i<num;i++){
    sum = sum + $('#price'+i).val() * $('#quantity'+i).val();
  }
  $('#total_price').val(sum);
  var temp = parseFloat($('#taxfield').val()) + parseFloat($('#total_price').val());
  var discountPercent = parseFloat($('#discountVal').val()) * 100 /  temp;
  discountPercent = parseInt(discountPercent);
  $('#discount').val(discountPercent);
  window.print();
};
</script>
{{--<script>
    window.onload = (event) => {
        window.print();
    }
</script>--}}
@endsection
@endsection