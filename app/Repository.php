<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $fillable = [
        'name', 'address','category_id','cash_balance','card_balance',
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


    public function owner(){   // custom function to get the owner of repository
        $users = $this->users; // relationship to get all repository users
        foreach($users as $user){
            if($user->hasRole('مالك-مخزن'))
                $owner = $user->name;
        }
        return $owner;
    }
    public function productsCount(){    // custom function calculate the count of products in repository
        $count = 0;
        $products = $this->products;
        foreach($products as $product){
            $count += $product->quantity; 
        }
        return $count;
    }
}
