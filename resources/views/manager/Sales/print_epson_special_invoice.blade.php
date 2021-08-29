<!DOCTYPE html>
 <html  lang="ar" dir="ltr">
    <head>
    	<!-- Metas -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="keywords" content="amir" />
        <meta name="description" content="amir" />
        <meta name="author" content="amir" />
 <!-- CSS Files -->
 <link href="{{asset('public/css/material-dashboard.min.css?v=2.1.2')}}" rel="stylesheet" />
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
      font-size: 25px;
    }
    #header{
      display: flex;
    }
        .table-c td {
            padding: 10px;
        }
        .table-c th {
            padding: 10px;
        }

    @media print{
      #mod{
        display: none;
      }
      *{
        font-weight: bold;
      }
    }
    </style>
    <body>
   <!-- Modal -->
   <div id="mod" dir="rtl">
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
       @if($repository->logo)
    <img src="{{asset('public/storage/'.$repository->logo)}}" width="50px" height="50px" id="logorep">
    @endif
    <h4 class="text-start">متجر {{$repository->name}}</h4>
    <h4>رقم الفاتورة {{$invoice->code}}</h4>
    <h4>التاريخ {{$invoice->created_at}}</h4>
    <h4>الرقم الضريبي {{$repository->tax_code}}</h4>
      <div class="bordred">
        <table class="table-c">
          <thead class="head">
            <th>Barcode</th>
            <th>الاسم</th>
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
                <td>  {{-- في الطباعة تم الطلب بعرض الاسم بالعربية فقط دوما --}}
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
      <!--   Core JS Files   -->
  
  <script src="{{asset('public/js/core/jquery.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('public/js/core/popper.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('public/js/core/bootstrap-material-design.min.js')}}" type="text/javascript"></script>
 
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
   </body>
</html>