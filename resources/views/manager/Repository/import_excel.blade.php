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
  @if(isset($errors) && $errors->any())
  <div class="alert alert-danger alert-block">
    @foreach($errors->all() as $error)
    {{$error}}
    @endforeach
  </div>
  @endif
  @if(session()->has('failures'))
    <table class="table table-danger">
      <tr>
        <th>السطر</th>
        <th>الواصفة</th>
        <th>الخطأ</th>
        <th>القيمة</th>
      </tr>
      @foreach (session()->get('failure') as $validation )
        <tr>
          <td>{{$validation->row()}}</td>
          <td>{{$validation->attribute()}}</td>
          <td>
            <ul>
              @foreach ($validation->errors() as $e )
                <li> {{$e}} </li>
              @endforeach
            </ul>
          </td>
          <td>{{$validation->values()[$validation->attribute()]}}</td>
        </tr>
      @endforeach
    </table>
  @endif 
  <form method="POST" action="{{route('import.excel',$repository->id)}}" enctype="multipart/form-data">
    @csrf
    <div class="container-fluid">
      <div class="row">
        
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title "> استيراد مخزون عن طريق excel sheet</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="myTable" class="table">
                  <thead class="text-primary">
                    <th>
                      الملف  
                    </th>
                  </thead>
                  <tbody>
                     <tr>
                         <td>
                             <input type="file" name="excel">
                         </td>
                         <td>
                            <button type="submit" class="btn btn-primary"> تأكيد </button>
                        </td>
                     </tr>
                  </tbody>
                </table>
              </div>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-warning">
          <h4 class="card-title "> معلومات هامة قبل الاستيراد </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
  <div class="table-responsive">
    <table id="myTable" class="table">

      <tbody>
         <tr>
             <td>
               أن يكون الملف لا يحوي ترويسات أي يحوي المعطيات المراد إدخالها فقط
             </td>
         </tr>
         <tr>
           <td>
            أن تكون الأعمدة في الملف بالترتيب التالي :
           </td>
         </tr>
         <tr>
           <td>
             العامود الأول يحوي رمز الباركود
           </td>
         </tr>
         <tr>
          <td>
            العامود الثاني يحوي  اسم المنتج
          </td>
        </tr>
        <tr>
          <td>
            العامود الثالث يحوي  معلومات المنتج
          </td>
        </tr>
        <tr>
          <td>
            العامود الرابع يحوي  سعر المنتج
          </td>
        </tr>
        <tr>
          <td>
            العامود الخامس  يحوي الكمية  
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  </div>
        </div>
      </div>





</div>
</form>
  
</div>
@endsection



