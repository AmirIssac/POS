<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceProcess extends Model
{
    //
    protected $fillable = [
        'repository_id','invoice_id','user_id','details','cash_amount','card_amount','stc_amount','status','created_at','note',
    ];
    public $timestamps = false;

    public function repository(){
        return $this->belongsTo(Repository::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
