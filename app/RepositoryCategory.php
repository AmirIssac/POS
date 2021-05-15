<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepositoryCategory extends Model
{
    //
    public function repositories(){
        return $this->hasMany(Repository::class,'category_id', 'id');
    }
}
