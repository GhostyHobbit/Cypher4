<?php

namespace Database\Factories;

use App\Models\Stack;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StackFactory extends Factory
{
    protected $model = Stack::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'user_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
