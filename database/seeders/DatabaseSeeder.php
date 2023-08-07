<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $parts = [
            ['Basic', 10000, 2, 1, 0, false, 1],
            ['Standard', 20000, 3, 1, 0, false, 1],
            ['Premium', 120000, 5, 2, 1, true, 1],
            ['Elite', 300000, 10, 5, 2, true, 1],
            ['Enterprise', 10000, 2, 1, 0, false, 1]
        ];

        foreach($parts as $value){

            \App\Models\Plan::create([
            'title' => $value[0],
            'transactions' => $value[1],
            'users' => $value[2],
            'branches' => $value[3],
            'auditor' => $value[4],
            'exportable' => $value[5],
            'status' => $value[6]
            ]);
        };


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
                \App\Models\Permission::create([
                    'title' => "can $t $value",
                    'pseudo' => 'can_'.$t.'_'.$value1,
                    'description' => 'This user would be able to '.$t.' '.$value,
                    'area' => $value1
                    
                ]);
            }
        }


    }
}
