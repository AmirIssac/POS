<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRecord extends Model
{
    //
    protected $fillable = [
        'purchase_id','barcode','name','quantity','price',
    ];

    public function purchase(){ 
        return $this->belongsTo(Purchase::class);
    }
}
