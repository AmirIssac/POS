<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
        'repository_id', 'print_prescription','discount_by_percent','discount_by_value', 
    ];

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
