<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $fillable = [
        'name', 'address','category_id','cash_balance','card_balance','min_payment','tax','tax_code','logo',
    ];
    //
    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
    public function productsAsc(){
        return $this->hasMany(Product::class)->orderBy('quantity');
    }
    public function category(){ 
        return $this->belongsTo(RepositoryCategory::class);
    }
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
    public function invoicesDesc(){
        return $this->hasMany(Invoice::class)->orderBy('created_at','DESC');
    }
    public function dailyReports(){
        return $this->hasMany(DailyReport::class);
    }

    public function dailyReportsDesc(){
        return $this->hasMany(DailyReport::class)->orderBy('created_at','DESC');
    }

    public function customers(){
        return $this->belongsToMany(Customer::class);
    }

    public function savedRecipes(){
        return $this->hasMany(SavedRecipe::class);
    }

    public function types(){
        return $this->hasMany(Type::class);
    }

    public function owner(){   // custom function to get the owner of repository
        $users = $this->users; // relationship to get all repository users
        foreach($users as $user){
            if($user->hasRole('مالك-مخزن'))
                $owner = $user->name;
        }
        return $owner;
    }

    public function isSpecial(){
        if($this->category->name=='محل خاص')
            return true;
        else
            return false;
    }

    public function productsCount(){    // custom function calculate the count of products in repository
        $count = 0;
        $products = $this->products;
        foreach($products as $product){
            $count += $product->quantity; 
        }
        return $count;
    }

    // count of workers
    public function workersCount(){
        // all users except the owner
        $count = $this->users()->count() - 1;
        return $count;
    }

    // get the last daily_report date to check if the submit cashier will be available or not
    public function lastDailyReportDate(){
        $object = $this->dailyReportsDesc()->get();
        $day = $object[0]->created_at->format('d');
        return $day;
    }
    // calculate the time remaining to open cashier again
    public function timeRemaining(){
        $object = $this->dailyReportsDesc()->first();
        $t1 = now();
        $t2 = Carbon::parse($object->created_at)->addDays(1)->startOfDay();
        $diff = $t2->diff($t1);
        return $diff->h.__('cashier.hour').$diff->i.__('cashier.minute'); 
    }
}
