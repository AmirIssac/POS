<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRecord extends Model
{
    //
    public function purchase(){ 
        return $this->belongsTo(Purchase::class);
    }
}
