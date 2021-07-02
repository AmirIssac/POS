<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    public function purchaseRecords(){
        return $this->hasMany(PurchaseRecord::class);
    }
    public function supplier(){ 
        return $this->belongsTo(Supplier::class);
    }
    public function repository(){ 
        return $this->belongsTo(Repository::class);
    }
}
