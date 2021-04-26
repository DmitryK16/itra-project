<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'list_bonus' => [],
            'small_descriptions' =>$this->faker->text,
            'video' =>$this->faker->url,
            'img' =>$this->faker->imageUrl(),
            'amount' => round($this->faker->randomFloat(null, 10, 1200), 2),
            'user_id' =>$this->faker->numberBetween(1, 10)
        ];
    }
}
