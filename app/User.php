<?php

namespace App;

use Carbon\Carbon;
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
        'name', 'email', 'password','phone','last_login','last_login_old','is_online','last_logout',
    ];

    protected $dates = ['last_login','last_login_old','last_logout'];

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
    public function invoiceProcesses(){
        return $this->hasMany(InvoiceProcess::class);
    }

    public function last_login_old(){
        //$dateTime = Carbon::createFromFormat('F j, Y, g:i a', $this->last_login_old);
        $dateTime =$this->last_login_old;
        //$dateTime = Carbon::createFromFormat('D, d M Y H:i:s e', $dateTime)->toDateTimeString();
        $dateTime = $dateTime->format('Y-m-d, g:i A');
        return $dateTime;
    }

    public function last_login(){
        $dateTime =$this->last_login;
        $dateTime = $dateTime->format('Y-m-d, g:i A');
        return $dateTime;
    }

    public function last_logout(){
        $dateTime =$this->last_logout;
        $dateTime = $dateTime->format('Y-m-d, g:i A');
        return $dateTime;
    }
}
