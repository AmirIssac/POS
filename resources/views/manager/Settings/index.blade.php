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
               <div class="card card-stats">
                 <div class="card-header card-header-dark card-header-icon">
                  <a href="{{route('settings.min.form',$repository->id)}}">
                   <div class="card-icon">
                   <i class="material-icons">unfold_more</i>
                   </div>
                  </a>
                   <p class="card-category"> الفواتير المعلقة </p>
                   <h6 class="card-title">الحد الأدنى للدفع</h6>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">update</i>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         
           </div>
  @endforeach
 </body>
 @endsection