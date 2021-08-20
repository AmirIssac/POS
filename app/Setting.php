<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
        'repository_id', 'print_prescription',
    ];

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
