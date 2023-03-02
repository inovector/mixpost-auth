<?php

namespace Inovector\MixpostAuth\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Inovector\MixpostAuth\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
