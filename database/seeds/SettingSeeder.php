<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
           //the rest of the columns have default values and will inserted as expected
           Setting::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Company name',
                'physical_address' => 'P.O BOX 1, Kampala Uganda',
                'registration_no' => '0',
                'phone' => '256 700943112',
                'sub_domain' => $faker->domainWord,
            ]
        );
    }
}
