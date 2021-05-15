<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'repository_id','user_id', 'details','total_price','cash_check','card_check','cash_amount','card_amount','status','phone','created_at',
    ];
    
    public $timestamps = false;

    public function repository(){
        return $this->belongsTo(Repository::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
