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
           <div class="card-header card-header-primary">
             <div class="ct-chart" id="dailySalesChart"></div>
           </div>
           <div class="card-body">
             <h4 class="card-title">{{__('repository.store')}} {{$repository->name}}</h4>
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
            @can('عرض الفواتير')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.invoices',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-primary card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">receipt</i>
                   </div>
                   <p class="card-category">{{__('reports.invoices')}}</p>
                   <h6 class="card-title">{{__('reports.view')}}</h6>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">receipt</i>
                   </div>
                 </div>
               </div>
              </a>
             </div>
             @endcan
             @can('عرض التقارير اليومية')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('daily.reports.index',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-info card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">auto_stories</i>
                   </div>
                   <p class="card-category">{{__('reports.daily_reports')}}</p>
                   <h6 class="card-title">{{__('reports.view')}}</h6>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">receipt</i>
                   </div>
                 </div>
               </div>
              </a>
             </div>
             @endcan
            
             @can('عرض التقارير اليومية')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('view.monthly.reports',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-info card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">description</i>
                   </div>
                   <p class="card-category">{{__('reports.monthly_reports_for_sales')}}</p>
                   <h6 class="card-title">{{__('reports.view')}}</h6>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">description</i>
                   </div>
                 </div>
               </div>
              </a>
             </div>
             @endcan
             @can('عرض التقارير اليومية')
             <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats" data-toggle="modal" data-target="#exampleModal{{$repository->id}}" id="modalicon{{$repository->id}}">
                  <div class="card-header card-header-success card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">note_add</i>
                   </div>
                   <p class="card-category">{{__('reports.create_monthly_report')}}</p>
                   <h6 class="card-title">{{__('reports.create')}}</h6>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">note_add</i>
                   </div>
                 </div>
               </div>
             </div>
                                        <!-- Modal for making monthly report -->
                                        <div class="modal fade" id="exampleModal{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$repository->id}}" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel{{$repository->id}}">{{__('reports.monthly_report')}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true"></span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                {{__('reports.are_you_sure_you_want_to_make_monthly_report')}} {{now()->month}}
                                              </div>
                                              <div class="modal-footer">
                                                <form action="{{route('make.monthly.report',$repository->id)}}" method="POST">
                                                  @csrf
                                                  <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
                                                <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
                                              </form>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
             @endcan
           </div>
         
           </div>
  @endforeach
 </body>
 @endsection