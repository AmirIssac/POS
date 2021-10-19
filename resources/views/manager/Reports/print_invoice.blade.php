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
    font-size: 22px !important;
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


    
                      <div id="print-content" class="table-responsive">
                          <button id="back" onclick="history.back()" class="btn btn-warning">رجوع</button>
                        <div style="display: flex;">
                          @if($repository->logo)
                          <img src="{{asset('public/storage/'.$repository->logo)}}" width="50px" height="50px" id="logorep">
                          @endif
                          <div style="display: flex; justify-content: center;align-items: center; margin-right: 10px;">
                          <h4>{{$repository->name}}</h4>
                          </div>
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
                      {{--  <input type="hidden" name="discountval" value="{{$invoice->discount}}" id="discountVal">
                       %<input type="number" value="" class="form-control" id="discount" readonly> --}}
                       <input type="number" class="form-control" value="{{$invoice->discount}}" id="discount" readonly>
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
                    <div style="display: flex;flex-direction: column;">
                      <div style="display: flex;">
                    <h4> &nbsp; المبلغ المتبقي للدفع </h4>
                      </div>
                    <input type="number" step="0.01"  value="{{$remaining_amount}}" class="form-control" readonly>
                    </div>
                    </div> 
        </div>
        <hr>
        @if($repository->setting->print_prescription == true)
        @if(isset($recipe) && $recipe) 
        <div id='prescription'>
          @for($i=0;$i<count($recipe);$i++)
          <div id="recipe" class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">  الوصفة الطبية  </h4>
              @if(array_key_exists('name', $recipe[$i]))
                {{$recipe[$i]['name']}}
              @endif
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table dir="ltr" id="myTable" class="table table-bordered">
                  <thead class="text-primary">
                    
                  </thead>
                  <tbody>
                    <tr>
                      <td style="text-align: center; font-weight: bold; font-size: 18px;">
                        EYE 
                      </td>
                      <td>
                        SPH  
                      </td>
                      <td>
                        CYL  
                       </td>   
                       <td>
                        Axis  
                      </td>
                      <td>
                        ADD  
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align: center; font-weight: bold; font-size: 18px;">
                        RIGHT
                      </td>
                      <td>
                        @if(floatval($recipe[$i]['sph_r']) > 0)
                        +{{$recipe[$i]['sph_r']}}
                        @else
                        {{$recipe[$i]['sph_r']}}
                        @endif
                      </td>
                      <td>
                        @if(floatval($recipe[$i]['cyl_r']) > 0)
                        +{{$recipe[$i]['cyl_r']}}
                        @else
                        {{$recipe[$i]['cyl_r']}}
                        @endif
                      </td>
                      <td>
                        {{$recipe[$i]['axis_r']}}
                      </td>
                      <td>
                        @if(floatval($recipe[$i]['add_r']) > 0)
                        +{{$recipe[$i]['add_r']}}
                        @else
                        {{$recipe[$i]['add_r']}}
                        @endif
                      </td>
                    </tr>
                    <tr>
                     <td style="text-align: center; font-weight: bold; font-size: 18px;">
                       LEFT
                     </td>
                     <td>
                      @if(floatval($recipe[$i]['sph_l']) > 0)
                      +{{$recipe[$i]['sph_l']}}
                      @else
                      {{$recipe[$i]['sph_l']}}
                      @endif
                    </td>
                    <td>
                      @if(floatval($recipe[$i]['cyl_l']) > 0)
                      +{{$recipe[$i]['cyl_l']}}
                      @else
                      {{$recipe[$i]['cyl_l']}}
                      @endif
                    </td>
                    <td>
                      {{$recipe[$i]['axis_l']}}
                    </td>
                    <td>
                      @if(floatval($recipe[$i]['add_l']) > 0)
                      +{{$recipe[$i]['add_l']}}
                      @else
                      {{$recipe[$i]['add_l']}}
                      @endif
                    </td>
                  </tr>
                  <tr>
                   <td style="border: none">
                   </td>
                   <td style="border: none">
                   </td>
                   <td style="text-align: center; font-weight: bold; font-size: 18px;">
                     IPD
                   </td>
                    <td>
                      {{$recipe[$i]['ipd']}}
                    </td>
                    <td style="border: none">
                   </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          @endfor
        </div>
        <hr>
        @endif
        @endif
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
        {{QrCode::encoding('UTF-8')->size(150)->generate('[اسم المورد : '.$repository->name.'] , [الطابع الزمني : '.$invoice->created_at.'] , [الرقم الضريبي : '.$repository->tax_code.'] [الضريبة : '.$invoice->tax.'] , [اجمالي الفاتورة : '.$invoice->total_price.']')}}

 
 
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
  }
</script>
{{--<script>
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
</script>--}}
<script>
    window.onload = (event) => {
        window.print();
    }
</script>
@endsection
@endsection