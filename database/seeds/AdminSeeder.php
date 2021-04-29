<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =  User::create([
            'name' => 'Amir Ishak',
            'email' => 'amir@demo.com',
            'password' => Hash::make('500500'),
            'phone' => '0997846480'
        ]);
            $user->assignRole('مشرف');
    }
}
