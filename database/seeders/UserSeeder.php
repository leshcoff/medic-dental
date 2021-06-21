<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Demo',
            'email' => 'demo@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
    }
}
