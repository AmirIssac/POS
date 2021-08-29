<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
       'repository_id','type_id','barcode','name_ar', 'name_en' ,'cost_price','price','quantity','accept_min',
       'stored',
    ];

    public function repository(){
        return $this->belongsTo(Repository::class);
    }
    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function isAcceptMin(){
        if($this->accept_min==1)
            return true;
        else
            return false;
    }
}
