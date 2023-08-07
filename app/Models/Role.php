<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = [
        'title', 'permissions', 'company_id', 'created_by'
    ];

    public function users(){
        return $this->hasMany(User::class, 'role');
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function permissions(){
        return $this->permissions();
    }
}
