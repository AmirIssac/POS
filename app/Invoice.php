<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'repository_id','user_id','customer_id','code', 'details','recipe','total_price','cash_check','card_check','cash_amount','card_amount','status','phone','created_at','daily_report_check'
    ];
    
    public $timestamps = false;

    public function repository(){
        return $this->belongsTo(Repository::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function dailyReports(){
        return $this->belongsToMany(DailyReport::class,'daily_report_invoice');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}