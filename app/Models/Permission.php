<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Permission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title', 'pseudo', 'description',
        'area'
    ];

    public static function createPermissionTable()
    {

        $i = 0;
        $p = [
            'income', 'expenses', 'fund transfer', 'payments',
            'sales', 'stock', 'products', 'employees', 'user roles',
            'branches', 'ledger', 'notifications', 'product returns',
            'others records', 'own records', 'branch records', 'other branch records',
            'subscription', 'company details', 'all records'
        ];

        $area = ['add', 'view', 'edit', 'delete'];

        foreach ($p as $value) {
            $value1 = str_ireplace(' ', '_', $value);
            foreach ($area as $t) {
                Permission::create([
                    'title' => "can $t $value",
                    'pseudo' => 'can_' . $t . '_' . $value1,
                    'description' => 'This user would be able to ' . $t . ' ' . $value,
                    'area' => $value1

                ]);
                $i++;
            }
        }

        return $i;
    }

    public function hasPermission($per)
    {
        $roles = Auth::user()->role;

        if (in_array($per, $roles)) {
            return true;
        } else {
            return false;
        }
    }
}
