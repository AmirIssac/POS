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
        @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif
 
  @if ($message = Session::get('fail'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
  </div>
  @endif

       {{-- @foreach($repositories as $repository)  --}}
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
             @can('ايداع في الكاشير')
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats" data-toggle="modal" data-target="#exampleModa{{$repository->id}}" id="modalicon{{$repository->id}}">
                 <div class="card-header card-header-warning card-header-icon">
                   <div class="card-icon">
                   <i class="material-icons">input</i>
                   </div>
                   <p class="card-category"> {{__('cashier.deposit')}} </p>
                   <h6 class="card-title"></h6>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">update</i>
                   </div>
                 </div>
               </div>
             </div>
                   <!-- Modal -->
<div class="modal fade" id="exampleModa{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModaLabel{{$repository->id}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{route('deposite.cashier',$repository->id)}}" method="POST">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModaLabel{{$repository->id}}">  {{__('cashier.deposite_in_cashier')}}    </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        {{__('cashier.determine_the_money_you_want_deposite')}}
          <input type="number" step="0.01"  min="0.01" name="money" placeholder="{{__('cashier.amount_value')}}" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
      </div>
    </div>
  </form>

  </div>
</div>
             @endcan

            {{-- @can('سحب من الكاشير') --}}
            @can('سحب من الكاشير')
             <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats" data-toggle="modal" data-target="#exampleModal{{$repository->id}}" id="modalicon{{$repository->id}}">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">money_off</i>
                  </div>
                  <p class="card-category">{{__('cashier.withdraw')}}</p>
                  <h6 class="card-title"></h6>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal -->
<div class="modal fade" id="exampleModal{{$repository->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$repository->id}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{route('withdraw.cashier',$repository->id)}}" method="POST">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel{{$repository->id}}"> {{__('cashier.withdraw_from_cashier')}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        {{__('cashier.determine_the_money_you_want_withdraw')}}
          <input type="number" step="0.01" min="0.01" name="money" value="{{$repository->balance}}" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
      </div>
    </div>
  </form>

  </div>
</div>
           {{-- @endcan --}}
           @endcan


           @can('اغلاق الكاشير')
            {{--@if($repository->dailyReportsDesc->count()>0)
           @if($repository->lastDailyReportDate()==now()->format('d'))
           <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats" data-toggle="modal" data-target="#exampleModal" id="modalicon">
            <div class="card-header card-header-secondary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">live_help</i>
              </div>
              <p class="card-category">{{__('cashier.close_cashier')}}</p>
              <h6 class="card-title">   {{__('cashier.will_be_available')}}  {{$repository->timeRemaining()}} </h6>
            </div>
            <div class="card-footer">
              <div class="stats">
                {{__('cashier.unavailable')}}
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
        {{__('cashier.employee_close')}} {{$repository->dailyReportsDesc()->first()->user->name}} {{__('cashier.in_date')}} {{$repository->dailyReportsDesc()->first()->created_at}}
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
            @endif
            @else  
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('daily.cashier.form',$repository->id)}}">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
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
            @endif--}}
            <div class="col-lg-3 col-md-6 col-sm-6">
              <a href="{{route('daily.cashier.form',$repository->id)}}">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
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
            @endcan


           </div>
         
           </div>
 {{-- @endforeach  --}}
 </body>
 @endsection