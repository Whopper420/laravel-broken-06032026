<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PostStatus;

class PostStatusFactory extends Factory
{

    public function definition()
    {
        $statuses = ['published', 'draft', 'scheduled', 'review', 'archived', 'deleted'];

        return [
            'status' => $this->faker->randomElement($statuses)
        ];
    }
}