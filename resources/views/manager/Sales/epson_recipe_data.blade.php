<!DOCTYPE html>
 <html dir="rtl">
    <head>
    	<!-- Metas -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="keywords" content="amir" />
        <meta name="description" content="amir" />
        <meta name="author" content="amir" />

        <!-- Title  -->
        <title>Rofood</title>
      
        
    </head>
    <style>
      input {
    border:none;
    background-image:none;
    background-color:transparent;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    width: 25px;
    }
    .bordered-table{
      border: 1px solid black;
    }
    .bordered-table td , .bordered-table th {
      border: 1px solid black;
    }
    </style>
    <body>
      @if($repository->logo)
    <img src="{{asset('public/storage/'.$repository->logo)}}" width="50px" height="50px" id="logorep">
    @endif
    <h2 class="text-center">{{$repository->name}}</h2>
    <h4 class="text-center">رقم الفاتورة {{$invoice->code}}</h4>
    <h4 class="text-center">التاريخ {{$invoice->created_at}}</h4>
    <h4 class="text-center">الرقم الضريبي {{$repository->tax_code}}</h4>
      <div class="bordred">
        <table>
          <thead class="head">
            <th>Barcode</th>
            <th class="text-center">الاسم</th>
            <th class="text-center">السعر</th>
            <th class="text-center">الكمية</th>
            <th class="text-center"> تم تسليمها</th>
          </thead>
          <?php $records = unserialize($invoice->details) ?>
            @for($i=1;$i<count($records);$i++)
            <tr>
                <td class="text-center">
                    <input type="hidden" value="{{count($records)}}" id="num">
                    {{$records[$i]['barcode']}}
                </td>
                <td class="text-center">  {{-- في الطباعة تم الطلب بعرض الاسم بالعربية فقط دوما --}}
                  {{$records[$i]['name_ar']}}
                </td>
                <td style="display: none;">
                  {{$records[$i]['cost_price']}}
                </td>
                <td class="text-center">
                  <p id="price{{$i}}">
                    {{$records[$i]['price']}}
                  </p>
                </td>
                <td class="text-center">
                  <p id="quantity{{$i}}">
                    {{$records[$i]['quantity']}}
                  </p>
                </td>
              <td class="text-center">
                  @if($records[$i]['delivered'] != 0)
                  نعم
                  @else
                  لا
                  @endif
              </td>
          </tr>
          @endfor
          <tfoot>
            <tr>
            <th>المجموع</th>
            <th class="text-center">
              <p id="total_price">
              </p>
            </th>
            <th>الضريبة</th>
            <th class="text-center">
              <p>{{$invoice->tax}}</p>
            </th>
            <th>الحسم</th>
            <th class="text-center">
              <p>{{$invoice->discount}}</p>
            </th>
            </tr>
            <tr>
            <th>المبلغ الإجمالي</th>
            <th class="text-center">
              <p>{{$invoice->total_price}}</p>
            </th>
            </tr>
            <th>الدفع كاش</th>
            <th class="text-center">
              <p>{{$invoice->cash_amount}}</p>
            </th>
            <th>الدفع بالبطاقة</th>
            <th class="text-center">
              <p>{{$invoice->card_amount}}</p>
            </th>
            <th>STC-pay</th>
            <th class="text-center">
              <p>{{$invoice->stc_amount}}</p>
            </th>
            <?php $remaining_amount = $invoice->total_price - ($invoice->cash_amount+$invoice->card_amount+$invoice->stc_amount) ?>
          {{--  <th>المبلغ المتبقي للدفع</th>
            <th class="text-center">
              <p>{{$remaining_amount}}</p>
            </th>  --}}
          </tfoot>
        </table>
      </div>
     <h4>المبلغ المتبقي للدفع</h4>
              <h4>{{$remaining_amount}}</h4>

      @if($repository->setting->print_prescription == true)
      @if(isset($recipe) && $is_recipe_null == false)
      <div class="bordred">
      <table class="bordered-table" dir="ltr">
        <thead>
          <th>EYE</th>
          <th class="text-center">SPH</th>
          <th class="text-center">CYL</th>
          <th class="text-center">Axis</th>
          <th class="text-center">ADD</th>
        </thead>
        <tr>
        <th>RIGHT</th>
        <th class="text-center">
          @if(floatval($recipe['sph_r']) > 0)
          +{{$recipe['sph_r']}}
          @else
          {{$recipe['sph_r']}}
          @endif
        </th>
        <th class="text-center">
          @if(floatval($recipe['cyl_r']) > 0)
          +{{$recipe['cyl_r']}}
          @else
          {{$recipe['cyl_r']}}
          @endif
        </th>
        <th class="text-center">{{$recipe['axis_r']}}</th>
        <th class="text-center">
          @if(floatval($recipe['add_r']) > 0)
          +{{$recipe['add_r']}}
          @else
          {{$recipe['add_r']}}
          @endif
        </th>
        </tr>
        <tr>
          <th>LEFT</th>
          <th class="text-center">
            @if(floatval($recipe['sph_l']) > 0)
            +{{$recipe['sph_l']}}
            @else
            {{$recipe['sph_l']}}
            @endif
          </th>
          <th class="text-center">
            @if(floatval($recipe['cyl_l']) > 0)
            +{{$recipe['cyl_l']}}
            @else
            {{$recipe['cyl_l']}}
            @endif
          </th>
          <th class="text-center">{{$recipe['axis_l']}}</th>
          <th class="text-center">
            @if(floatval($recipe['add_l']) > 0)
            +{{$recipe['add_l']}}
            @else
            {{$recipe['add_l']}}
            @endif
          </th>
          </tr>
          <td>
          </td>
          <td>
          </td>
          <th>
            IPD
          </th>
          <th>
            {{$recipe['ipd']}}
          </th>
          <td>
          </td>
          <tr>
      </table>
      </div>
      @endif
      @endif
      <h4 class="text-center">
        العميل {{$invoice->customer->name}}
      </h4>
      <h4>جوال العميل {{$invoice->phone}}</h4>
      <h4>موظف البيع {{$invoice->user->name}}</h4>
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
      <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
      <script>
        
        // to make sure the data is loading before print //
        window.onload = function() {
          var num = parseFloat($('#num').val()); // number of records
          var sum = 0;
          for(var i=1;i<num;i++){
            sum = sum + parseFloat($('#price'+i).text()) * parseFloat($('#quantity'+i).text());
          }
          $('#total_price').text(sum);
          window.print();
        }
      </script>
   </body>
</html>