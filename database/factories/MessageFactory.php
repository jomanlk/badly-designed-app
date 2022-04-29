<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::pluck('id')->random(1)->get(0),
            'message' => $this->faker->text(),
            'heart_total' => 0,
            'channels' => function() {
                $channels = ['arts', 'tech', 'social', 'sports', 'gaming', 'politics', 'food', 'kids'];
                shuffle($channels);
                return implode(' ', array_slice($channels, 0, 3));
            }, // password
        ];
    }
}
