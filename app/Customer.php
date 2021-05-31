<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = [
        'name', 'phone','num_of_buying'
    ];

    public function repositories(){
        return $this->belongsToMany(Repository::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
