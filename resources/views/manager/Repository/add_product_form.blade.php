@extends('layouts.main')
@section('body')
<div class="main-panel">
 
 <div class="content">
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
    <div class="container-fluid">
      <div class="row">
        <form method="POST" action="{{route('store.product')}}">
            @csrf
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 style="float: right" class="card-title ">اضافة منتج للمخزون</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class="text-primary">
                    <th>
                      تفاصيل المنتج 
                    </th>
                    <th>
                      السعر 
                    </th>
                    <th>
                      الكمية 
                    </th>
                    <th>   {{-- for future use to save every input details in table of repository inputs --}}
                      المبلغ الإجمالي 
                    </th>
                  </thead>
                  <tbody>
                     
                      <tr>
                        <td>
                            <input type="text" name="details" class="form-control" placeholder="مدخل خاص ب scanner">
                        </td>
                        <td>
                            <input type="number" name="price" step="0.01" class="form-control" value="0.00" placeholder="السعر">
                        </td>
                        <td>
                            <input type="number" name="quantity" class="form-control" placeholder="الكمية">
                        </td>
                        <td>
                            <input type="number" name="total_price" step="0.01" class="form-control" placeholder="المبلغ الإجمالي">
                            <input type="hidden" name="repo_id" value="{{$repository->id}}">
                        </td>
                        <td>
                            <button  type="submit" class="btn btn-primary"> إضافة </button>
                        </td>
                      </tr>
                     
                  </tbody>
                </table>
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
    $("input[name=price]").keyup(function(){
    $('input[name=total_price]').val($('input[name=price]').val()*$('input[name=quantity]').val());
    });
    $("input[name=quantity]").keyup(function(){
    $('input[name=total_price]').val($('input[name=price]').val()*$('input[name=quantity]').val());
    });
</script>
@endsection