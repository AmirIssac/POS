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
              /
                 {{$repository->address}}
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
            {{--@can('انشاء فاتورة مشتريات')
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a data-toggle="modal" data-target="#exampleModal{{$repository->id}}" id="modaltrigger">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">compare_arrows</i>
                  </div>
                  <p class="card-category">استرجاع فاتورة مشتريات</p>
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
            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$repository->id}}" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel{{$repository->id}}">استرجاع فاتورة مشتريات</h5>
                  </div>
                  <form action="{{route('retrieve.purchase.index',$repository->id)}}" method="GET">
                    @csrf
                  <div class="modal-body">
                    ابحث
                    <input type="search" name="search" class="form-control" placeholder="رقم الفاتورة | رقم فاتورة المورد | اسم المورد">
                  </div>
                  <div class="modal-footer">
                    <a data-dismiss="modal" class="btn btn-danger">{{__('buttons.cancel')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('sales.search')}}</button>
                  </form>
                  </div>
                </div>
              </div>
            </div>
            @endcan--}}
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
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('show.purchase.products',$repository->id)}}">
            <div class="card card-stats">
              <div class="card-header card-header-primary card-header-icon">
                <div class="card-icon">
                <i class="material-icons">category</i>
                </div>
                <p class="card-category">{{__('repository.view_products')}}</p>
                <h6 class="card-title"></h6>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">add</i>
                </div>
              </div>
            </div>
          </a>
          </div>

          @can('انشاء فاتورة مشتريات')
          <div class="col-lg-3 col-md-6 col-sm-6">
            <form action="{{route('purchase.add',$repository->id)}}" method="GET">
              @csrf
              <input type="hidden" name="old" value="yes">
            <div onClick="javascript:this.parentNode.submit();" class="card card-stats">
              <div class="card-header card-header-primary card-header-icon">
                <div class="card-icon">
                <i class="material-icons">pending_actions</i>
                </div>
                <p class="card-category">{{__('sales.register_invoice')}}</p>
                <h6 class="card-title">{{__('sales.by_specific_date')}}</h6>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="material-icons">update</i>
                </div>
              </div>
            </div>
            </form>
          </div>
          @endcan

           </div>
         
           </div>
 </body>
 @endsection