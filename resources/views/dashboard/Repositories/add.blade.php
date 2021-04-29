@extends('layouts.main')
@section('body')
<div class="main-panel">
<div class="content">
    <div class="container-fluid">
      <div class="row">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
        @endif
        <div class="col-md-12">
            <form action="{{route('repositories.store')}}" method="POST">
                @csrf
                {{-- first card --}}
             <div class="card">
              <div class="card-header card-header-primary">
                  <h4 class="card-title float-right"> بيانات المخزن</h4>
                   </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table">
                                  <thead class="text-primary">
                                <th>
                                اسم المخزن 
                                </th>
                                <th>
                                العنوان 
                                </th>
                                 </thead>
                                <tbody>
                                <tr>
                                <td>
                                    <input type="text" name="repositoryName" class="form-control" placeholder="اكتب الاسم هنا">
                                </td>
                                <td>
                                    <input type="text" name="address" class="form-control" placeholder="اكتب العنوان هنا">
                                </td>
                                </tr>
                            </tbody>
                            </table>
                            </div>
                            </div>
                        </div>
                  {{-- second card --}}
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title float-right">بيانات المالك</h4>
                        </div>
                         <div class="card-body">
                          <div class="table-responsive">
                            <table class="table">
                              <thead class=" text-primary">
                                <th>
                                  الاسم  
                                </th>
                              <th>
                                الايميل 
                              </th>
                              <th>
                                كلمة المرور 
                              </th>
                              <th>
                                رقم الجوال 
                              </th>
                               </thead>
                                 <tbody>
                                 <tr>
                                   <td>
                                       <input type="text" name="ownerName" class="form-control" placeholder="الاسم ">
                                   </td>
                                   <td>
                                    <input type="email" name="owneremail" class="form-control" placeholder="الايميل">
                                  </td>
                                  <td>
                                    <input type="password" name="ownerpassword" class="form-control" placeholder="كلمة المرور">
                                  </td>
                                  <td>
                                    <input type="text" name="ownerphone" class="form-control" placeholder="رقم الجوال">
                                     </td>
                                  </tr>
                              </tbody>
                            </table>
                            
                              </div>
                            </div>
                          </div>
                          <button class="btn btn-success"> حفظ </button>
                 </form>
                </div>
              </div>
            </div>
        </div>
@endsection