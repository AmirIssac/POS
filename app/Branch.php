<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    protected $fillable = [
        'company_code','name',
    ];

    public function repositories(){
        return $this->hasMany(Repository::class);
    }
}
