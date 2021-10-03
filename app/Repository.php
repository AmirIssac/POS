<?php

namespace App;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $fillable = [
        'branch_id','name','name_en','address','category_id','cash_balance','card_balance','stc_balance','balance','today_sales','min_payment','max_discount','tax','tax_code','logo','close_time','note',
    ];
    //
    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
    public function productsAsc(){
        return $this->hasMany(Product::class)->orderBy('quantity');
    }
    public function category(){ 
        return $this->belongsTo(RepositoryCategory::class);
    }
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
    public function invoiceProcesses(){
        return $this->hasMany(InvoiceProcess::class);
    }
    public function invoicesDesc(){
        return $this->hasMany(Invoice::class)->orderBy('created_at','DESC');
    }
    public function dailyReports(){
        return $this->hasMany(DailyReport::class);
    }
    public function monthlyReports(){
        return $this->hasMany(MonthlyReport::class);
    }

    public function dailyReportsDesc(){
        return $this->hasMany(DailyReport::class)->orderBy('created_at','DESC');
    }

    public function customers(){
        return $this->belongsToMany(Customer::class);
    }

    public function savedRecipes(){
        return $this->hasMany(SavedRecipe::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function suppliers(){
        return $this->belongsToMany(Supplier::class);
    }
    public function purchaseProducts(){
        return $this->hasMany(PurchaseProduct::class);
    }

    public function statistic()
    {
        return $this->hasOne(Statistics::class);
    }

    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    /*public function types(){
        return $this->hasMany(Type::class);
    }*/

    public function owner(){   // custom function to get the owner of repository
        $users = $this->users; // relationship to get all repository users
        foreach($users as $user){
            if($user->hasRole('مالك-مخزن'))
                $owner = $user->name;
        }
        return $owner;
    }

    public function isSpecial(){
        if($this->category->name=='محل خاص')
            return true;
        else
            return false;
    }

    public function productsCount(){    // custom function calculate the count of products in repository
        $count = 0;
        $products = $this->products;
        foreach($products as $product){
            $count += $product->quantity; 
        }
        return $count;
    }

    // count of workers
    public function workersCount(){
        // all users except the owner
        $count = $this->users()->count() - 1;
        return $count;
    }

    // get the last daily_report date to check if the submit cashier will be available or not
    public function lastDailyReportDate(){
        $object = $this->dailyReportsDesc()->get();
        $day = $object[0]->created_at->format('d');
        return $day;
    }
    // calculate the time remaining to open cashier again
    public function timeRemaining(){
        $object = $this->dailyReportsDesc()->first();
        $t1 = now();
        $t2 = Carbon::parse($object->created_at)->addDays(1)->startOfDay();
        $diff = $t2->diff($t1);
        return $diff->h.__('cashier.hour').$diff->i.__('cashier.minute'); 
    }

    public function dailyInvoices(){
        return $this->hasMany(Invoice::class)->whereDate('created_at',now());
    }

    public function monthlyInvoices(){
        return $this->hasMany(Invoice::class)->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false);
    }

    public function dailyInvoicesCount(){
        $del = 0;
        $hang = 0;
        $retrieved = 0;
        $deleted = 0;
        $invoices = $this->dailyInvoices;
        foreach($invoices as $invoice){
            if($invoice->status=='delivered')
                $del+=1;
            elseif($invoice->status=='pending')
                $hang+=1;
            elseif($invoice->status=='retrieved')
                $retrieved+=1;
            elseif($invoice->status == 'deleted')
                $deleted+=1;
        }
        $arr = array('delivered'=>$del,'hanging'=>$hang,'retrieved'=>$retrieved,'deleted'=>$deleted);
        return $arr;
    }
    public function monthlyInvoicesCount(){
        $del = 0;
        $hang = 0;
        $retrieved = 0;
        $deleted = 0;
        $invoices = $this->monthlyInvoices;
        foreach($invoices as $invoice){
            if($invoice->status=='delivered')
                $del+=1;
            elseif($invoice->status=='pending')
                $hang+=1;
            elseif($invoice->status=='retrieved')
                $retrieved+=1;
            elseif($invoice->status == 'deleted')
                $deleted+=1;
        }
        $arr = array('delivered'=>$del,'hanging'=>$hang,'retrieved'=>$retrieved,'deleted'=>$deleted);
        return $arr;
    }

    /*public function isCashierWarning(){
       $daily_report = $this->dailyReportsDesc()->first();
       if($daily_report){
        $now = now();
        $created_at = $daily_report->created_at;
        $hours = $now->diffInHours($created_at);   // the number of hours between last daily report and NOW
        if($hours>30)
        return true;
        else
        return false;
       }
       else
       return false;
    }*/

    /*public function isCashierWarning(){
        $daily_report = $this->dailyReportsDesc()->first();
        if($daily_report){
         $now = now();
         $created_at = $daily_report->created_at;
         $year = $created_at->year;
         $month = $created_at->month;
         $day = $created_at->day;
         $time = $this->close_time;
         $datetime = new Carbon($year.'-'.$month.'-'.$day.''.$time);  // the date we will compare with
         $hours = $now->diffInHours($datetime);   // the number of hours between last daily report and NOW
         if($hours>29)  // giving the cashier addition time by 5 hours
            return true;
        else
            return false;
        }
        else
        return false;
     }*/


    /* public function CashierWarningDetails(){
        $warning = array('status'=>false,'hours'=>0);
        $daily_report = $this->dailyReportsDesc()->first();
        if($daily_report){
         $now = now();
         $created_at = $daily_report->created_at;
         $hour_in_report = $created_at->hour; // important
         $datetimeTemp = new Carbon('1994-07-10'.$this->close_time);  // make it random date to get hour
         $hour_in_close_time = $datetimeTemp->hour;
         $arr=array(0,1,2,3,4,5,6,7,8,9,10,11,12);
            if($hour_in_report < $hour_in_close_time && in_array($hour_in_report,$arr) && $hour_in_close_time >12){ // that mean the cashier is extended to another day from close time ex: close_time : 10:00 pm and submitted at 01:00 am
                $year = $created_at->year;
                $month = $created_at->month;
                $day = $created_at->day - 1;
                $time = $this->close_time;
                $datetime = new Carbon($year.'-'.$month.'-'.$day.''.$time);  // the date we will compare with
                $hours = $now->diffInHours($datetime);   // the number of hours between last daily report and NOW
                if($hours>30){  // giving the cashier addition time by 6 hours
                    $warning['status']=true;
                    $warning['hours']=$hours;
                    return $warning;
                }
                else
                return $warning;
            }
            else{   // the cashier submitted in same day of close_time ex: close_time : 10:00 pm and submitted at 11:00 pm
            $year = $created_at->year;
            $month = $created_at->month;
            $day = $created_at->day;
            $time = $this->close_time;
            $datetime = new Carbon($year.'-'.$month.'-'.$day.''.$time);  // the date we will compare with
            $hours = $now->diffInHours($datetime);   // the number of hours between last daily report and NOW
            if($hours>30){  // giving the cashier addition time by 6 hours
                    $warning['status']=true;
                    $warning['hours']=$hours;
                    return $warning;
            }
            else
                return $warning;
            }
        }
        else
        return $warning;
     }
     */
     public function CashierWarningDetails(){
        $warning = array('status'=>false,'hours'=>0);
        $daily_report = $this->dailyReportsDesc()->first();
        $datetimeTemp = new Carbon('1994-07-10'.$this->close_time);  // make it random date to get hour
        $hour_in_close_time = $datetimeTemp->hour;
        if($daily_report){
            $now = now();
            $created_at = $daily_report->created_at;
            $diff_in_hours = $created_at->diffInHours($now);
            if($diff_in_hours > 24){
                $h1 = $diff_in_hours - 24;
                $h2 = $created_at->hour - $hour_in_close_time;
                $h = $h1 + $h2;
                if($h > 6 ){
                    $warning['status']=true;
                    $warning['hours']=$h;  // تخطي الوقت المسموح به عن ساعة وقت الاغلاق بمقدار h
                    return $warning;
                } 
                else{
                    $warning['status']=false;
                    $warning['hours']=$h;
                    return $warning;
                }
            }
            else{
                $h = $now->hour - $hour_in_close_time;
                if($h > 6 ){
                    $warning['status']=true;
                    $warning['hours']=$h;  // تخطي الوقت المسموح به عن ساعة وقت الاغلاق بمقدار h
                    return $warning;
                } 
            }
        }
        else{  // there is no daily report
            $warning['status']=false;
            $warning['hours']='no problem for now';
            return $warning;
        }
    }

   /* public function todaySales(){
        $today_sales = 0;
       // $invoices = $this->invoices()->where('status','!=','retrieved')->where('transform','!=','p-d')->where('daily_report_check',false)->get();
       //$invoices = $this->invoices()->where('status','!=','retrieved')->where('daily_report_check',false)->get();
       $invoices = $this->invoices()->where('status','!=','retrieved')->
       where('status','!=','deleted')->where('daily_report_check',false)
       ->doesntHave('dailyReports')->get();
        foreach($invoices as $invoice){
            $today_sales += $invoice->total_price;
        }
        return $today_sales;
    } */

    public function todaySales(){
        $today_sales = 0;
       $invoices = $this->invoices()->where('status','!=','retrieved')->
       where('status','!=','deleted')->where('daily_report_check',false)
       ->doesntHave('dailyReports')->get();
        foreach($invoices as $invoice){
            // we must handle if this invoice has old register invoice by custom date so it doesnt have dailyreport but it must not taken by todaysales
            if($invoice->invoiceProcesses()->count()>0){
                $old_date = Carbon::createFromFormat('Y-m-d H:i:s', $invoice->invoiceProcesses[0]->created_at);
                $current_date = Carbon::createFromFormat('Y-m-d H:i:s', $invoice->created_at);
                $temp = $current_date->diff($old_date);  // عدد الايام بين تعديل الفاتورة اليوم ودورة حياتها السابقة
                if($temp->d > 1)
                    continue;
            }
            $today_sales += $invoice->total_price;
        }
        return $today_sales;
    }

    /*public function monthSales(){
       $month_sales = 0;
       $invoices = $this->invoices()->where('status','!=','retrieved')->
       where('status','!=','deleted')->where('monthly_report_check',false)
       ->whereYear('created_at',now()->year)->whereMonth('created_at',now()->month)
       ->get();
        foreach($invoices as $invoice){
            $month_sales += $invoice->total_price;
        }
        return $month_sales;
    }*/

    public function monthSales(){
        $month_sales = 0;
        $invoices = $this->invoices()->where('status','!=','retrieved')->
        where('status','!=','deleted')->where('monthly_report_check',false)
        ->whereYear('created_at',now()->year)->whereMonth('created_at',now()->month)
        ->get();
         foreach($invoices as $invoice){
             //يجب علينا ان نختبر في حال كانت الفاتورة مستكملة هذا الشهر ولكنها منشئة الشهر الماضي فلا يجب حسابها من مبيعات الشهر هذا
             if($invoice->invoiceProcesses()->count()>0)
             {
                 $old_process_date = $invoice->invoiceProcesses[0]->created_at;
                 $old_process_date = Carbon::createFromFormat('Y-m-d H:i:s', $old_process_date); 
                 if($old_process_date->month == now()->month && $old_process_date->year == now()->year) {         
                 $month_sales += $invoice->total_price;
                 continue;
                 }
             }
             else
                 $month_sales += $invoice->total_price;
         }
         return $month_sales;
     }

    public function yearSales(){
        $year_sales = 0;
        $invoices = $this->invoices()->where('status','!=','retrieved')->
        where('status','!=','deleted')
        ->whereYear('created_at',now()->year)
        ->get();
         foreach($invoices as $invoice){
             $year_sales += $invoice->total_price;
         }
         return $year_sales;
     }

    public function todayPendingMoney(){  // الأموال المعلقة
        $invoices = $this->invoices()->where('status','pending')->where('daily_report_check',false)->get();
        $total_price = 0 ;
        foreach($invoices as $invoice){
            $total_price = $total_price + ($invoice->total_price - ($invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount)) ;
        }
        return $total_price;
    }
    public function totalPendingMoney(){  
        $invoices = $this->invoices()->where('status','pending')->get();
        $total_price = 0 ;
        foreach($invoices as $invoice){
            $total_price = $total_price + ($invoice->total_price - ($invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount)) ;
        }
        return $total_price;
    }

    public function thisMonthGainedMoney(){
        $statistic = $this->statistic;
        if($statistic){
        $money = $statistic->m_in_cash_balance + $statistic->m_in_card_balance + $statistic->m_in_stc_balance;
        return $money;
        }
        return 'null';
    }

    public function thisMonthPendingMoney(){
        $money = 0;
        $invoices = $this->invoices()->where('status','pending')->where('monthly_report_check',false)
        ->whereYear('created_at',now()->year)->whereMonth('created_at',now()->month)
        ->get();
        foreach($invoices as $invoice){
            $money = $money + ($invoice->total_price - ($invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount)) ;
        }
        return $money;
    }

    public function thisYearGainedMoney(){
        $money=0;
        $invoices = $this->invoices()->where('status','!=','retrieved')->where('status','!=','deleted')->whereYear('created_at',now()->year)->get();
        foreach($invoices as $invoice){
            $money += $invoice->cash_amount + $invoice->card_amount + $invoice->stc_amount;
        }
        return $money;
    }

    /*public function todayPurchases(){
        $purchases = 0 ;
        $purchases_invoices = $this->purchases()->where('status','!=','retrieved')->whereDate('created_at', Carbon::today())->get();
        foreach($purchases_invoices as $inv){
            $purchases += $inv->total_price;
        }
        return $purchases;
    }*/

   /* public function todayPurchases(){
        $purchases = 0 ;
        $purchases_invoices = $this->purchases()->where('status','!=','retrieved')->where('daily_report_check',false)->doesntHave('dailyReports')->get();
        foreach($purchases_invoices as $inv){
            $purchases += $inv->total_price;
        }
        return $purchases;
    } */

    public function todayPurchases(){
        $purchases = 0 ;
        $purchases_invoices = $this->purchases()->where('status','!=','retrieved')->where('daily_report_check',false)->doesntHave('dailyReports')->get();
        foreach($purchases_invoices as $inv){
            // we must handle if this invoice has old register invoice by custom date so it doesnt have dailyreport but it payed in this day but must not taken by todaypurchases
            if($inv->created_at != $inv->updated_at){
                $old_date = Carbon::createFromFormat('Y-m-d H:i:s', $inv->created_at);
                $current_date = Carbon::createFromFormat('Y-m-d H:i:s', $inv->updated_at);
                $temp = $current_date->diff($old_date);  // عدد الايام بين تعديل الفاتورة اليوم ودورة حياتها السابقة
                if($temp->d > 1)
                    continue;
            }
            $purchases += $inv->total_price;
        }
        return $purchases;
    }

    public function monthPurchases(){
        $purchases = 0 ;
        $purchases_invoices = $this->purchases()->where('status','!=','retrieved')->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)->where('monthly_report_check',false)->get();
        foreach($purchases_invoices as $inv){
            $purchases += $inv->total_price;
        }
        return $purchases;
    }

    /*public function todayPayedMoney(){ // الاموال المدفوعة اليوم
        $payed = 0 ;
        $purchases_invoices = $this->purchases()->where('status','!=','retrieved')->where('payment','!=','later')->whereDate('created_at', Carbon::today())->get();
        foreach($purchases_invoices as $inv){
            $payed += $inv->total_price;
        }
        return $payed;
    }*/

    public function todayPayedMoney(){ // الاموال المدفوعة اليوم
        $payed = 0 ;
        $purchases_invoices = $this->purchases()->where('status','!=','retrieved')->where('payment','!=','later')->where('daily_report_check',false)->get();
        foreach($purchases_invoices as $inv){
            $payed += $inv->total_price;
        }
        return $payed;
    }

    public function pendingPayedMoney(){ // الاموال المعلقة الاجمالية  
        $payed = 0 ;
        $purchases_invoices = $this->purchases()->where('status','!=','retrieved')->where('payment','later')->get();
        foreach($purchases_invoices as $inv){
            $payed += $inv->total_price;
        }
        return $payed;
    }

    public function mostFiveSupplierShouldPay(){  // أكثر 5 موردين يجب الدفع لهم
        $purchases = Purchase::query()
        ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')  // relationship
        ->selectRaw('sum(purchases.total_price) as sum , supplier_id , suppliers.name')
        ->where('repository_id',$this->id)
        ->where('purchases.payment','later')
        ->where('purchases.status','!=','retrieved')
        ->groupBy('supplier_id','suppliers.name')
        ->orderBy('sum','DESC')
        ->take(5)
        ->get();  // get the total_price and supplier_id and suppliers.name grouped by supplier_id && suppliers.name
        
        return $purchases;
    }

   /* public function mostFivePendingInvoices(){    // اكثر 5 فواتير معلقة حسب المبلغ المتبقي للدفع
        $invoices = Invoice::where('repository_id',$this->id)->where('status','pending')
        ->whereRaw('total_price > cash_amount+card_amount+stc_amount')
        ->orderByRaw('(total_price - (cash_amount+card_amount+stc_amount)) DESC')
        ->take(5)
        ->get();
        return $invoices;
    } */

    public function mostFivePendingInvoices(){    // اكثر 5 عملاء عليهم اموال معلقة
        $invoices = Invoice::query()
        ->join('customers', 'customers.id', '=', 'invoices.customer_id')  // relationship
        ->selectRaw('sum(invoices.total_price - (invoices.cash_amount + invoices.card_amount +invoices.stc_amount)) as sum , customer_id , customers.name')
        ->where('invoices.repository_id',$this->id)
        ->where('invoices.status','pending')
        ->whereRaw('invoices.total_price > invoices.cash_amount+invoices.card_amount+invoices.stc_amount')
        ->groupBy('customer_id','customers.name')
        ->orderBy('sum','DESC')
        ->take(5)
        ->get();
        return $invoices;
    }
}
