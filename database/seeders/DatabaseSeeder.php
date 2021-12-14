<?php

namespace Database\Seeders;

use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $faker = Faker::create();
        foreach (range(1, 200) as $index) {
            $new_prov = new Provider();
            $new_prov->admin_id = 1;
            $new_prov->practice_id = 10;
            $new_prov->full_name = "Provider" . ' ' . $index;
            $new_prov->first_name = "Provider";
            $new_prov->last_name = $index;
            $new_prov->dob = Carbon::now()->format('Y-m-d');
            $new_prov->gender = "Male";
            $new_prov->save();
        }
    }
}
