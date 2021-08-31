<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RofoodAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =  User::create([
            'name' => 'Abdullah Alkenany',
            'email' => 'abdullah@rofood.co',
            'password' => Hash::make('dd500500'),
            'phone' => '+966509016572'
        ]);
            $user->assignRole('مشرف');
    }
    
}
