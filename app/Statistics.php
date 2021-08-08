<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    //
    protected $fillable = [
        'repository_id','m_in_cash_balance', 'm_in_card_balance','m_in_stc_balance','d_out_cashier','d_out_external',
    ];

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
