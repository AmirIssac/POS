<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Invoice;
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
        $invoices = $repository->invoicesDesc()->paginate(10);
        /*$re = $invoices->first();
        $re = unserialize($re->details);
        return $re;*/
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
        $invoices = Invoice::where('repository_id',$repository->id)->where('status','pending')->where('phone','like', '%' . $request->phoneSearch . '%')->paginate(5);
        return view('manager.Sales.show_pending_invoices')->with(['repository'=>$repository,'invoices'=>$invoices]);
    }

    public function dailyReports($id){
        $repository = Repository::find($id);
        $reports = $repository->dailyReportsDesc()->paginate(1);
        return view('manager.Reports.daily_reports')->with('repository',$repository)->with('reports',$reports);
    }
}
