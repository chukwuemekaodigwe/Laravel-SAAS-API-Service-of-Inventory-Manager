<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = [
        'invoice_no', 'status', 'payments', 'total_payable', 'customer_id',
        'order_id', 'total', 'branch_id', 'user_id', 'company_id', 'order_no',
        'amount_paid', 'remainder', 'discount', 'payment_method', 'registry_id', 'tax', 'ledger_date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function company()
    {
        return $this->belongsTo(Compaany::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
