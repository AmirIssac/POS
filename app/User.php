<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function repositories(){
        return $this->belongsToMany(Repository::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
    public function dailyReports(){
        return $this->hasMany(DailyReport::class);
    }
    public function monthlyReports(){
        return $this->hasMany(MonthlyReport::class);
    }
    public function savedRecipes(){
        return $this->hasMany(SavedRecipe::class);
    }
    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
}
