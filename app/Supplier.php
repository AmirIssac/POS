<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name', 'address','phone','account_num',
    ];
    //
    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function repositories(){
        return $this->belongsToMany(Repository::class);
    }
}
