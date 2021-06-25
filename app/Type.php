<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name_ar', 'name_en', 
    ];
    //
    /*public function repository(){
        return $this->belongsTo(Repository::class);
    }*/
    public function products(){
        return $this->hasMany(Product::class);
    }
}
