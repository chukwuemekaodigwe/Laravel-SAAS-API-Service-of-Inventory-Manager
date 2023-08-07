<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
class Product extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = [
        'name', 'sku', 'sellingprice',
        'alert_level', 'costprice', 'image', 'type', 'units'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public static function newProduct($request)
    {
//return Auth::user()->company->id;
        
        return $new;
    }
}
