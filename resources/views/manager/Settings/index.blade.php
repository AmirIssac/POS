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
        @if ($message = Session::get('fail'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
        @endif
        @foreach($repositories as $repository)
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
            @can('المالية')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('settings.min.form',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-danger card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">paid</i>
                   </div>
                   <p class="card-category">  {{__('settings.financial_settings')}} </p>
                   <h6 class="card-title">{{__('settings.customize')}}</h6>
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
                  <p class="card-category">{{__('settings.add')}}</p>
                  <h6 class="card-title"> {{__('settings.new_employee')}} </h6>
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
                  <p class="card-category">{{__('settings.employees')}}</p>
                  <h6 class="card-title">{{__('settings.customize')}}</h6>
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

           
           
            @can('التطبيق')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('settings.app',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">settings_applications</i>
                  </div>
                  <p class="card-category">{{__('settings.app')}}</p>
                  <h6 class="card-title">{{__('settings.customize')}}</h6>
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