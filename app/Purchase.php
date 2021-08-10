<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    protected $fillable = [
        'repository_id','user_id','supplier_id','code','supplier_invoice_num','total_price','payment','status','daily_report_check','monthly_report_check',
    ];
    public function purchaseRecords(){
        return $this->hasMany(PurchaseRecord::class);
    }
    public function supplier(){ 
        return $this->belongsTo(Supplier::class);
    }
    public function repository(){ 
        return $this->belongsTo(Repository::class);
    }
    public function user(){ 
        return $this->belongsTo(User::class);
    }
    public function dailyReports(){
        return $this->belongsToMany(DailyReport::class,'daily_report_purchase');
    }
    public function monthlyReports(){
        return $this->belongsToMany(MonthlyReport::class,'monthly_report_purchase');
    }
}
