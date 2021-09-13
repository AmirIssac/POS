<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    public function repositories(){
        return $this->hasMany(Repository::class);
    }
}
