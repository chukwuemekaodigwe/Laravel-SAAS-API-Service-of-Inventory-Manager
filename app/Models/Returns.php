<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Returns extends Model
{
    use HasFactory; use SoftDeletes;

   protected $fillable = ['order_id', 'amount_repaid', 
   'company_id', 'branch_id', 'employee', 'customer_id', 'ledger_date',
   'stockBehaviour', 'order_no', 'details', 'reason'];

   public function company(){
    return $this->belongsTo(Company::class);
   }

   public function branch(){
    return $this->belongsTo(Branch::class);
   }

   public function order(){
    return $this->belongsTo(Order::class);
   }

   public function registry(){
    return $this->belongsTo(Registry::class);
   }

   public function customer(){
    return $this->belongsTo(Customer::class);
   }

}
