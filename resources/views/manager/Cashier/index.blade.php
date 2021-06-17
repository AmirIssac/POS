@extends('layouts.main')
@section('body')
<style>
  .card-header a{
    color:white !important;
  }
  #modalicon:hover{
    cursor: pointer;
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
             @can('ايداع في الكاشير')
             <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="#">
               <div class="card card-stats">
                 <div class="card-header card-header-warning card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">input</i>
                   </div>
                   <p class="card-category"> إيداع </p>
                   <h6 class="card-title"></h6>
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

            {{-- @can('سحب من الكاشير') --}}
            @can('سحب من الكاشير')
             <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="#">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">money_off</i>
                  </div>
                  <p class="card-category">سحب</p>
                  <h6 class="card-title"></h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i>
                  </div>
                </div>
              </div>
            </a>
            </div>
           {{-- @endcan --}}
           @endcan


           @can('اغلاق الكاشير')
            @if($repository->dailyReportsDesc->count()>0)
           @if($repository->lastDailyReportDate()==now()->format('d'))
           <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats" data-toggle="modal" data-target="#exampleModal" id="modalicon">
            <div class="card-header card-header-secondary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">live_help</i>
              </div>
              <p class="card-category">إغلاق الكاشير</p>
              <h6 class="card-title"> سيكون متاح بعد  {{$repository->timeRemaining()}} </h6>
            </div>
            <div class="card-footer">
              <div class="stats">
                غير متاح
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        قام باغلاق الكاشير الموظف {{$repository->dailyReportsDesc()->first()->user->name}} بتاريخ {{$repository->dailyReportsDesc()->first()->created_at}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">موافق</button>
      </div>
    </div>
  </div>
</div>
           @else
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('daily.cashier.form',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">calculate</i>
                  </div>
                  <p class="card-category">إغلاق الكاشير</p>
                  <h6 class="card-title">يومي</h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    متاح
                  </div>
                </div>
              </div>
            </a>
            </div>
            @endif
            @else  {{-- there is no dailyreports yet --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('daily.cashier.form',$repository->id)}}">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                <i class="material-icons">calculate</i>
                </div>
                <p class="card-category">إغلاق الكاشير</p>
                <h6 class="card-title">يومي</h6>
              </div>
              <div class="card-footer">
                <div class="stats">
                  متاح
                </div>
              </div>
            </div>
          </a>
          </div>
            @endif
            @endcan


           </div>
         
           </div>
  @endforeach
 </body>
 @endsection