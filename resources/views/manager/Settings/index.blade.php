@extends('layouts.main')
@section('body')
<style>
  .card-header a{
    color:white !important;
  }
</style>
     <div class="main-panel">
      
       <div class="content">
        @if (session('successWorker'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ session('successWorker') }}</strong>
        </div>
        @endif
        @foreach($repositories as $repository)
        <div class="col-md-4">
         <div class="card card-chart">
           <div class="card-header card-header-success">
             <div class="ct-chart" id="dailySalesChart"></div>
           </div>
           <div class="card-body">
             <h4 class="card-title">مخزن {{$repository->name}}</h4>
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
            @can('المالية')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('settings.min.form',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-danger card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">paid</i>
                   </div>
                   <p class="card-category"> الإعدادات المالية </p>
                   <h6 class="card-title">تخصيص</h6>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">update</i>
                   </div>
                 </div>
               </div>
              </a>
             </div>
             @endcan
            

             @can('اضافة موظف جديد')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('add.worker',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">person_add_alt</i>
                  </div>
                  <p class="card-category">اضافة</p>
                  <h6 class="card-title">موظف جديد</h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i>
                  </div>
                </div>
              </div>
            </a>
            </div>
            @endcan

           

            @can('عرض الموظفين')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.workers',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">
                    settings_accessibility
                    </i>
                  </div>
                  <p class="card-category">الموظفين</p>
                  <h6 class="card-title">تخصيص</h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i>
                  </div>
                </div>
              </div>
            </a>
            </div>
            @endcan

            @if($repository->category->name=='محل خاص')  {{-- محل خاص --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('clients',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">people</i>
                  </div>
                  <p class="card-category">العملاء</p>
                  <h6 class="card-title">عرض</h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i>
                  </div>
                </div>
              </div>
            </a>
            </div>
            @endif
           
            @can('التطبيق')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('settings.app',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">settings_applications</i>
                  </div>
                  <p class="card-category">التطبيق</p>
                  <h6 class="card-title">تخصيص</h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i>
                  </div>
                </div>
              </div>
            </a>
            </div>
            @endcan


           </div>
         
           </div>
  @endforeach
 </body>
 @endsection