<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = ['qty', 'price', 'order_id', 'product_id', 'ledger_date',
    'employee', 'company_id', 'invoice_no', 'cost_price', 'branch_id', 'customer_id' ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }



}
