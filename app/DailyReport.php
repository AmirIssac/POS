<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = [
        'repository_id','user_id','cash_balance', 'card_balance','stc_balance','cash_shortage','card_shortage','stc_shortage','cash_plus','card_plus','stc_plus',
    ];
    //
    public function repository(){
        return $this->belongsTo(Repository::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function invoices(){
        return $this->belongsToMany(Invoice::class,'daily_report_invoice');
    }
}
