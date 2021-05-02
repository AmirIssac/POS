<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
       'repository_id','barcode','name', 'details' ,'price','quantity',
    ];

    public function repository(){
        return $this->belongsTo(Repository::class);
    }
}
