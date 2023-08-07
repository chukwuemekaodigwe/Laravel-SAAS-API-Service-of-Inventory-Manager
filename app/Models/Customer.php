<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Customer extends Model
{
    use HasFactory;  use SoftDeletes;

    protected $fillable = ['name', 'phone', 'address', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }

    public static function new_customer($customer)
    {

        $customer =  Customer::updateOrCreate([
            'phone' => $customer['phone'],
            'company_id' => Auth::user()->company->id
        ], [
            'name' => $customer['name'],
            'address' => $customer['address'],
            
        ]);

        return $customer;
    }
}
