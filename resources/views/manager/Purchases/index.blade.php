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
        @if (session('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ session('success') }}</strong>
        </div>
        @endif
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
             @can('انشاء فاتورة مشتريات')
             <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('purchase.add',$repository->id)}}">
               <div class="card card-stats">
                 <div class="card-header card-header-primary card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">note_add</i>
                   </div>
                   <p class="card-category"> {{__('purchases.create_purchase_invoice')}} </p>
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

             @can('دفع فاتورة مورد')
             <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('show.later.purchases',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">request_quote</i>
                  </div>
                  <p class="card-category">{{__('purchases.pay_supplier_invoice')}}</p>
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

            @can('اضافة منتج مشتريات')
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('purchase.products',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">add_box</i>
                  </div>
                  <p class="card-category">{{__('purchases.add_purchases_product')}}</p>
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
            @can('عرض فاتورة المشتريات')
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('show.purchases',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">preview</i>
                  </div>
                  <p class="card-category">{{__('purchases.view_purchases_invoice')}}</p>
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
            @can('عرض الموردين')
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('show.suppliers',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">people</i>
                  </div>
                  <p class="card-category">{{__('purchases.view_suppliers')}}</p>
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
            @can('اضافة مورد')
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{route('add.supplier',$repository->id)}}">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">person_add_alt</i>
                  </div>
                  <p class="card-category">{{__('purchases.add_supplier')}}</p>
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



           </div>
         
           </div>
  @endforeach
 </body>
 @endsection