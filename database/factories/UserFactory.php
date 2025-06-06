<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'userid' => 'user_' . $this->faker->unique()->word(),
            'term_id' => 1, // テスト時に正しく設定すること（必要に応じてfactory内で作ってもOK）
            'password' => bcrypt('password123'),
        ];
    }
}
