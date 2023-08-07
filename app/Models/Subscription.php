<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = ['company_id', 'plan_id',
'referenceNo', 'paymentRef', 'amount', 'agent_id', 'durationInMonths', 'start_date',
'end_date', 'payment_status'
];


public function plan(){
    return $this->belongsTo(Plan::class);
}

public function company(){
    return $this->belongsTo(Company::class);
}

public function agent(){
    return $this->belongsTo(Agent::class);
}

    
}
