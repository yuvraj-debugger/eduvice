<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class SingaporeCity extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       City::create([
            "name" => "Jofra Archer",
            "email" => "archer@ecb.com",
            "password" => bcrypt("55555")
        ]);
    }
    }
}
