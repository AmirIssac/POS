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
    .modal{
      color: red;
      font-size: 25px;
    }
    @media print{
      .modal{
        display: none;
      }
    }
    </style>
    <body>
      <div class="modal">
        هل تريد طباعة الفاتورة ؟
      </div>
      <div class="modal">
        @if(isset($complete_invoice)) {{-- completing invoice --}}
        <a href="{{route('show.pending',$repo_id)}}">لا</a>
        <a id="print" onclick="window.print();" href="{{route('show.pending',$repo_id)}}">نعم</a>
        @else {{-- sell invoice for first time --}}
        <a href="{{route('create.special.invoice',$repo_id)}}">لا</a>
        <a id="print" onclick="window.print();" href="{{route('create.special.invoice',$repo_id)}}">نعم</a>
        @endif
      </div>
    </div>
    <h2 class="text-center">متجر {{$repository->name}}</h2>
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
            @if(isset($complete_invoice))
            <th class="text-center"> الواجب تسليمها </th>
            @endif
            <th class="text-center">تم تسليمها </th> 
          </thead>
            @for($i=1;$i<$num;$i++)
            <tr>
                <td class="text-center">
                    {{$records[$i]['barcode']}}
                </td>
                <td class="text-center">  {{-- في الطباعة تم الطلب بعرض الاسم بالعربية فقط دوما --}}
                  {{$records[$i]['name_ar']}}
                </td>
                <td class="text-center">
                    {{$records[$i]['price']}}
                </td>
                <td class="text-center">
                    {{$records[$i]['quantity']}}
                </td>
                @if(isset($complete_invoice))
                <td class="text-center">
                    {{$records[$i]['must_del']}}
                </td>
                @endif
                <td class="text-center">
                    {{$records[$i]['del']}}
                </td>
          </tr>
          @endfor
        </table>
        </div>
            @if(isset($sum))
            <p class="p-inline">المجموع
                {{$sum}}
            </p>
            <p class="p-inline">الضريبة
                {{$tax}}
            <p class="p-inline">الحسم
                {{$discount}}
            </p>
            @endif
            @if(!isset($complete_invoice))
            <p>
            <p class="p-inline">المبلغ الإجمالي
                {{$total_price}}
            </p>
            </p>
            @else
            <p>
            <p class="p-inline">المبلغ الإجمالي
                {{$total_price}}
            </p>
            <p class="p-inline">المدفوع سابقا
                {{$total_price-$extra_price}}
            </p>
            <p class="p-inline">المدفوع الآن
                {{$extra_price}}
            </p>
            </p>
            @endif
            <p>
            <p class="p-inline">الدفع كاش
                {{$cash}}
            </p>
            <p class="p-inline">الدفع بالبطاقة
                {{$card}}
            </p>
            <p class="p-inline">stc-pay
                {{$stc}}
            </p>
            </p>
            @if(isset($remaining_amount) && $remaining_amount > 0)
            <p> المبلغ المتبقي للدفع
                {{$remaining_amount}}
            </p>
            @endif
        
      @if($repository->setting->print_prescription == true)
      @if(isset($recipe) && $is_recipe_null == false)
      <h4>  الوصفة الطبية  </h4>
              @if(array_key_exists('name', $recipe))
                {{$recipe['name']}}
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
        <th class="text-center">{{$recipe['sph_r']}}</th>
        <th class="text-center">{{$recipe['cyl_r']}}</th>
        <th class="text-center">{{$recipe['axis_r']}}</th>
        <th class="text-center">{{$recipe['add_r']}}</th>
        </tr>
        <tr>
          <th>LEFT</th>
          <th class="text-center">{{$recipe['sph_l']}}</th>
          <th class="text-center">{{$recipe['cyl_l']}}</th>
          <th class="text-center">{{$recipe['axis_l']}}</th>
          <th class="text-center">{{$recipe['add_l']}}</th>
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
        العميل {{$customer->name}}
      </h4>
      <h4>جوال العميل {{$customer->phone}}</h4>
      <h4>موظف البيع {{$employee->name}}</h4>
      @if($note)
      <div>
        <h4>{{$note}}</h4>
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
         // window.print();
        }
      </script>
   </body>
</html>