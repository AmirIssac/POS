@extends('layouts.main')
@section('body')
<style>
  .card-header a{
    color:white !important;
  }
</style>
     <div class="main-panel">
      
       <div class="content">
        <div class="col-md-4">
          </div>
            <div class="container-fluid">
              <div class="row">
               
                <div class="col-lg-3 col-md-6 col-sm-6">
                 <a href="{{route('products.show')}}">
                  <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                      <div class="card-icon">
                      <i class="material-icons">add_circle_outline</i>
                      </div>
                      <p class="card-category">أنواع المنتجات</p>
                      <h6 class="card-title">عرض واضافة</h6>
                    </div>
                    <div class="card-footer">
                      <div class="stats">
                        <i class="material-icons">update</i>
                      </div>
                    </div>
                  </div>
                 </a>
                </div>
              </div>
            </div>
       </div>
     </div>
     @endsection
