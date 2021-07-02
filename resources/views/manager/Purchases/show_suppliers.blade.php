@extends('layouts.main')

@section('body')
<div class="main-panel">

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> الموردون </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                        الاسم
                    </th>
                    <th>
                      العنوان
                    </th>
                    <th>
                      رقم الجوال 
                     </th>
                     <th>
                      رقم الحساب 
                     </th>
                  </thead>
                  <tbody>
                    @foreach($suppliers as $supplier)
                    <tr>
                     <td>{{$supplier->name}}</td>
                     <td>{{$supplier->address}}</td>
                     <td>{{$supplier->phone}}</td>
                     <td>{{$supplier->account_num}}</td>
                     
                    </tr>
                    @endforeach
                    
                  </tbody>
                </table>
                {{ $suppliers->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection