@extends('layouts.print')
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
   <!-- Modal -->
   <div id="mod">
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">تمت عملية البيع بنجاح</h5>
      </div>
      <div class="modal-body">
        هل تريد طباعة الفاتورة ؟
      </div>
      <div class="modal-footer">
        <a href="{{route('create.special.invoice',$repo_id)}}" class="btn btn-danger">لا</a>
        <a id="print" onclick="window.print();" href="{{route('create.special.invoice',$repo_id)}}" class="btn btn-primary">نعم</a>
      </div>
    </div>
  </div>
</div>
   </div>
    
                      <div id="print-content" class="table-responsive">
                        <div style="display: flex; justify-content: space-between;">
                          @if($repository->logo)
                          <img src="{{asset('storage/'.$repository->logo)}}" width="50px" height="50px" id="logorep">
                          @endif
                          <h4> متجر {{$repository->name}}</h4>
                          </div>
                        <div style="display: flex; justify-content: space-between">
                          <h4>رقم الفاتورة {{$invoice_num}}</h4>
                          <h4>التاريخ {{$date}}</h4>
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
                            @for($i=1;$i<$num;$i++)
                             <div>
                              <tr>
                                <td>
                                    <input type="text"  name="barcode[]" value="{{$records[$i]['barcode']}}"  class="form-control barcode" readonly>
                                </td>
                                <td>  {{-- في الطباعة تم الطلب بعرض الاسم بالعربية فقط دوما --}}
                                  <input type="text"   name="name[]" value="{{$records[$i]['name_ar']}}" class="form-control name blank" readonly>
                                </td>
                                <td style="display: none;">
                                  <input type="hidden"  name="cost_price[]" value="{{$records[$i]['cost_price']}}" class="form-control blank" readonly>
                                </td>
                                <td>
                                  <input type="number"   name="price[]" value="{{$records[$i]['price']}}" class="form-control price blank" readonly>
                                </td>
                                <td>
                                  <input type="number" name="quantity[]" value="{{$records[$i]['quantity']}}" class="form-control quantity" readonly>
                              </td>
                              <td>
                                  <input type="text" name="del[]" value="{{$records[$i]['del']}}" class="form-control delivered" readonly>
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
                    <input type="number" name="sum" id="total_price" class="form-control" value="{{$sum}}" readonly>
                  </div>
           
                  <div id="tax-container">
                    <h5>الضريبة</h5>
                   <div style="display: flex; flex-direction: column; margin-top: 3px;">
                     <div style="display: flex;">
                       <input type="number" value="{{$tax}}"  id="taxfield" class="form-control" readonly>
                     </div>
                   </div>
                 </div>
           
                 <div>
                  <h5>الحسم</h5>
                 <div style="display: flex; flex-direction: column; margin-top: 3px;">
                   <div style="display: flex;">
                     %<input type="number" value="{{$discount}}" class="form-control" readonly>
                   </div>
                 </div>
               </div>
                   </div>
                 <div>
                   <h3>
                     المبلغ الإجمالي 
                   </h3>
                   {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
                   <input type="number" name="total_price" id="final_total_price" class="form-control" value="{{$total_price}}" readonly>
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
                    <input type="number" min="0.1" step="0.01" name="cashVal" id="cashVal" value="{{$cash}}" class="form-control" readonly>
                    </div>
                    <div style="display: flex;flex-direction: column;">
                      <div style="display: flex;">
                    <h4> &nbsp;الدفع بالبطاقة</h4>
                      </div>
                    <input type="number" min="0.1" step="0.01" name="cardVal" id="cardVal" value="{{$card}}" class="form-control" readonly>
                    </div>
                    <div style="display: flex;flex-direction: column;">
                      <div style="display: flex;">
                    <h4> &nbsp; STC-pay </h4>
                      </div>
                    <input type="number" min="0.1" step="0.01" name="stcVal" id="stcVal" value="{{$stc}}" class="form-control" readonly>
                    </div>
                    </div> 
        </div>
        <hr>
        <div style="display: flex; justify-content: space-between">
          <h4>العميل {{$customer->name}}</h4>
          <h4>جوال العميل {{$customer->phone}}</h4>
        </div>
        <div style="display: flex; justify-content: space-between">
          <h4>موظف البيع {{$employee->name}}</h4>
        </div>
        
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
@endsection
@endsection