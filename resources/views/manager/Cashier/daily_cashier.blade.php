@extends('layouts.main')
@section('links')
<style>
  table span{
    width: 50px;
  }
   /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
@endsection
@section('body')
<div class="main-panel">
   
<div class="content">
    @if (session('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ session('success') }}</strong>
    </div>
    @endif
 <form action="{{route('submit.cashier',$repository->id)}}"  method="post">
     @csrf
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{__('cashier.daily_close_of_cashier')}}</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      {{__('cashier.must_have_in_cashier')}}   <span class="badge badge-success">{{$repository->balance}}</span>  
                      <input type="hidden" name="cash_balance" value="{{$repository->balance}}">
                    </th>
                    <th>
                      {{__('cashier.must_have_in_card')}}    <span class="badge badge-success">{{$repository->card_balance}}</span>
                      <input type="hidden" name="card_balance" value="{{$repository->card_balance}}">  
                    </th>
                    <th>
                      {{__('cashier.must_have_in_stc')}}    <span class="badge badge-success">{{$repository->stc_balance}}</span>
                      <input type="hidden" name="stc_balance" value="{{$repository->stc_balance}}">  
                    </th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        {{__('cashier.The_amount_of_shortage_in_the_cashier')}}
                          <input type="number" name="cashNeg"  class="form-control" placeholder="{{__('cashier.Theamountoftheshortageinthecashier_if_there_shortage')}}">
                      </td>
                      <td>
                        {{__('cashier.The_amount_of_shortage_in_the_card')}}
                          <input type="number" name="cardNeg"  class="form-control" placeholder="{{__('cashier.Theamountoftheshortageinthecard_if_there_shortage')}}">
                      </td>
                      <td>
                        {{__('cashier.The_amount_of_shortage_in_the_stc')}}
                          <input type="number" name="stcNeg"  class="form-control" placeholder="{{__('cashier.Theamountoftheshortageinthestc_if_there_shortage')}}">
                      </td>
                    </tr>
                    <tr>
                        <td>
                          {{__('cashier.The_amount_of_increase_in_the_cashier')}}
                            <input type="number" name="cashPos"  class="form-control" placeholder="{{__('cashier.Theamountoftheincreaseinthecashier_if_there_increase')}}">
                        </td>
                        <td>
                          {{__('cashier.The_amount_of_increase_in_the_card')}}
                            <input type="number" name="cardPos"  class="form-control" placeholder="{{__('cashier.Theamountoftheincreaseinthecard_if_there_increase')}}">
                        </td>
                        <td>
                          {{__('cashier.The_amount_of_increase_in_the_stc')}}
                            <input type="number" name="stcPos"  class="form-control" placeholder="{{__('cashier.Theamountoftheincreaseinthestc_if_there_increase')}}">
                        </td>
                      </tr>
                      <tr>
                          <td>
                          <a class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" id="modalicon">  {{__('buttons.close_cashier')}} </a>
                          </td>
                          <!-- Modal for confirming -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{__('cashier.close_cashier')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        {{__('cashier.are_you_sure')}}
      </div>
      <div class="modal-footer">
        <a class="btn btn-danger" data-dismiss="modal">{{__('buttons.cancel')}}</a>
        <button type="submit" class="btn btn-primary">{{__('buttons.confirm')}}</button>
      </div>
    </div>
  </div>
</div>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </form>
    </div>
</div>
@endsection