<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected  $fillable = ['repository_id','user_id','action_id','note'];
    //
    public function action(){
        return $this->belongsTo(Action::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function repository(){
        return $this->belongsTo(Repository::class);
    }
}
