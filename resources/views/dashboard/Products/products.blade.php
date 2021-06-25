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
        <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title">اضافة نوع جديد</h4>
                        </div>
                        
                         <div class="card-body">
                          <div class="table-responsive">
                            <form action="{{route('store.type')}}" method="POST">
                                @csrf
                            <table class="table">
                              <thead class=" text-primary">
                                <th>
                                  الاسم بالعربية  
                                </th>
                              <th>
                                الاسم بالإنجليزية 
                              </th>
                               </thead>
                                 <tbody>
                                 <tr>
                                   <td>
                                       <input type="text" name="name_ar" class="form-control" placeholder="الاسم بالعربية" required>
                                   </td>
                                   <td>
                                    <input type="text" name="name_en" class="form-control" placeholder="الاسم بالإنجليزية" required>
                                  </td>
                                  <td>
                                      <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                                  </td>
                                  </tr>              
                              </tbody>
                            </table>
                            </form>
                            <table class="table">
                                <thead class=" text-primary">
                                  <th>
                                    أنواع المنتجات  
                                  </th>
                                 </thead>
                                   <tbody>
                                       @foreach ($types as $type)
                                           <tr>
                                               <td>
                                                   @if(LaravelLocalization::getCurrentLocale() == 'ar')
                                                   {{$type->name_ar}}
                                                   @else
                                                   {{$type->name_en}}
                                                   @endif
                                               </td>
                                           </tr>
                                       @endforeach
                                   </tbody>
                            </table>

                              </div>
                            </div>
                          </div>
                </div>
              </div>
    </div>
</div>
</div>
@endsection