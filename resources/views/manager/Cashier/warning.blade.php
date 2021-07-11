@extends('layouts.cashier_warning')
@section('body')
<div class="main-panel">
      
    <div class="content">
     <div class="container-fluid">
       <div class="row">
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
       </div>
     </div>
      <div class="container-fluid">
        <div class="row">
          
          
          @if(auth()->user()->can('اغلاق الكاشير'))
            
            <div class="col-lg-3 col-md-6 col-sm-6">
                <i class="material-icons">report_problem</i>
            <span class="badge badge-warning">لم يتم اغلاق الكاشير اليومي منذ  حوالي {{$warning['hours']}} ساعة يرجى اغلاقه لكي تستطيع متابعة عمليات اليوم بنجاح</span>
                <a href="{{route('daily.cashier.warning.form',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">calculate</i>
                  </div>
                  <p class="card-category">{{__('cashier.close_cashier')}}</p>
                  <h6 class="card-title">{{__('cashier.daily')}}</h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    {{__('cashier.available')}}
                  </div>
                </div>
              </div>
            </a>
            </div>
           
            @else {{-- not can --}}
            <i class="material-icons">report_problem</i>
            <span class="badge badge-warning"> يرجى اغلاق الكاشير اليومي من موظف يملك الصلاحية حتى تتمكن من متابعة نشاطك في المتجر </span>
          @endif {{-- end can --}}
        </div>
      </div>
    </div>
</div>
@endsection