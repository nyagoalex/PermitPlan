<?php

use App\Models\PermitType;
use Illuminate\Database\Seeder;

class PermitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permit_types = [
           ['name' => 'gorilla_permits'],
           ['name' => 'golden_monkey_permits'],
           ['name' => 'chimpanzee_permits'],
           ['name' => 'gorilla_habituation'],
           ['name' => 'chimpanzee_habituation'],
        ];
        foreach ($permit_types as $permit_type) {
            PermitType::firstOrCreate($permit_type);
        }
    }
}
