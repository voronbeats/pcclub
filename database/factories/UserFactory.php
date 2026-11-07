<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'phone' => '+7' . fake()->unique()->numerify('9#########'),
            'password' => Hash::make('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ];
    }
}
