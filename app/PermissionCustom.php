<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Contracts\Permission as ContractsPermission;
use Spatie\Permission\Models\Permission;

class PermissionCustom extends Permission
{
    protected $fillable = [
         'name','guard_name','category_id',
    ];
    public function category(){
        return $this->belongsTo(PermissionCategory::class);
    }
}
