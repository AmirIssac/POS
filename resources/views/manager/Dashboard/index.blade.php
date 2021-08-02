@extends('layouts.main')
<style>
  .form-icon:hover{
    cursor: pointer;
  }
  .form-icon{
    color: #9229ac;
  }
</style>
@section('body')

     <div class="main-panel">
      
       <div class="content">
        <div class="container-fluid">
          <div class="row">
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
          </div>
        </div>
         <div class="container-fluid">
           <div class="row">
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.today.invoices',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-primary card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">feed</i>
                   </div>
                   <p class="card-category">{{__('dashboard.today_invoices')}}</p>
                   <?php $arr = $repository->dailyInvoicesCount() ?>
                   <p class="card-title">
                     <span class="badge badge-success">
                    {{__('dashboard.delivered')}}  {{$arr['delivered']}}</span>
                   </br>
                   <span class="badge badge-warning">
                   {{__('dashboard.hanging')}}  {{$arr['hanging']}}</span>
                   <span class="badge badge-secondary">
                   {{__('dashboard.retrieved')}}  {{$arr['retrieved']}}</span>
                   </p>
                 </div>
                 <div class="card-footer">
                  <div class="stats">
                  </div>
                 </div>
               </div>
              </a>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.monthly.invoices',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-primary card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">feed</i>
                   </div>
                   <p class="card-category">{{__('dashboard.month_invoices')}}</p>
                   <?php $arr = $repository->monthlyInvoicesCount() ?>
                   <p class="card-title">
                     <span class="badge badge-success">
                    {{__('dashboard.delivered')}}  {{$arr['delivered']}}</span>
                   </br>
                   <span class="badge badge-warning">
                   {{__('dashboard.hanging')}}  {{$arr['hanging']}}</span>
                   <span class="badge badge-secondary">
                   {{__('dashboard.retrieved')}}  {{$arr['retrieved']}}</span>
                   </p>
                 </div>
                 <div class="card-footer">
                  <div class="stats">
                  </div>
                 </div>
               </div>
              </a>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-success card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">account_balance_wallet</i>
                   </div>
                   <p style="color: #9229ac; font-weight: bold" class="card-category">{{__('dashboard.today_sales')}}</p>
                   <h3 style="color: #9229ac" class="card-title">{{$repository->todaySales()}}</h3>
                    <p style="color: #48a44c; font-weight: bold" class="card-category">{{__('dashboard.money_collected')}}</p>
                    <h3 style="color:#48a44c " class="card-title">{{$repository->cash_balance+$repository->card_balance+$repository->stc_balance}}
                    </h3>
                    {{--
                    <p style="color: #f14000; font-weight: bold" class="card-category">{{__('dashboard.today_money_pending')}}</p>
                    <h3 style="color: #f14000" class="card-title">{{$repository->todayPendingMoney()}}
                    </h3>
                    --}}
                    <p style="color: #f14000; font-weight: bold" class="card-category">{{__('dashboard.total_pending_money')}}</p>
                    <h3 style="color: #f14000" class="card-title">{{$repository->totalPendingMoney()}}
                    </h3>
                 </div>
                 <div class="card-footer">
                   <div style="display: flex; flex-direction: column; width: 100%">
                    <div style="display: flex; justify-content: space-between">
                   <div class="stats">
                     <i style="color: #48a44c;" class="material-icons">point_of_sale</i>
                     {{__('dashboard.cash')}} {{$repository->cash_balance}}
                   </div>
                   <div class="stats">
                    <i style="color: #48a44c" class="material-icons">payment</i>
                    {{__('dashboard.card')}} {{$repository->card_balance}}
                  </div>
                    </div>
                    <div style="display: flex; justify-content: space-between">
                  <div class="stats">
                    <i style="color: #48a44c" class="material-icons">payment</i>
                    STC {{$repository->stc_balance}}
                  </div>
                  <div class="stats">
                     <i style="color: #9229ac" class="material-icons">account_balance</i>
                    {{__('dashboard.cashier')}} {{$repository->balance}} 
                  </div>
                    </div>
                   </div>
                 </div>
               </div>
             </div>


             <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">trending_up</i>
                  </div>
                  <p style="color: #9229ac; font-weight: bold" class="card-category">مبيعات الشهر</p>
                  <h3 style="color: #9229ac" class="card-title">{{$repository->monthSales()}}</h3>
                   <p style="color: #48a44c; font-weight: bold" class="card-category">الأموال المحصلة لهذا الشهر</p>
                   <h3 style="color:#48a44c " class="card-title">{{$repository->thisMonthGainedMoney()}}
                   </h3>
                  
                   {{--<p style="color: #f14000; font-weight: bold" class="card-category">الأموال المعلقة لهذا الشهر</p>
                   <h3 style="color: #f14000" class="card-title">{{$repository->thisMonthPendingMoney()}}
                   </h3>--}}
                </div>
                <div class="card-footer">
                  <div style="display: flex; flex-direction: column; width: 100%">
                   <div style="display: flex; justify-content: space-between">
                  <div class="stats">
                    <i style="color: #48a44c;" class="material-icons">point_of_sale</i>
                    {{__('dashboard.cash')}} {{$repository->statistic->m_in_cash_balance}}
                  </div>
                  <div class="stats">
                   <i style="color: #48a44c" class="material-icons">payment</i>
                   {{__('dashboard.card')}} {{$repository->statistic->m_in_card_balance}}
                 </div>
                   </div>
                   <div style="display: flex; justify-content: space-between">
                 <div class="stats">
                   <i style="color: #48a44c" class="material-icons">payment</i>
                   STC {{$repository->statistic->m_in_stc_balance}}
                 </div>
                 
                   </div>
                  </div>
                </div>
              </div>
            </div>


             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-danger card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">local_shipping</i>
                   </div>
                   <p style="color: #9229ac; font-weight: bold" class="card-category">{{__('dashboard.month_purchases')}}</p>
                   <h3 style="color: #9229ac" class="card-title">{{$repository->monthPurchases()}}</h3>
                   <p style="color: #9229ac; font-weight: bold" class="card-category">{{__('dashboard.today_purchases')}}</p>
                   <h3 style="color: #9229ac" class="card-title">{{$repository->todayPurchases()}}</h3>
                   <p style="color: #48a44c; font-weight: bold" class="card-category">{{__('dashboard.today_paid_money')}}</p>
                   <h3 style="color: #48a44c;" class="card-title">{{$repository->todayPayedMoney()}}</h3>
                   <p style="color: #f14000; font-weight: bold" class="card-category"> {{__('dashboard.pending_paid_money')}}</p>
                   <h3 style="color: #f14000; class="card-title">{{$repository->pendingPayedMoney()}}</h3>
                   <p style="color: #f14000; font-weight: bold" class="card-category"> {{__('dashboard.highest_five_suppliers')}}  </p>
                   
                 </div>
                 <div style="display: flex; flex-direction: column; margin:10px 14px 0 0;">
                  @if($repository->mostFiveSupplierShouldPay()->count()>0)
                   @foreach($repository->mostFiveSupplierShouldPay() as $info)
                   <form action="{{route('search.by.supplier',$repository->id)}}" method="GET">
                    @csrf
                    <input type="hidden" name="later" value="later">
                    <input type="hidden" name="supplier" value="{{$info->supplier_id}}">
                   <div style="display: flex; justify-content: space-between; font-weight: bold;font-size: 14px; color:#f14000">
                      {{$info->supplier->name}} {{$info->sum}}
                    <button style="background: none; padding: 0px; border: none"><i class="material-icons form-icon">
                      preview
                    </i></button>
                   </div>
                  </form>
                   @endforeach
                   @else
                   <div style="font-weight: bold; font-size: 14px; color:#48a44c;">
                    {{__('dashboard.none')}} 
                   </div>
                   @endif
                 </div>
               </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.products',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-danger card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">qr_code_2</i>
                   </div>
                   <p class="card-category">{{__('dashboard.number_of_products')}}</p>
                   <h3 class="card-title">{{$repository->productsCount()}}</h3>   {{-- custom func in Repository model --}}
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">local_offer</i>
                   </div>
                 </div>
               </div>
              </a>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.workers',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-info card-header-icon">
                   <div class="card-icon">
                    <i class="material-icons">badge</i>
                   </div>
                   <p class="card-category">{{__('dashboard.number_of_employees')}}</p>
                   <h3 class="card-title">{{$repository->workersCount()}}</h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">update</i>
                   </div>
                 </div>
               </div>
              </a>
             </div>
           </div>
        
           <div class="row">
             <div class="col-md-4">
               <div class="card card-chart">
                 <div class="card-header card-header-success">
                   <div class="ct-chart" id="dailySalesChart"></div>
                 </div>
                 <div class="card-body">
                   <h4 class="card-title">{{__('dashboard.information')}}</h4>
                   <p class="card-category">
                     <span class="text-success">
                       <i class="fa fa-long-arrow-up"></i> 55% </span> {{__('dashboard.information')}}.</p>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">access_time</i> {{__('dashboard.information')}}  
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
                   <h4 class="card-title"> {{__('dashboard.information')}}</h4>
                   <p class="card-category">{{__('dashboard.information')}}</p>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">access_time</i>  {{__('dashboard.information')}}
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
                   <h4 class="card-title"> {{__('dashboard.information')}}</h4>
                   <p class="card-category"> {{__('dashboard.information')}}</p>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">access_time</i>   {{__('dashboard.information')}}
                   </div>
                 </div>
               </div>
             </div>
               @endforeach
             </div>
           </div>
 @endsection