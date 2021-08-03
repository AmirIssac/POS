<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\MonthlyReport;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //

    public function index(){
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;   // display all repositories for the owner|worker
        return view('manager.Reports.index')->with(['repositories'=>$repositories]);   
    }

    public function showInvoices($id){
        $repository = Repository::find($id);
        $invoices = $repository->invoicesDesc()->paginate(20);
        /*$re = $invoices->first();
        $re = unserialize($re->details);
        return $re;*/
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function invoiceDetails($id){
        $invoice = Invoice::find($id);
        $repository = $invoice->repository;
        return view('manager.Reports.invoice_details')->with(['repository'=>$repository,'invoice'=>$invoice]);
    }

    public function printInvoice($id){
        $invoice = Invoice::find($id);
        $repository = $invoice->repository;
        return view('manager.Reports.print_invoice')->with(['repository'=>$repository,'invoice'=>$invoice]);
    }

    public function filterPending(Request $request,$id){
        $repository = Repository::find($id);
        if(!$request->filter)
            return back();
        if($request->filter == 'payed'){
        $invoices = $repository->invoices()->where('status','pending')
        ->whereRaw('total_price','cash_amount+card_amount+stc_amount')->paginate(20);
        }
        elseif($request->filter == 'notpayed'){
            $invoices = $repository->invoices()->where('status','pending')
            ->whereRaw('total_price > cash_amount+card_amount+stc_amount')->paginate(20);
        }
       // return view('manager.Sales.show_pending_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
       return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function showTodayInvoices($id){
        $repository = Repository::find($id);
        $invoices = $repository->dailyInvoices()->orderBy('created_at','DESC')->paginate(5);
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function showMonthInvoices($id){  // show invoices of this month
        $repository = Repository::find($id);
        $invoices = $repository->monthlyInvoices()->orderBy('created_at','DESC')->paginate(10);
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }
    
    public function searchInvoicesByDate(Request $request,$id){
        $repository = Repository::find($id);
        $invoices = Invoice::where('repository_id',$repository->id)->whereDate('created_at',$request->dateSearch)->paginate(10);
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function searchInvoicesByCode(Request $request , $id){
        $repository = Repository::find($id);
        $invoices = Invoice::where('repository_id',$repository->id)->where('code',$request->code)->paginate(10);
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function searchPending(Request $request , $id){
        $repository = Repository::find($id);
        $invoices = Invoice::where('repository_id',$repository->id)->where('status','pending')
        ->where(function($query) use ($request) {
            $query->where('phone','like', '%' . $request->search . '%')
                  ->orWhere('code', $request->search); })
        ->paginate(20);
        //return view('manager.Sales.show_pending_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function dailyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->dailyReportsDesc()->paginate(1);
        return view('manager.Reports.daily_reports')->with('repository',$repository)->with('reports',$reports);
    }

    /*public function makeMonthlyReport($id){
        $repository = Repository::find($id);
        $user = User::find(Auth::user()->id);   // worker
        $invoices = $repository->invoices()->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->get();  // the invoices that will taken in monthly report
        $cash_amount = $repository->invoices()->where('status','!=','retrieved')->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->sum('cash_amount');
        $card_amount = $repository->invoices()->where('status','!=','retrieved')->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->sum('card_amount');
        $stc_amount = $repository->invoices()->where('status','!=','retrieved')->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->sum('stc_amount');
        
        $monthly_report = MonthlyReport::create([
            'repository_id' => $repository->id,
            'user_id' => $user->id,
            'cash_balance' => $cash_amount,
            'card_balance' => $card_amount,
            'stc_balance' => $stc_amount,
        ]);

        foreach($invoices as $invoice){
            $monthly_report->invoices()->attach($invoice->id);
            $invoice->update(
                [
                    'monthly_report_check' => true,
                ]
                );
        }
        return redirect()->route('view.monthly.reports',$repository->id)->with('success','تم انشاء تقرير شهري بنجاح'); 
    } */

    public function makeMonthlyReport($id){
        $repository = Repository::find($id);
        $user = User::find(Auth::user()->id);   // worker
        $invoices = $repository->invoices()->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->get();  // the invoices that will taken in monthly report
        /*$cash_amount = $repository->invoices()->where('status','!=','retrieved')->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->sum('cash_amount');
        $card_amount = $repository->invoices()->where('status','!=','retrieved')->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->sum('card_amount');
        $stc_amount = $repository->invoices()->where('status','!=','retrieved')->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->sum('stc_amount');*/
        $cash_amount = $repository->statistic->m_in_cash_balance;
        $card_amount = $repository->statistic->m_in_card_balance;
        $stc_amount = $repository->statistic->m_in_stc_balance;
        $monthly_report = MonthlyReport::create([
            'repository_id' => $repository->id,
            'user_id' => $user->id,
            'cash_balance' => $cash_amount,
            'card_balance' => $card_amount,
            'stc_balance' => $stc_amount,
        ]);

        // make statistic for month is Zero because we start new month
        $statistic = $repository->statistic;
        $statistic->update([
            'm_in_cash_balance' => 0,
            'm_in_card_balance' => 0,
            'm_in_stc_balance' => 0,
        ]);
        foreach($invoices as $invoice){
            $monthly_report->invoices()->attach($invoice->id);
            $invoice->update(
                [
                    'monthly_report_check' => true,
                ]
                );
        }
        return redirect()->route('view.monthly.reports',$repository->id)->with('success','تم انشاء تقرير شهري بنجاح'); 
    }

   /* public function viewMonthlyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->monthlyReports()->orderBy('created_at','DESC')->paginate(1);
        return view('manager.Reports.monthly_reports')->with(['repository'=>$repository,'reports'=>$reports]);
    } */

    public function viewMonthlyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->monthlyReports()->orderBy('created_at','DESC')->paginate(30);
        return view('manager.Reports.monthly_reports')->with(['repository'=>$repository,'reports'=>$reports]);
    }

    public function monthlyReportDetails($id){
        $report = MonthlyReport::find($id);
        return view('manager.Reports.monthly_report_details')->with(['report' => $report]);
    }

    public function reportDetailsCurrentMonth($id){   // for current dynamic month (( not created report yet))
        $repository = Repository::find($id);
        $invoices = $repository->invoices()->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false)->get();
        $statistics = $repository->statistic;
        return view('manager.Reports.current_month_details')->with(['invoices'=>$invoices,'statistics'=>$statistics]);
    }
}
