<?php

namespace Database\Factories;

use App\Models\EMPaciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class EMPacienteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EMPaciente::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      => $this->faker->name,
            'lastname'  => $this->faker->lastName,
            'email'  => $this->faker->email,
            'phone'  => $this->faker->phoneNumber,
            //'gender'  => $this->faker->randomNumber(1,2),
            //'birthday'  => $this->faker->bir

            //'url' => Str::slug($this->faker->name),
            'address' => $this->faker->name,
            'notes' => $this->faker->text,
        ];
    }
}
