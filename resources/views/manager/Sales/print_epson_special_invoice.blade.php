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
    .table-c td {
            padding: 10px;
        }
    .table-c th {
            padding: 10px 0 10px 10px;
        }
    .big-padding{
      padding: 10px 0 10px 30px !important;
    }
    @media print{
      .modal{
        display: none;
      }
    }
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
            <th>Barcode</th>
            <th class="big-padding">الاسم</th>
            <th>السعر</th>
            <th>الكمية</th>
            @if(isset($complete_invoice))
            <th> الواجب تسليمها </th>
            @endif
            <th>تم تسليمها </th> 
          </thead>
            @for($i=1;$i<$num;$i++)
            <tr>
                <td>
                    {{$records[$i]['barcode']}}
                </td>
                <td class="big-padding">  {{-- في الطباعة تم الطلب بعرض الاسم بالعربية فقط دوما --}}
                  {{$records[$i]['name_ar']}}
                </td>
                <td>
                    {{$records[$i]['price']}}
                </td>
                <td>
                    {{$records[$i]['quantity']}}
                </td>
                @if(isset($complete_invoice))
                <td>
                    {{$records[$i]['must_del']}}
                </td>
                @endif
                <td>
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
            @if(isset($remaining_amount))
            <p> المبلغ المتبقي للدفع
                {{$remaining_amount}}
            </p>
            @endif
        
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
      <h4>
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
      <input type="hidden" value="{{$repository->id}}" id="repo_id">
      @if(isset($complete_invoice)) {{-- completing invoice --}}
      <input type="hidden" value="true" id="is-completing">
      @else
      <input type="hidden" value="false" id="is-completing">
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
          var repo_id = $('#repo_id').val();
          var is_completing = $('#is-completing').val();
          result = confirm('تم البيع بنجاح هل تريد طباعة الفاتورة');
          if(result == true){
              if(is_completing == 'true'){
                  window.print();
                  window.onafterprint = function(){
                  window.location.href = "/show/pending/invoices/"+repo_id;
                  }
              }
              else{
                  window.print();
                  window.onafterprint = function(){
                  window.location.href = "/create/special/invoice/form/"+repo_id;
                  }
              }
          }
          else{
            if(is_completing == 'true')
               window.location.href = "/show/pending/invoices/"+repo_id;
            else
               window.location.href = "/create/special/invoice/form/"+repo_id;
          }
        }
      </script>
   </body>
</html>