<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = ['title', 'address', 'city', 'admin', 'company_id'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin');
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
    
    public static function createNew($req, $user){
        $new = Branch::create([
            'title' => 'Main Office',
            'address' => $req->company_address,
            'admin' => $user->id,
            'company_id' => $user->company,
        ]);

        return $new;
    }

    public function incomes(){
        return $this->hasMany(Income::class);

    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function registries(){
        return $this->hasMany(Registry::class);
    }

    public function returns(){
        return $this->hasMany(Returns::class);
    }
}
