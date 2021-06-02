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
            @can('انشاء فاتورة')
            @if($repository->category->name=='مخزن')   {{-- مخزن --}}
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('create.invoice',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-info card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">add_circle_outline</i>
                   </div>
                   <p class="card-category">فاتورة جديدة</p>
                   <h6 class="card-title">انشاء</h6>
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
             @if($repository->category->name=='محل خاص')  {{-- محل خاص --}}
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('modal.customer',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-info card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">loupe</i>
                   </div>
                   <p class="card-category">فاتورة جديدة</p>
                   <h6 class="card-title">انشاء</h6>
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
             @endcan


             @can('عرض الفواتير المعلقة')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.pending',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">incomplete_circle</i>
                  </div>
                  <p class="card-category">فاتورة معلقة</p>
                  <h6 class="card-title">استكمال</h6>
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