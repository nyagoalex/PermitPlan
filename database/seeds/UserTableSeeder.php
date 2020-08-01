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
        'phone' => '256786911269','password' => Hash::make('2222'),
        'last_pass_reset_date' => Carbon\Carbon::today(),'active' => true,'email' => 'alex@laceltech.com');
        
        // User::firstOrCreate(['id' => '6bd47133-70b6-470a-b314-2a9f6a85ab78'], $user);
        User::firstOrCreate(['id' => 1], $user);
    }
}
