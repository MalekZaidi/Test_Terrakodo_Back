<?php

namespace Database\Factories;

use App\Models\Jardin;
use Illuminate\Database\Eloquent\Factories\Factory;

class JardinFactory extends Factory
{
    protected $model = Jardin::class;

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
            'adresse' => $this->faker->address(),
            'image' => $this->faker->imageUrl(), // Génère une URL d'image factice
        ];
    }
}
