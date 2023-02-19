<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(5),
            'descripcion' => $this->faker->sentence(20),
            'imagen' => $this->faker->uuid() . '.jpg',
            'user_id' => $this->faker->randomElement([8, 9]), // toma un numero aleatorio el id de un usuario existente en la BD 
        ];
    }
}
