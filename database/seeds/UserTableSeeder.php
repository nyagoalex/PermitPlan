<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = array('first_name' => 'ALEX','last_name' => 'NYAGO','username' => 'alex',
        'phone' => '256786911269','password' => Hash::make('2222'),'id' => 1,
        'last_pass_reset_date' => Carbon\Carbon::today(),'status' => 'active','email' => 'alex@laceltech.com');
        
        User::firstOrCreate(['id' => 1], $user);
    }
}
