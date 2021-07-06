<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    
    protected $fillable = [
        'repository_id','barcode','name_ar', 'name_en' ,'price',
     ];
 
     public function repository(){
         return $this->belongsTo(Repository::class);
     }
}
