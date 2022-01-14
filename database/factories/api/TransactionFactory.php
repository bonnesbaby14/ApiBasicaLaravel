<?php

namespace Database\Factories\Api;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = \App\Models\api\Transaction::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "mount" => $this->faker->numerify("###.##"),
            "isEgress" => $this->faker->boolean(),
        ];
    }
}
