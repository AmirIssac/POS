@extends('layouts.main')
@section('body')
<style>
  .card-header a{
    color:white !important;
  }
</style>
     <div class="main-panel">
      
       <div class="content">
        @if (session('editProductSuccess'))
        <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ session('editProductSuccess') }}</strong>
      </div>
      @endif
      @if (session('deleteProductSuccess'))
      <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
      <strong>{{ session('deleteProductSuccess') }}</strong>
    </div>
    @endif
    @if (session('fail'))
    <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ session('fail') }}</strong>
  </div>
  @endif
          
           <div class="col-md-4">
            <div class="card card-chart">
              <div class="card-header card-header-primary">
                <div class="ct-chart" id="dailySalesChart"></div>
              </div>
              <div class="card-body">
                <h4 class="card-title">{{__('repository.store')}}
                  @if(LaravelLocalization::getCurrentLocale() == 'ar')
                  {{$repository->name}}
                 @elseif(LaravelLocalization::getCurrentLocale() == 'en')
                  {{$repository->name_en}}
                  @else
                  {{$repository->name}}
                  @endif
                  /
                 {{$repository->address}}
                  </h4>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">access_time</i> معلومات  
                </div>
              </div>
            </div>
          </div>
 
            
            <div class="container-fluid">
            <div class="row">
              @can('ادخال بضاعة للمخزون')
              <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('add.product.form',$repository->id)}}">
                <div class="card card-stats">
                  <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">qr_code_scanner</i>
                    </div>
                    <p class="card-category">{{__('repository.add_stock')}}</p>
                    <h6 class="card-title">scanner
                    </h6>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">add</i>
                    </div>
                  </div>
                </div>
              </a>
              </div>
              @endcan
                  @can('استيراد ملف excel')
                  <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{route('import.excel.form',$repository->id)}}">
                    <div class="card card-stats">
                      <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                          <i class="material-icons">download</i>
                        </div>
                        <p class="card-category">{{__('repository.import_stock')}}</p>
                        <h6 class="card-title">Excel
                        </h6>
                      </div>
                      <div class="card-footer">
                        <div class="stats">
                          <i class="material-icons">add</i>
                        </div>
                      </div>
                </div>
              </a>
              </div>
              @endcan
              @can('عرض البضائع')
              <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('show.products',$repository->id)}}">
                <div class="card card-stats">
                  <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons">category</i>
                    </div>
                    <p class="card-category">{{__('repository.view_products')}}</p>
                    <h6 class="card-title">
                    </h6>
                  </div>
                  <div class="card-footer">
                    <div class="stats">
                      <i class="material-icons">add</i>
                    </div>
                  </div>
            </div>
          </a>
          </div>
          @endcan


</div>
  </div>
 </body>
 @endsection