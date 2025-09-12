<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Profile;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'userid'   => $this->faker->unique()->userName(),
            'password' => Hash::make('password123'),
            'term_id'  => 1,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            ProfileFactory::new()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}