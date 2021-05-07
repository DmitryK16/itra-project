<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (empty(News::first())) {
            $faker = \Faker\Factory::create();
            News::factory()->count(10)->create()->each(function ($news) use ($faker) {
                /** @var Company $company */
                $news->company()->saveMany(Company::find(Company::where('id', $faker->numberBetween(1, 10))->get()));
            });
        }
    }
}
