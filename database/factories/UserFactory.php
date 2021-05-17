<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if (!User::whereEmail('admin@example.com')->first()) {
            $faker = \Faker\Factory::create();

            User::create([
                'name' => $faker->name,
                'role' => User::ADMIN_ROLE,
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'password' => bcrypt('12345678')
            ]);


        }

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'role' => User::USER_ROLE,
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
