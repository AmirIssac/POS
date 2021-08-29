@extends('layouts.main')
@section('links')
<style>
form i{
  float: left;
}
form #plus:hover{
  cursor: pointer;
}
form #tooltip:hover{
  cursor: default;
}
.measurements input{
  width: 45px;
  margin-top: 10px;
}
.displaynone{
  display: none;
}
.table-c {
            width:100%;
            height: 30px;
            /*table-layout: fixed;*/
        }
        .table-c td {
            border: 2px solid #9229ac;
            padding: 10px;
        }
</style>
@endsection
@section('body')
<div class="main-panel">
 
 <div class="content">
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container-fluid">
      <div class="row">
        <form method="POST" action="{{route('store.product')}}">
            @csrf
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__('repository.add_product_to_stock')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table-c">
                  <thead class="text-primary">
                    <th style="width: 10%">
                      Barcode  
                    </th>
                    <th style="width: 20%">
                      {{__('repository.arabic_name')}}  
                    </th> 
                    <th style="width: 20%">
                      {{__('repository.english_name')}}
                    </th>
                    @if($repository->isSpecial())  {{-- محل خاص --}}
                    <th style="width: 10%">
                      {{__('repository.product_type')}}
                    </th>
                    <th style="width: 5%">
                      {{__('repository.accept_min')}}  
                    </th>
                    <th style="width: 10%">
                      {{__('repository.storing_method')}} 
                    </th>
                    @endif
                    <th style="width: 5%">
                      {{__('sales.quantity')}} 
                    </th>
                    <th style="width: 5%">
                      {{__('reports.cost_price')}}  
                    </th>
                    <th style="width: 5%">
                      {{__('sales.sell_price')}}  
                    </th>
                    <th style="width: 8%">   {{-- for future use to save every input details in table of repository inputs --}}
                      {{__('sales.total_price')}}  
                      <th  style="width: 2%">
                        <i id="tooltip" class="material-icons" data-toggle="popover" data-trigger="hover" title=" {{__('sales.total_price')}} =" data-content=" {{__('reports.cost_price')}} X {{__('sales.quantity')}}">live_help</i>
                      </th>
                    </th>
                  </thead>
                  <tbody>
                     <div id="record">
                      <tr>
                        <td style="width: 10%">
                            <input type="text" name="barcode[]" class="form-control barcode" placeholder=" {{__('sales.scanner_input')}} " id="autofocus"  required>
                        </td>
                        <td style="width: 20%">
                          <input type="text" name="name[]" class="form-control" placeholder="{{__('repository.arabic_name')}}" id="ar0" required>
                      </td>
                      <td style="width: 20%">
                        <input type="text" name="details[]" class="form-control" placeholder="{{__('repository.english_name')}}">
                    </td>
                    @if($repository->isSpecial())  {{-- محل خاص --}}
                    <td style="width: 10%">
                      @if(LaravelLocalization::getCurrentLocale() == 'ar')
                      <select id="sel0" name="type[]" class="form-control sel">
                        @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name_ar}}</option>
                        @endforeach
                      </select>
                      @endif
                      @if(LaravelLocalization::getCurrentLocale() == 'en')
                      <select id="sel0" name="type[]" class="form-control sel">
                        @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name_en}}</option>
                        @endforeach
                      </select>
                      @endif
                      <span class="measurements displaynone" id="meas0">
                      <input type="number" id="sph0" min="-20.00" max="20.00" step="0.25" name="sph[]" placeholder="sph">
                      <input type="number" id="cyl0" min="-20.00" max="20.00" step="0.25" name="cyl[]" placeholder="cyl">
                      <input type="number" id="add0" min="0.00" max="20.00" step="0.25" name="add[]" placeholder="add">
                      <input type="text" id="ty0" name="typee[]" placeholder="type">
                      </span>
                  </td>
                  <td style="width: 10%">
                    <input type="checkbox" name="acceptmin[]" class="form-control" value="0" checked>
                  </td>
                  @endif
                  <td style="width: 10%">
                    <select id="stored0" name="stored[]" class="form-control">
                      <option value="yes">{{__('repository.available_in_stock')}}</option>
                      <option value="no">{{__('repository.unavailable_in_stock')}}</option>
                    </select>
                  </td>
                    <td style="width: 5%">
                      <input id="quantity0" type="number" name="quantity[]" min="0" class="form-control" value="1" placeholder="{{__('sales.quantity')}}" required>
                  </td>
                      <td style="width: 5%">
                        <input id="cost_price0"  type="number" name="cost_price[]" step="0.01" class="form-control" value="0" placeholder="{{__('reports.cost_price')}}" required>
                      </td>
                        <td style="width: 5%">
                            <input id="price0"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="{{__('sales.price')}}" required>
                        </td>
                        <td style="width: 5%">
                            <input id="total_price0" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="{{__('sales.total_price')}}" required>
                            <input type="hidden" name="repo_id" value="{{$repository->id}}">
                        </td>
                        
                            
                        
                      </tr>
                      @for ($count=1;$count<=10;$count++)
                      <tr id="record{{$count}}" class="displaynone">
                      <td>
                        <input type="text" name="barcode[]" class="form-control barcode" placeholder=" {{__('sales.scanner_input')}}"  id="bar{{$count}}">
                    </td>
                    <td>
                      <input type="text" name="name[]" class="form-control" placeholder="{{__('repository.arabic_name')}}" id="ar{{$count}}">
                  </td>
                  <td>
                    <input type="text" name="details[]" class="form-control" placeholder="{{__('repository.english_name')}}">
                </td>
                @if($repository->isSpecial())  {{-- محل خاص --}}
                <td>
                  @if(LaravelLocalization::getCurrentLocale() == 'ar')
                  <select id="sel{{$count}}" name="type[]" class="form-control sel">
                    @foreach($types as $type)
                    <option value="{{$type->id}}">{{$type->name_ar}}</option>
                    @endforeach
                  </select>
                  @endif
                 @if(LaravelLocalization::getCurrentLocale() == 'en')
                  <select id="sel{{$count}}" name="type[]" class="form-control sel">
                    @foreach($types as $type)
                    <option value="{{$type->id}}">{{$type->name_en}}</option>
                    @endforeach
                  </select>
                  @endif
                  <span class="measurements displaynone" id="meas{{$count}}">
                  <input type="number" id="sph{{$count}}" min="-20.00" max="20.00" step="0.25" name="sph[]" placeholder="sph">
                  <input type="number" id="cyl{{$count}}" min="-20.00" max="20.00" step="0.25" name="cyl[]" placeholder="cyl">
                  <input type="number" id="add{{$count}}" min="0.00" max="20.00" step="0.25" name="add[]" placeholder="add">
                  <input type="text" id="ty{{$count}}" name="typee[]" placeholder="type">
                  </span>
              </td>
              <td>
                <input type="checkbox" name="acceptmin[]" class="form-control" value="{{$count}}" checked>
              </td>
              @endif
              <td>
                <select id="stored{{$count}}" name="stored[]" class="form-control">
                  <option value="yes">{{__('repository.available_in_stock')}}</option>
                  <option value="no">{{__('repository.unavailable_in_stock')}}</option>
                </select>
              </td>
                <td>
                  <input id="quantity{{$count}}" type="number" name="quantity[]" min="0" class="form-control" value="1" placeholder="{{__('sales.quantity')}}">
              </td>
                  <td>
                    <input id="cost_price{{$count}}"  type="number" name="cost_price[]" step="0.01" class="form-control" value="0" placeholder="{{__('reports.cost_price')}}">
                  </td>
                    <td>
                        <input id="price{{$count}}"  type="number" name="price[]" step="0.01" class="form-control target" value="0" placeholder="{{__('sales.price')}}">
                    </td>
                    <td>
                        <input id="total_price{{$count}}" type="number" name="total_price[]" step="0.01" class="form-control" placeholder="{{__('sales.total_price')}}">
                    </td>
                  </tr>
                      @endfor
                     </div>
                  </tbody>
                </table>
                <button  type="submit" class="btn btn-primary"> {{__('buttons.add')}} </button>
                <i id="plus" class="material-icons">add_circle</i>
            </div>
        </div>
      </div>
    </div>
