<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parts = [
            ['Basic', 10000, 2, 1, 0, false, 1],
            ['Standard', 20000, 3, 1, 0, false, 1],
            ['Premium', 120000, 5, 2, 1, true, 1],
            ['Elite', 300000, 10, 5, 2, true, 1],
            ['Enterprise', 10000, 2, 1, 0, false, 1]
        ];

        foreach($parts as $value){

            return [
            'title' => $value[0],
            'transactions' => $value[1],
            'users' => $value[2],
            'branches' => $value[3],
            'auditor' => $value[4],
            'exportable' => $value[5],
            'status' => $value[6]
            ];
        };

    }
}
