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
    .p-inline{
        display: inline;
        padding : 10px;
    }
    .table-c,.table-c td,.table-c th,.table-c tr{
      border: 1px solid black;
    }
    .table-c td {
            padding: 10px;
        }
    .table-c th {
            padding: 10px 0 10px 10px;
        }
    /*.big-padding{
      padding: 10px 0 10px 30px !important;
    }*/
    </style>
    <body>
      @if($repository->logo)
    <img src="{{asset('public/storage/'.$repository->logo)}}" width="50px" height="50px" id="logorep">
    @endif
    <h2>{{$repository->name}}</h2>
    <h4>رقم الفاتورة {{$invoice->code}}</h4>
    <h4>التاريخ {{$invoice->created_at}}</h4>
    <h4>الرقم الضريبي {{$repository->tax_code}}</h4>
      <div class="bordred">
        <table class="table-c"> 
          <thead class="head">
            <th style="width: 100px">Barcode</th>
            <th style="width: 250px" class="big-padding">الاسم</th> 
            <th style="width: 30px">السعر</th>
            <th style="width: 30px">الكمية</th>
            <th style="width: 30px">تم تسليمها </th> 
          </thead>
          <?php $records = unserialize($invoice->details) ?>
            @for($i=1;$i<count($records);$i++)
            <tr>
                <td style="width: 100px">
                    <input type="hidden" value="{{count($records)}}" id="num">
                    {{$records[$i]['barcode']}}
                </td>
                <td style="width: 250px" class="big-padding">  {{-- في الطباعة تم الطلب بعرض الاسم بالعربية فقط دوما --}}
                  {{$records[$i]['name_ar']}}
                </td>
                <td style="display: none;">
                  {{$records[$i]['cost_price']}}
                </td>
                <td style="width: 30px">
                  <p id="price{{$i}}">
                    {{$records[$i]['price']}}
                  </p>
                </td>
                <td style="width: 30px">
                  <p id="quantity{{$i}}">
                    {{$records[$i]['quantity']}}
                  </p>
                </td>
              <td style="width: 30px">
                  @if($records[$i]['delivered'] != 0)
                  نعم
                  @else
                  لا
                  @endif
              </td>
          </tr>
          @endfor
        </table>
        </div>
        <br>
        <p>
        <p class="p-inline"> المجموع
              <p id="total_price" class="p-inline">
              </p> </p>
              <p class="p-inline">   الضريبة
              {{$invoice->tax}}</p>
              <p class="p-inline">
           الحسم
              {{$invoice->discount}}
              </p>
        </p>
              <p>
              <p class="p-inline">
            المبلغ الإجمالي
            
              <p>{{$invoice->total_price}}</p>
              </p>
              </p>
              <p>
              <p class="p-inline">
            الدفع كاش
            
              {{$invoice->cash_amount}}
              <p class="p-inline">
            الدفع بالبطاقة
            
              {{$invoice->card_amount}}
              </p>
              <p class="p-inline">
            STC-pay
            
              {{$invoice->stc_amount}}
              </p>
              </p>
            
            <?php $remaining_amount = $invoice->total_price - ($invoice->cash_amount+$invoice->card_amount+$invoice->stc_amount) ?>
          {{--  <th>المبلغ المتبقي للدفع</th>
            <th class="text-center">
              <p>{{$remaining_amount}}</p>
            </th>  --}}
     <h4>المبلغ المتبقي للدفع</h4>
              <h4>{{$remaining_amount}}</h4>

      @if($repository->setting->print_prescription == true)
      @if(isset($recipe) && $recipe) 
      @for($i=0;$i<count($recipe);$i++)
      <h4>  الوصفة الطبية  </h4>
              @if(array_key_exists('name', $recipe[$i]))
                {{$recipe[$i]['name']}}
              @endif
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
          @if(floatval($recipe[$i]['sph_r']) > 0)
          +{{$recipe[$i]['sph_r']}}
          @else
          {{$recipe[$i]['sph_r']}}
          @endif
        </th>
        <th class="text-center">
          @if(floatval($recipe[$i]['cyl_r']) > 0)
          +{{$recipe[$i]['cyl_r']}}
          @else
          {{$recipe[$i]['cyl_r']}}
          @endif
        </th>
        <th class="text-center">{{$recipe[$i]['axis_r']}}</th>
        <th class="text-center">
          @if(floatval($recipe[$i]['add_r']) > 0)
          +{{$recipe[$i]['add_r']}}
          @else
          {{$recipe[$i]['add_r']}}
          @endif
        </th>
        </tr>
        <tr>
          <th>LEFT</th>
          <th class="text-center">
            @if(floatval($recipe[$i]['sph_l']) > 0)
            +{{$recipe[$i]['sph_l']}}
            @else
            {{$recipe[$i]['sph_l']}}
            @endif
          </th>
          <th class="text-center">
            @if(floatval($recipe[$i]['cyl_l']) > 0)
            +{{$recipe[$i]['cyl_l']}}
            @else
            {{$recipe[$i]['cyl_l']}}
            @endif
          </th>
          <th class="text-center">{{$recipe[$i]['axis_l']}}</th>
          <th class="text-center">
            @if(floatval($recipe[$i]['add_l']) > 0)
            +{{$recipe[$i]['add_l']}}
            @else
            {{$recipe[$i]['add_l']}}
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
            {{$recipe[$i]['ipd']}}
          </th>
          <td>
          </td>
          <tr>
      </table>
      </div>
      @endfor
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
      {{QrCode::encoding('UTF-8')->size(150)->generate('[اسم المورد : '.$repository->name.'] , [الطابع الزمني : '.$invoice->created_at.'] , [الرقم الضريبي : '.$repository->tax_code.'] [الضريبة : '.$invoice->tax.'] , [اجمالي الفاتورة : '.$invoice->total_price.']')}}

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