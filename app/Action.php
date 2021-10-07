<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected  $fillable = ['name_ar','name_en','type'];
    //
    public function records(){    // انتبه من جلب السجلات من دون تحديد id المتجر
        return $this->hasMany(Record::class);
    }
}
