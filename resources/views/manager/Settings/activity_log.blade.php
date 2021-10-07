@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
  .select{
    border-radius: 10px;
    border:1px solid white;
    background-color: #2d3e4f;
    color: white
  }
  
</style>
@endsection
@section('body')
<div class="main-panel">

<div class="content">
  <form action="{{route('activity.log',$repository->id)}}" method="GET">
    @csrf
    {{__('settings.chose_process_you_wantto_search_into')}}
    <select name="action">
      @if(LaravelLocalization::getCurrentLocale() == 'ar')
      @foreach($actions as $action)
      @if(request()->query('action')==$action->id)
      <option value="{{$action->id}}" selected>{{$action->name_ar}}</option>
      @else
      <option value="{{$action->id}}">{{$action->name_ar}}</option>
      @endif
      @endforeach
      @else {{-- en --}}
      @foreach($actions as $action)
      @if(request()->query('action')==$action->id)
      <option value="{{$action->id}}" selected>{{$action->name_en}}</option>
      @else
      <option value="{{$action->id}}">{{$action->name_en}}</option>
      @endif
      @endforeach
      @endif
    </select>
    <button type="submit" class="btn btn-success btn-round btn-just-icon">
      <i class="material-icons">search</i>
    </button>  </form>
  {{--
  <form action="" method="">
    @csrf
    قم باختيار الصنف الذي تريد البحث ضمنه
    <select name="action">
      @foreach($types as $type)
      <option value="">{{$type['type']}}</option>
      @endforeach
    </select>
  </form>
  --}}
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
             {{__('settings.activity_record')}} 
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('settings.proccess')}}   
                    </th>
                    <th>
                      {{__('sales.date')}}   
                   </th>
                   <th>
                    {{__('settings.employee')}}   
                   </th>
                  <th>
                    {{__('settings.details')}}   
                  </th>
                  </thead>
                  <tbody>
                  @foreach($records as $record)
                  <tr>
                  <td>
                    @if(LaravelLocalization::getCurrentLocale() == 'ar')
                    {{$record->action->name_ar}}
                    @else
                    {{$record->action->name_en}}
                    @endif
                  </td>
                  <td>
                    {{$record->created_at}}
                  </td>
                  <td>
                    {{$record->user->name}}
                  </td>
                  <td>
                    <?php $details = unserialize($record->note) ?>
                    @switch($details['target'])
                    @case('invoice')
                    <a style="color: #03a4ec; font-weight: bold" href="{{route('invoice.details',$details['id'])}}"> <i class="material-icons eye">
                      visibility
                    </i> {{$details['code']}} </a>
                        @break
                    @case('customer')
                      <a style="color: #03a4ec; font-weight: bold" href="{{route('edit.client',$details['id'])}}">{{__('settings.customer')}}</a>
                      @break
                    @case('product')
                      @if(array_key_exists("total_price",$details))
                     <a style="color: #48a44c; font-weight: bold"> {{__('settings.total')}} {{$details['total_price']}} </a>
                      @else
                      <form action="{{route('edit.product')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$details['id']}}">
                        <input type="hidden" name="repository_id" value="{{$repository->id}}">
                        <a style="color: #03a4ec; font-weight: bold" onClick="javascript:this.parentNode.submit();""><i class="material-icons eye">
                          visibility
                        </i></a>
                      </form>
                      @endif
                    @break
                    @case('purchase')
                    <a style="color: #03a4ec; font-weight: bold" href="{{route('show.purchase.details',$details['id'])}}"> <i class="material-icons eye">
                      visibility
                    </i> {{$details['code']}} </a>
                    @break
                    @case('purchase_product')
                    @if(array_key_exists("total_price",$details))
                     <a style="color: #48a44c; font-weight: bold"> {{__('settings.total')}} {{$details['total_price']}} </a>
                    @else
                    <a style="color: #03a4ec; font-weight: bold" href="{{route('edit.purchase.product',$details['id'])}}"> <i class="material-icons eye">
                      visibility
                    </i> </a>
                    @endif
                    @break
                    @case('supplier')
                    <form action="{{route('edit.supplier')}}" method="POST">
                      @csrf
                      <input type="hidden" name="supplier_id" value="{{$details['id']}}">
                      <input type="hidden" name="repository_id" value="{{$repository->id}}">
                      <a style="color: #03a4ec; font-weight: bold" onClick="javascript:this.parentNode.submit();""><i class="material-icons eye">
                        visibility
                      </i></a>
                      </form>
                    @break
                    @case('cashier')
                    @if(array_key_exists("amount",$details))
                    <a style="color: #48a44c; font-weight: bold">{{$details['amount']}} </a>
                    @else
                    <a style="color: #03a4ec; font-weight: bold" href="{{route('view.daily.report.details',$details['id'])}}"> <i class="material-icons eye">
                      visibility
                    </i> </a>
                    @endif
                    @break
                    @endswitch
                  </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
                {{ $records->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection