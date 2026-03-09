<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostStatus;

class PostStatusSeeder extends Seeder
{
    public function run()
    {
        PostStatus::factory()->count(20)->create();
    }
}
