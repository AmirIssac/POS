@extends('layouts.main')
@section('body')
<style>
  .card-header a{
    color:white !important;
  }
</style>
     <div class="main-panel">
      
       <div class="content">
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
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.invoices',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-info card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">receipt</i>
                   </div>
                   <p class="card-category">الفواتير</p>
                   <h6 class="card-title">عرض</h6>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">receipt</i>
                   </div>
                 </div>
               </div>
              </a>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="#">
               <div class="card card-stats">
                 <div class="card-header card-header-info card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">auto_stories</i>
                   </div>
                   <p class="card-category">التقارير اليومية</p>
                   <h6 class="card-title">عرض</h6>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">receipt</i>
                   </div>
                 </div>
               </div>
              </a>
             </div>
           </div>
         
           </div>
  @endforeach
 </body>
 @endsection