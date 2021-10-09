@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
  #warning{
    font-size: 38px;
  }
  #code{
    float: left;
  }
  #myTable th{
   color: black;
   font-weight: bold;
  }
  #myTable td{
   color: black;
   font-weight: bold;
  }
</style>
@endsection
@section('body')
<div class="main-panel">
    @if (session('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('success') }}</strong>
    </div>
    @endif
<div class="content">
  <?php $user_year_created = $user->created_at->year;
          $end_year_loop = now()->year;
    ?>
  <form action="{{route('show.worker.sales',[$user->id,$repository->id])}}" method="GET">
    @csrf
    {{__('settings.chose_sales_specific_month')}}     
    <select name="month">
      @for ($i=1;$i<=12;$i++)
        @if(request()->query('month') == $i)
        <option value="{{$i}}" selected>{{__('settings.month')}} {{$i}}</option>
        @else
        <option value="{{$i}}">{{__('settings.month')}} {{$i}}</option>
        @endif
      @endfor
    </select>
    {{__('settings.within_specific_year')}}
    <select name="year">
      @for($i=$user_year_created;$i<=$end_year_loop;$i++)
        @if(request()->query('year') == $i)
        <option value="{{$i}}" selected>{{__('settings.year')}} {{$i}}</option>
        @else
        <option value="{{$i}}">{{__('settings.year')}} {{$i}}</option>
        @endif
      @endfor
    </select>
    <button type="submit" class="btn btn-success btn-round btn-just-icon">
      <i class="material-icons">search</i>
    </button>
  </form>
  <form action="{{route('show.worker.sales',[$user->id,$repository->id])}}" method="GET">
    @csrf
    {{__('settings.chose_total_sales_for_specific_year')}}
    <select name="year">
      @for ($i=$user_year_created;$i<=$end_year_loop;$i++)
        @if(request()->query('year') == $i)
        <option value="{{$i}}" selected>{{__('settings.year')}} {{$i}}</option>
        @else
        <option value="{{$i}}">{{__('settings.year')}} {{$i}}</option>
        @endif
      @endfor
    </select>
    <button type="submit" class="btn btn-success btn-round btn-just-icon">
      <i class="material-icons">search</i>
    </button>
  </form>

  
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title"> {{__('reports.sales')}} {{$user->name}} 
              </h4>
              @if(request()->query('month'))
              {{__('settings.month')}} {{request()->query('month')}} 
              @endif
              @if(request()->query('year'))
              {{__('settings.year')}} {{request()->query('year')}}
              @endif
            </div>
            <div class="card-body">
              <div class="table-responsive">
                
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                        {{__('reports.invoices_num')}} 
                      </th>
                      <th>
                        {{__('reports.sales')}} 
                      </th>
                  </thead>
                  <tbody>
                    <?php $sales = 0 ; ?>
                   @foreach($invoices as $invoice)
                 {{--  @if($invoice->status != 'retrieved' && $invoice->status != 'deleted' && $invoice->monthlyReports()->count()==0) --}}
                    @if($invoice->status != 'retrieved' && $invoice->status != 'deleted')
                    <?php $sales+=$invoice->total_price ?>
                    @endif
                   @endforeach
                   <tr>
                      <td>
                        {{$invoices->count()}}
                      </td>
                    <td>
                      {{$sales}}
                    </td>
                   
                   </tr>
                  </tbody>
                </table>

              </div>
              </div>
            </div>
           
          </div>
        </div>
       

      </div>
    </div>
</div>
@endsection