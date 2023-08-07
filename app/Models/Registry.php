<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Registry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'branch_id', 'cash_sales', 'opened_by',
        'closed_by', 'time_opened', 'time_closed', 'opening_amt',
        'closing_amt', 'opening_note', 'reg_code', 'total_exp',
        'total_income', 'status', 'expenses', 'incomes',
        'bank_sales', 'cheque_sales', 'debts', 'receive_payments',
        'returns', 'transfer',
        'closing_note'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }


    public function returns()
    {
        return $this->hasMany(Returns::class);
    }

    public static function getActiveRegistry($branch)
    {
        $reg = Auth::user()->company->registries()
            ->where('branch_id', $branch)
            ->where('status', 0)
            ->first();

        return $reg;
    }
}
