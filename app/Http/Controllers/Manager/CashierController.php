<?php

namespace App\Http\Controllers\Manager;

use App\DailyReport;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Purchase;
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
        if(!$request->stcNeg)
        $request->stcNeg = 0;
        if(!$request->cashPos)
        $request->cashPos = 0;
        if(!$request->cardPos)
        $request->cardPos = 0;
        if(!$request->stcPos)
        $request->stcPos = 0;
        // money out taken by statistics table
        $out_cashier = $repository->statistic->d_out_cashier;
        $out_external = $repository->statistic->d_out_external;

        // we will check if the last daily report submitted by less than two hours so we add this report details to the latest report and dont make new daily report
        $dailyReport = $repository->dailyReports->last();
        if($dailyReport){
        $now = now();
        $created_at = $dailyReport->created_at;
        $hours = $now->diffInHours($created_at);   // the number of hours between last daily report and NOW
        if($hours < 2){
             $dailyReport->update([
                'user_id' => $user->id,
                'cash_balance' => $request->cash_balance,
                'card_balance' => $dailyReport->card_balance + $request->card_balance,
                'stc_balance' => $dailyReport->stc_balance + $request->stc_balance,
                'cash_shortage' => $dailyReport->cash_shortage + $request->cashNeg,
                'card_shortage' => $dailyReport->card_shortage + $request->cardNeg,
                'stc_shortage' => $dailyReport->stc_shortage + $request->stcNeg,
                'cash_plus' => $dailyReport->cash_plus + $request->cashPos,
                'card_plus' => $dailyReport->card_plus + $request->cardPos,
                'stc_plus' => $dailyReport->stc_plus + $request->stcPos,
                'out_cashier' => $dailyReport->out_cashier + $out_cashier,
                'out_external' => $dailyReport->out_external + $out_external,
            ]);
        }
        else{
            $dailyReport = DailyReport::create(
                [
                    'repository_id' => $repository->id,
                    'user_id' => $user->id,
                    'cash_balance' => $request->cash_balance,
                    'card_balance' => $request->card_balance,
                    'stc_balance' => $request->stc_balance,
                    'cash_shortage' => $request->cashNeg,
                    'card_shortage' => $request->cardNeg,
                    'stc_shortage' => $request->stcNeg,
                    'cash_plus' => $request->cashPos,
                    'card_plus' => $request->cardPos,
                    'stc_plus' => $request->stcPos,
                    'out_cashier' => $out_cashier,
                    'out_external' => $out_external,
                ]
                );
        }
        }
        else{
        $dailyReport = DailyReport::create(
            [
                'repository_id' => $repository->id,
                'user_id' => $user->id,
                'cash_balance' => $request->cash_balance,
                'card_balance' => $request->card_balance,
                'stc_balance' => $request->stc_balance,
                'cash_shortage' => $request->cashNeg,
                'card_shortage' => $request->cardNeg,
                'stc_shortage' => $request->stcNeg,
                'cash_plus' => $request->cashPos,
                'card_plus' => $request->cardPos,
                'stc_plus' => $request->stcPos,
                'out_cashier' => $out_cashier,
                'out_external' => $out_external,
            ]
            );
        }
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
                'stc_balance' => 0,
            ]
            );

        // make the daily_report for the Purchases ((attach))
        $purchases = Purchase::where('repository_id',$repository->id)->where('daily_report_check',false)->get();
        foreach($purchases as $purchase){
            $dailyReport->purchases()->attach($purchase->id);
            $purchase->update(
                [
                    'daily_report_check' => true,
                ]
                );
            }
        // withdraw the daily out money from statistics
        $statistic = $repository->statistic;
        $statistic->update([
            'd_out_cashier' => 0,
            'd_out_external' => 0,
        ]);
            //return redirect()->route('cashier.index', ['success' => 'تم إغلاق الكاشير اليومي بنجاح']);
            return redirect()->route('daily.reports.index',$repository->id)->with('success',__('alerts.cashier_closed_success'));
        }

        public function warning($id){
            $repository = Repository::find($id);
            $warning = $repository->CashierWarningDetails(); 
            return view('manager.Cashier.warning')->with(['repository'=>$repository,'warning'=>$warning]);
        }

        public function dailyCashierWarningForm($id){
            $repository = Repository::find($id);
            return view('manager.Cashier.daily_cashier_warning')->with('repository',$repository);
        }

        public function withdraw(Request $request , $id){
            $repository = Repository::find($id);
            if($repository->balance<$request->money)
                return back()->with('fail',__('alerts.money_withdraw_bigger_than_in_cashier'));
            $repository->update([
                'balance' => $repository->balance - $request->money,
            ]);
            return back()->with('success',__('alerts.withdraw_success').$request->money);
        }

        public function deposite(Request $request , $id){
            $repository = Repository::find($id);
            $repository->update([
                'balance' => $repository->balance + $request->money,
            ]);
            return back()->with('success',__('alerts.deposite_success').$request->money);
        }
}
