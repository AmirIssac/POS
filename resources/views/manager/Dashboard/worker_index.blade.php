@extends('layouts.main')
@section('body')

     <div class="main-panel">
      
       <div class="content">
        <div class="container-fluid">
          <div class="row">
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
          </div>
        </div>
         <div class="container-fluid">
           <div class="row">
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-warning card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">attach_money</i>
                   </div>
                   <p class="card-category"> أرباح اليوم</p>
                   <h3 class="card-title">0
                   </h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons text-danger">warning</i>
                   </div>
                 </div>
               </div>
             </div>
             @can('مشاهدة رصيد الخزينة')
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-success card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">account_balance_wallet</i>
                   </div>
                   <p class="card-category">الخزينة</p>
                   <h3 class="card-title">{{$repository->cash_balance+$repository->card_balance}}</h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">point_of_sale</i>
                     الدرج {{$repository->cash_balance}}
                   </div>
                   <div class="stats">
                    <i class="material-icons">payment</i>
                    البطاقة {{$repository->card_balance}}
                  </div>
                 </div>
               </div>
             </div>
             @endcan
             @can('رؤية عدد المنتجات')
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-danger card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">qr_code_2</i>
                   </div>
                   <p class="card-category">عدد المنتجات</p>
                   <h3 class="card-title">{{$repository->productsCount()}}</h3>   {{-- custom func in Repository model --}}
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">local_offer</i>
                   </div>
                 </div>
               </div>
             </div>
             @endcan
             @can('رؤية عدد الموظفين')
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-info card-header-icon">
                   <div class="card-icon">
                    <i class="material-icons">badge</i>
                   </div>
                   <p class="card-category">عدد الموظفين</p>
                   <h3 class="card-title">{{$repository->workersCount()}}</h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">update</i>
                   </div>
                 </div>
               </div>
             </div>
             @endcan
           </div>
           <div class="row">
             <div class="col-md-4">
               <div class="card card-chart">
                 <div class="card-header card-header-success">
                   <div class="ct-chart" id="dailySalesChart"></div>
                 </div>
                 <div class="card-body">
                   <h4 class="card-title">معلومات</h4>
                   <p class="card-category">
                     <span class="text-success">
                       <i class="fa fa-long-arrow-up"></i> 55% </span> معلومات.</p>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">access_time</i> معلومات  
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-md-4">
               <div class="card card-chart">
                 <div class="card-header card-header-warning">
                   <div class="ct-chart" id="websiteViewsChart"></div>
                 </div>
                 <div class="card-body">
                   <h4 class="card-title"> معلومات</h4>
                   <p class="card-category">معلومات</p>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">access_time</i>  معلومات
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-md-4">
               <div class="card card-chart">
                 <div class="card-header card-header-danger">
                   <div class="ct-chart" id="completedTasksChart"></div>
                 </div>
                 <div class="card-body">
                   <h4 class="card-title"> معلومات</h4>
                   <p class="card-category"> معلومات</p>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">access_time</i>   معلومات
                   </div>
                 </div>
               </div>
             </div>
               @endforeach
             </div>
           </div>
 @endsection