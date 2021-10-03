<?php

namespace App\Http\Controllers\Manager;

use App\Customer;
use App\DailyReport;
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

    public function index($id){
        $repository = Repository::find($id);
        return view('manager.Reports.index')->with(['repository'=>$repository]);   
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
        $invoice_processes = $invoice->invoiceProcesses;
        return view('manager.Reports.invoice_details')->with(['repository'=>$repository,'invoice'=>$invoice,'invoice_processes'=>$invoice_processes]);
    }

    public function printInvoice($id){
        $invoice = Invoice::find($id);
        $repository = $invoice->repository;
        // send recipe
        $r = unserialize($invoice->recipe);   // it was array in old version and now its a array of array so we will handle both way to display recipe in old version invoices
        $recipe = array();
        if(count($r)<7){   // new version  array of arrays (impossible to have more than 6 recipes)
            // check if recipe values 0 so we dont print the recipe
            // send to printing just the valuable recipes
            for($i=0;$i<count($r);$i++){
            if($r[$i]['add_r']=='0' && $r[$i]['axis_r']=='0' && $r[$i]['cyl_r']=='0' && $r[$i]['sph_r']=='0' && $r[$i]['add_l']=='0' && $r[$i]['axis_l']=='0' && $r[$i]['cyl_l']=='0' && $r[$i]['sph_l']=='0' && $r[$i]['ipd']=='0' )
                continue;
                $recipe[] = $r[$i]; // input array into array so we get array of arrays
            }
        }
        else{   // old version
            $recipe[] = $r;
        }
         if($repository->setting->standard_printer) 
            return view('manager.Reports.print_invoice')->with(['repository'=>$repository,'invoice'=>$invoice,'recipe'=>$recipe]);
            else
            return view('manager.Sales.epson_recipe_data')->with(['repository'=>$repository,'invoice'=>$invoice,'recipe'=>$recipe]);
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
    public function viewCustomerInvoices(Request $request,$id){
        $customer = Customer::find($id);
        $repository = Repository::find($request->repo_id);
        $invoices = Invoice::where('repository_id',$repository->id)->where('customer_id',$customer->id)
        ->where('status','pending')
        ->whereRaw('total_price > cash_amount+card_amount+stc_amount')->paginate(20);
        return view('manager.Reports.show_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);  
    }
    /*public function dailyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->dailyReportsDesc()->paginate(1);
        return view('manager.Reports.daily_reports')->with('repository',$repository)->with('reports',$reports);
    }*/
    public function dailyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->dailyReportsDesc()->paginate(30);
        // retrieve current day invoices to display sales for current day in main page table
        $invoices = $repository->invoices()->where('daily_report_check',false)->doesntHave('dailyReports')->get();
        $purchases =  $repository->purchases()->where('daily_report_check',false)->doesntHave('dailyReports')->get(); // for current day
        return view('manager.Reports.daily_reports')->with(['repository'=>$repository,'reports'=>$reports,'invoices'=>$invoices,'purchases'=>$purchases]);
    }
    public function dailyReportDetails($id){
        $report = DailyReport::find($id);
        $repository = $report->repository;
        return view('manager.Reports.daily_report_details')->with(['report' => $report,'repository'=>$repository]);
    }
    public function dailyPurchaseReportDetails($id){
        $report = DailyReport::find($id);
        $repository = $report->repository;
        return view('manager.Reports.daily_purchase_report_details')->with(['report' => $report,'repository'=>$repository]);
    }
    public function reportDetailsCurrentDay($id){   // for current dynamic day (( not created report yet))
        $repository = Repository::find($id);
        $invoices = $repository->invoices()->where('daily_report_check',false)->get();
        $purchases = $repository->purchases()->where('daily_report_check',false)->get();  //لعرض قيمة المشتريات حتى في تقرير المبيعات
        return view('manager.Reports.current_day_details')->with(['invoices'=>$invoices,'repository'=>$repository,'purchases'=>$purchases]);
    }
    public function reportPurchaseDetailsCurrentDay($id){   // for current dynamic day (( not created report yet))
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->where('daily_report_check',false)->get();
        return view('manager.Reports.current_purchase_day')->with(['purchases'=>$purchases,'repository'=>$repository]);
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
        ini_set('max_execution_time', 500);
        $repository = Repository::find($id);
        $user = User::find(Auth::user()->id);   // worker
        $invoices = $repository->invoices()->where('monthly_report_check',false)->whereYear('created_at','=', now()->year)
        ->whereMonth('created_at','=',now()->month)->get();  // the invoices that will taken in monthly report
        $invoices = $repository->invoices()->where('monthly_report_check',false)
        ->get();
        $cash_amount = $repository->statistic->m_in_cash_balance;
        $card_amount = $repository->statistic->m_in_card_balance;
        $stc_amount = $repository->statistic->m_in_stc_balance;

        $purchases = $repository->purchases()->where('monthly_report_check',false)->whereYear('updated_at','=',now()->year)
        ->whereMonth('updated_at','=',now()->month)->get();
        
        $out_cashier = 0 ;
        $out_external = 0 ;
        foreach($purchases as $purchase){
            if($purchase->payment == 'cashier' && $purchase->status != 'retrieved')
                $out_cashier = $out_cashier + $purchase->total_price;
            elseif($purchase->payment == 'external' && $purchase->status != 'retrieved')
                $out_external = $out_external + $purchase->total_price;
        }
        $monthly_report = MonthlyReport::create([
            'repository_id' => $repository->id,
            'user_id' => $user->id,
            'cash_balance' => $cash_amount,
            'card_balance' => $card_amount,
            'stc_balance' => $stc_amount, 
            'out_cashier' => $out_cashier,
            'out_external' => $out_external,
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
        foreach($purchases as $purchase){
            $monthly_report->purchases()->attach($purchase->id);
            $purchase->update(
                [
                    'monthly_report_check' => true,
                ]
                );
        }
        return redirect()->route('view.monthly.reports',$repository->id)->with('success',__('alerts.monthly_report_create_success')); 
    }

   /* public function viewMonthlyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->monthlyReports()->orderBy('created_at','DESC')->paginate(1);
        return view('manager.Reports.monthly_reports')->with(['repository'=>$repository,'reports'=>$reports]);
    } */

    public function viewMonthlyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->monthlyReports()->orderBy('created_at','DESC')->paginate(30);
        // retrieve current month invoices to display sales for current month in main page table
        $invoices = $repository->invoices()->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false)->get();
        // retrieve current month purchases to display purchases for current month in main page table
        $purchases = $repository->purchases()->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false)->get();
        return view('manager.Reports.monthly_reports')->with(['repository'=>$repository,'reports'=>$reports,'invoices' => $invoices,'purchases'=>$purchases]);
    }

    public function monthlyReportDetails($id){
        $report = MonthlyReport::find($id);
        $repository = $report->repository;
        return view('manager.Reports.monthly_report_details')->with(['report' => $report,'repository'=>$repository]);
    }


    public function monthlyPurchaseReportDetails($id){
        $report = MonthlyReport::find($id);
        $repository = $report->repository;
        return view('manager.Reports.purchase_monthly_report_details')->with(['report' => $report,'repository'=>$repository]);
    }

    public function reportDetailsCurrentMonth($id){   // for current dynamic month (( not created report yet))
        $repository = Repository::find($id);
        $invoices = $repository->invoices()->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false)->get();
        $statistics = $repository->statistic;
        return view('manager.Reports.current_month_details')->with(['invoices'=>$invoices,'statistics'=>$statistics,'repository'=>$repository]);
    }

    public function purchaseReportDetailsCurrentMonth($id){
        //
        $repository = Repository::find($id);
        $purchases = $repository->purchases()->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false)->get();
        //$statistics = $repository->statistic;
        return view('manager.Reports.purchase_current_month')->with(['purchases'=>$purchases,'repository'=>$repository]);
    }
}
