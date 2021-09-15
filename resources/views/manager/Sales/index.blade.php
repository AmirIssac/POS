@extends('layouts.main')
@section('body')
<style>
  .card-header a{
    color:white !important;
  }
  #modaltrigger:hover{
    cursor: pointer;
  }
</style>
     <div class="main-panel">
      
       <div class="content">
        @if (session('retrievedSuccess'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ session('retrievedSuccess') }}</strong>
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
            @can('انشاء فاتورة')
            @if($repository->category->name=='مخزن')   {{-- مخزن --}}
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('create.invoice',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-primary card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">add_circle_outline</i>
                   </div>
                   <p class="card-category">{{__('sales.new_invoice')}}</p>
                   <h6 class="card-title">{{__('sales.create')}}</h6>
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
             @if($repository->isSpecial())  {{-- محل خاص --}}
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('create.special.invoice',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-primary card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">loupe</i>
                   </div>
                   <p class="card-category">{{__('sales.new_invoice')}}</p>
                   <h6 class="card-title">{{__('sales.create')}}</h6>
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
                  <p class="card-category">{{__('sales.hanging_invoice')}}</p>
                  <h6 class="card-title">{{__('sales.complete')}}</h6>
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

            @if($repository->isSpecial())  {{-- محل خاص --}}
            @can('استرجاع فاتورة')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a data-toggle="modal" data-target="#exampleModal{{$repository->id}}" id="modaltrigger">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">compare_arrows</i>
                  </div>
                  <p class="card-category">{{__('sales.retrieve_invoice')}}</p>
                  <h6 class="card-title">{{__('sales.retrieve')}}</h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i>
                  </div>
                </div>
              </div>
            </a>
            </div>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$repository->id}}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel{{$repository->id}}">{{__('sales.retrieve_invoice')}}</h5>
                    </div>
                    <form action="{{route('retrieve.index',$repository->id)}}" method="GET">
                      @csrf
                    <div class="modal-body">
                      {{__('sales.search_by_mobile_or_invnum')}}
                      <input type="search" name="search" class="form-control" placeholder="{{__('sales.mobile_invnum')}}">
                    </div>
                    <div class="modal-footer">
                      <a data-dismiss="modal" class="btn btn-danger">{{__('buttons.cancel')}}</a>
                      <button type="submit" class="btn btn-primary">{{__('sales.search')}}</button>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
              @endcan
              @can('عرض العملاء')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('clients',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">people</i>
                  </div>
                  <p class="card-category">{{__('sales.customers')}}</p>
                  <h6 class="card-title">{{__('sales.view')}}</h6>
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
            @endif
           </div>
         
           </div>
 </body>
 @endsection