<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $p = [
            'income', 'expenses', 'fund transfer', 'payments',
            'sales', 'stock', 'products', 'employees', 'user roles',
            'branches', 'ledger', 'notifications', 'product returns',
            'others records', 'own records', 'branch records', 'other branch records',
            'subscription', 'company details', 'sales summary'
        ];

        $area = ['add', 'view', 'edit', 'delete'];

        foreach ($p as $value) {
            $value1 = str_ireplace(' ', '_', $value);
            foreach ($area as $t) {
                return [
                    'title' => "can $t $value",
                    'pseudo' => 'can_'.$t.'_'.$value1,
                    'description' => 'This user would be able to '.$t.' '.$value,
                    'area' => $value1
                    
                ];
            }
        }
    }

}
