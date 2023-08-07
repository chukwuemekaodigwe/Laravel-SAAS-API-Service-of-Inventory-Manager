<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'address', 'phone', 'subscription', 'email', 'colors',
        'country', 'city', 'logo', 'currency', 'timezone', 'registry_by_user', 'admin'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function registries()
    {
        return $this->hasMany(Registry::class);
    }

    public function returns()
    {
        return $this->hasMany(Returns::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getPlanDetails()
    {
        $sub = Auth::user()->company->subscription;
        $plan = Plan::find($sub);
        return $plan;
    }


    public static function createNew($request, $user)
    {

        $request->validate([
            'name' => ['required'],
            'logo[0]' => ['image', 'max:1024', 'mimes:jpg,gif,bmp,png']
        ]);

        $new = Company::create([
            'name' => $request->company_name,
            'address' => $request->company_address,
            'phone' => $request->company_phone,
            'logo' => $request->logo[0]->store('public/logos'),
            'currency' => $request->currency,
            'admin' => $user->id
        ]);

        return $new;
    }
}