</form>
  </div>
</div>
</div>
@endsection
@section('scripts')
<script>
   /* $("input[name=price]").keyup(function(){
    $('input[name=total_price]').val($('input[name=price]').val()*$('input[name=quantity]').val());
    });
    $("input[name=quantity]").keyup(function(){
    $('input[name=total_price]').val($('input[name=price]').val()*$('input[name=quantity]').val());
    });
  */
</script>
<script>
  var intervalId = window.setInterval(function(){
  for(var i=0;i<count;i++){
      $('#total_price'+i+'').val($('#cost_price'+i+'').val()*$('#quantity'+i+'').val());
  }
}, 500);
</script>
{{--<script>

  // create new input record after click + button and focus into scanner input
  //$('.target').last().focus(function() {
    var count = 1;
    $('form #plus').on('click',function(){
    $('#myTable tr:last').after('<tr><td><input type="text" name="barcode[]" id="bar'+count+'" class="form-control" placeholder="مدخل خاص ب scanner" required></td> <td><input type="text" name="name[]" class="form-control" placeholder="الاسم بالعربية" required></td><td><input type="text" name="details[]" class="form-control" placeholder="الاسم بالانجليزية"></td>@if($repository->isSpecial())<td><select id="sel'+count+'" name="type[]" class="form-control sel">@foreach($repository->types as $type)<option value="{{$type->id}}">{{$type->name}}</option>@endforeach</select><span class="measurements displaynone" id="meas'+count+'"><input type="number" name="sph[]" placeholder="sph"><input type="number" name="cyl[]" placeholder="cyl"> <input type="number" name="add[]" placeholder="add"><input type="text" name="type[]" placeholder="type"></span></td><td><input type="checkbox" name="acceptmin[]" class="form-control" value="'+count+'" checked></td>@endif<td><input type="number" id="quantity'+count+'" name="quantity[]" min="0" value="1" class="form-control" placeholder="الكمية" required></td><td><input id="cost_price'+count+'"  type="number" name="cost_price[]" step="0.01" class="form-control" value="0" placeholder="سعر التكلفة" required></td><td><input  type="number" id="price'+count+'" name="price[]" step="0.01" class="form-control target" value="0" placeholder="السعر" required></td><td><input type="number" id="total_price'+count+'" name="total_price[]" step="0.01" class="form-control" placeholder="المبلغ الإجمالي"><input type="hidden" name="repo_id" value="{{$repository->id}}"></td></tr>');
    $('#myTable').find('#bar'+count+'').focus();   // we use find to select new added element
    count = count +1;
    //$('.barcode').last().focus();
  });
</script>--}}
<script>
    var count = 1;
    $('form #plus').on('click',function(){
      $('#record'+count).removeClass('displaynone');
      $('#bar'+count).focus();
      $('#bar'+count).prop('required',true);
      $('#ar'+count).prop('required',true);
      $('#quantity'+count).prop('required',true);
      $('#cost_price'+count).prop('required',true);
      $('#price'+count).prop('required',true);
      $('#total_price'+count).prop('required',true);
      count = count + 1;
    });
</script>
<script>
  window.onload=function(){
    $('#autofocus').focus();
    $(function () {
  $('[data-toggle="popover"]').popover()
  });
  };
  </script>
  <script>
    $('.sel').on('change',function(){
      var id = $(this).attr("id");  // extract id
      var gold =  id.slice(3);   // remove sel from id to take just the number    
      var type_id = $('#sel'+gold).val();
      $.ajax({
           type: "get",
           url: '/ajax/get/typeName/'+type_id,
           //dataType: 'json',
          success: function(data){    // data is the response come from controller
              //alert(data.name);
              var string = data.name_ar;
              var substring = 'عدس';
              if(string.includes(substring)){   // now we display the measurements fields
              //alert(gold);
                $('#meas'+gold).removeClass('displaynone');
              }
              else{
                $('#meas'+gold).addClass('displaynone');
                // make the measurements inputs null
                $('#sph'+gold).val(null);
                $('#cyl'+gold).val(null);
                $('#add'+gold).val(null);
                $('#ty'+gold).val(null);
              }
          }
        });
      });
     
  </script>
@endsection