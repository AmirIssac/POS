@extends('layouts.main')
@section('body')

     <div class="main-panel">
      
       <div class="content">
         <div class="container-fluid">
           <div class="row">
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-warning card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">attach_money</i>
                   </div>
                   <p class="card-category"> أرباح اليوم</p>
                   <h3 class="card-title">$34
                   </h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons text-danger">warning</i>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-success card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">account_balance_wallet</i>
                   </div>
                   <p class="card-category">الخزينة</p>
                   <h3 class="card-title">$34,245</h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">date_range</i>  
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-danger card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">qr_code_2</i>
                   </div>
                   <p class="card-category">عدد المنتجات</p>
                   <h3 class="card-title">75</h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">local_offer</i>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-info card-header-icon">
                   <div class="card-icon">
                    <i class="material-icons">badge</i>
                   </div>
                   <p class="card-category">عدد الموظفين</p>
                   <h3 class="card-title">10</h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">update</i>
                   </div>
                 </div>
               </div>
             </div>
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
           </div>
         
 </body>
 @endsection