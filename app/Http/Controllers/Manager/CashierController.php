<?php

namespace App\Http\Controllers\Manager;

use App\DailyReport;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    //

    public function index(){
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;   // display all repositories for the owner|worker
        return view('manager.Cashier.index')->with(['repositories'=>$repositories]);    
    }

    public function dailyCashierForm($id){
        $repository = Repository::find($id);
        return view('manager.Cashier.daily_cashier')->with('repository',$repository);
    }

    public function submitCashier(Request $request , $id){
        $repository = Repository::find($id);
        $user = User::find(Auth::user()->id);   // cashier worker
        if(!$request->cashNeg)
        $request->cashNeg = 0;
        if(!$request->cardNeg)
        $request->cardNeg = 0;
        if(!$request->cashPos)
        $request->cashPos = 0;
        if(!$request->cardPos)
        $request->cardPos = 0;
        $dailyReport = DailyReport::create(
            [
                'repository_id' => $repository->id,
                'user_id' => $user->id,
                'cash_balance' => $request->cash_balance,
                'card_balance' => $request->card_balance,
                'cash_shortage' => $request->cashNeg,
                'card_shortage' => $request->cardNeg,
                'cash_plus' => $request->cashPos,
                'card_plus' => $request->cardPos,
            ]
            );
            // all invoices not taked by DailyReport Yet..
        $invoices = Invoice::where('repository_id',$repository->id)->where('daily_report_check',false)->get();
        foreach($invoices as $invoice){
        $dailyReport->invoices()->attach($invoice->id);
        $invoice->update(
            [
                'daily_report_check' => true,
            ]
            );
        }
        // withdraw all the money in the safe
        $repository->update(
            [
                'cash_balance' => 0,
                'card_balance' => 0,
            ]
            );

            //return redirect()->route('cashier.index', ['success' => 'تم إغلاق الكاشير اليومي بنجاح']);
            return redirect()->route('daily.reports.index',$repository->id)->with('success','تم اغلاق الكاشير بنجاح');
        }
}
