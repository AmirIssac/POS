<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    protected $fillable = [
        'repository_id','user_id','supplier_id','code','supplier_invoice_num','total_price','payment',
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
}
