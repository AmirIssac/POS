<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
       'repository_id','barcode','name', 'details' ,'cost_price','price','quantity','accept_min'
    ];

    public function repository(){
        return $this->belongsTo(Repository::class);
    }
}
