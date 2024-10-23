<?php

namespace Database\Factories;

use App\Models\Evenement;
use App\Models\Jardin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvenementFactory extends Factory
{
    protected $model = Evenement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'date' => $this->faker->dateTimeBetween('now', '+1 year'), // Date aléatoire entre aujourd'hui et un an plus tard
            'jardin_id' => Jardin::factory(), // Associe un événement à un jardin
            'user_id' => User::factory(), // Associe un utilisateur à l'événement
        ];
    }
}
