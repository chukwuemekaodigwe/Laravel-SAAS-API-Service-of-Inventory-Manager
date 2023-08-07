<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = [
        'title', 'transactions', 'users', 
        'branches'. 'auditor', 'exportable',
        'status', 'misc', 'amount'
    ];

    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

}
