<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $value = $this->faker->dateTimeInInterval('-5 months','+4 months');
        return [
            'rating' => random_int(1,5),
            'comment' => $this->faker->paragraph(random_int(1,3)),
            'created_at' => $value,
        ];
    }
}
