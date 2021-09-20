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
  /*#print-content {
    position: absolute;
    left: 0;
    top: 0;
  }*/
}
</style>
@endsection
@section('body')


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
        @if(isset($complete_invoice)) {{-- completing invoice --}}
        <a href="{{route('show.pending',$repo_id)}}" class="btn btn-danger">لا</a>
        <a id="print" onclick="window.print();" href="{{route('show.pending',$repo_id)}}" class="btn btn-primary">نعم</a>
        @else {{-- sell invoice for first time --}}
        <a href="{{route('create.special.invoice',$repo_id)}}" class="btn btn-danger">لا</a>
        <a id="print" onclick="window.print();" href="{{route('create.special.invoice',$repo_id)}}" class="btn btn-primary">نعم</a>
        @endif
      </div>
    </div>
  </div>
</div>
   </div>
    
                      <div id="print-content" class="table-responsive">
                        <div style="display: flex;">
                          @if($repository->logo)
                          <img src="{{asset('public/storage/'.$repository->logo)}}" width="50px" height="50px" id="logorep">
                          @endif
                          <div style="display: flex; justify-content: center;align-items: center; margin-right: 10px;">
                          <h4>  {{$repository->name}}</h4>
                          </div>
                          </div>
                        <div style="display: flex; justify-content: space-between">
                          <h4>رقم الفاتورة {{$invoice->code}}</h4>
                          <h4>التاريخ {{$date}}</h4>
                          <h4>الرقم الضريبي {{$invoice->tax_code}}</h4>
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
                            @if(isset($complete_invoice))
                            <th>
                              الواجب تسليمها 
                            </th>
                            @endif
                            <th id="del">
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
                                {{--
                                <td style="display: none;">
                                  <input type="hidden"  name="cost_price[]" value="{{$records[$i]['cost_price']}}" class="form-control blank" readonly>
                                </td>
                                --}}
                                <td>
                                  <input type="number"   name="price[]" value="{{$records[$i]['price']}}" class="form-control price blank" readonly>
                                </td>
                                <td>
                                  <input type="number" name="quantity[]" value="{{$records[$i]['quantity']}}" class="form-control quantity" readonly>
                              </td>
                              @if(isset($complete_invoice))
                              <td>
                                <input type="number" value="{{$records[$i]['must_del']}}" class="form-control" readonly>
                            </td>
                              @endif
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
                   @if(isset($sum))
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
                  {{--@if($repository->setting->discount_by_percent == true)
                   <div style="display: flex;">
                     %<input type="number" value="{{$discount}}" class="form-control" readonly>
                    </div>
                  @endif
                  @if($repository->setting->discount_by_value == true)
                  <div style="display: flex;">
                    <input type="number" value="{{$discount_by_value}}" class="form-control" readonly>
                  </div>
                  @endif 
                  @if($repository->setting->discount_by_value == false && $repository->setting->discount_by_percent == false)
                  <div style="display: flex;">
                    <input type="number" value="0" class="form-control" readonly>
                  </div>
                  @endif--}}
                  <input type="number" value="{{$discount}}" step="0.01" class="form-control" readonly>
               </div>
                   </div>
                   @endif
                   @if(!isset($complete_invoice))
                 <div>
                   <h3>
                     المبلغ الإجمالي 
                   </h3>  
                   <input type="number" name="total_price" id="final_total_price" class="form-control" value="{{$total_price}}" readonly>
                 </div>
                 @else {{-- complete invoice --}}
                 <div style="display: flex; justify-content: space-between">
                   <div>
                  <h3>
                    المبلغ الإجمالي 
                  </h3>  
                  {{--<h1 id="total_price">{{$invoice_total_price}}</h1>--}}
                  <input type="number" name="total_price" id="final_total_price" class="form-control" value="{{$total_price}}" readonly>
                   </div>
                   <div>
                    <h3>
                       المدفوع سابقا 
                    </h3>  
                    <input type="number" class="form-control" value="{{$total_price-$extra_price}}" readonly>
                   </div>
                   <div>
                    <h3>
                       المدفوع الآن 
                    </h3>  
                    <input type="number" value="{{$extra_price}}" class="form-control" readonly>
                   </div>
                </div>
                 @endif
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

                    @if(isset($remaining_amount))
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
            @endfor
          </div>
        </div>
        <hr>
        @endif
        @endif
        <div style="display: flex; justify-content: space-between">
          <h4>العميل {{$customer->name}}</h4>
          <h4>جوال العميل {{$customer->phone}}</h4>
        </div>
        <div style="display: flex; justify-content: space-between">
          <h4>موظف البيع {{$employee->name}}</h4>
        </div>
        {{--@if(!isset($complete_invoice))--}}
        @if($note)
        <div>
          <h4>{{$note}}</h4>
        </div>
        @endif
        {{--@endif--}}
        @if($repository->note)
        <div>
          <h4>{{$repository->note}}</h4>
        </div>
        @endif

        

 
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