<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    protected $fillable = [
        'repository_id','user_id','cash_balance','card_balance','stc_balance','out_cashier','out_external',
    ];
    //
    public function repository(){
        return $this->belongsTo(Repository::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function invoices(){
        return $this->belongsToMany(Invoice::class,'invoice_monthly_report');
    }
    public function purchases(){
        return $this->belongsToMany(Purchase::class,'monthly_report_purchase');
    }
}
