<?php

namespace Database\Seeders;

use App\Models\EMGenero;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CatGeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EMGenero::create([
            'id' => '1',
            'name' => 'Masculino',
            'created_at'    => now()
        ]);

        EMGenero::create(['id' => '2',
            'name' => 'Femenino',
            'created_at'    => now()
        ]);

        $faker = Faker\Factory::create();

    }
}
