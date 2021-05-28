<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionCategory extends Model
{
    //
    public function permissions(){
        return $this->hasMany(PermissionCustom::class,'category_id', 'id');
    }
}
