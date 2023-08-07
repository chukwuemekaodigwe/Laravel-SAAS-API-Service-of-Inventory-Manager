<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'subscription',
        'email', 'role_id', 'company_id',
        'password', 'phone', 'branch_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function branches(){
        return $this->hasMany(Branch::class, 'admin');
    }

    public function registries(){
        return $this->hasMany(Registry::class, 'opened_by');
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public static function permissions(){
        $role = Role::find(Auth::user()->role);
        return $role['permission'];

    }

    public static function userRole(){
        return Role::find(Auth::user()->role);
    }
}
