<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'title', 'description', 'amount', 'employee',
        'company_id', 'branch_id', 'registry_id', 'type',
        'payment_method', 'misc', 'ledger_date'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function registry()
    {
        return $this->belongsTo(Registry::class);
    }

    public static function search($search, $branch, $date='')
    {
        $result = Auth::user()->company->expenses()
            ->join('users', 'users.id', '=', 'expenses.employee')
           // ->whereDate('expenses.created_at', date('Y-m-d', strtotime('2023-09-09')), true)
            
            ->where('expenses.branch_id', $branch)
            ->where('expenses.title', 'LIKE', "%$search%")
            ->orWhere('expenses.description', 'LIKE', "%$search%")
            ->orWhere('expenses.amount', 'LIKE', "%$search%")
            ->orWhere('expenses.type', 'LIKE', "%$search%")
            ->orWhere('expenses.payment_method', 'LIKE', "%$search%")
            ->orWhere('expenses.misc', 'LIKE', "%$search%")
            ->orWhere('users.name', 'LIKE', "$search%")
            ->select('expenses.*')
            ->orderBy('expenses.id', 'desc')
            ->get();


        return $result;
    }

    public static function saveExpenses($detail, $branch){
        $active_date = Registry::find($detail['registry'])->time_opened;
        if (empty($detail['misc'])) {
            $detail['misc'] = '';
        }

        $expense =  Auth::user()->company->expenses()->create([
            'title' => $detail['title'],
            'description' => $detail['desc'],
            'amount' => $detail['amount'],
            'employee' => Auth::user()->id,
            'branch_id' => $branch,
            'registry_id' => $detail['registry'],
            'type' => $detail['type'],
            'payment_method' => $detail['p_method'],
            'misc' => json_encode($detail['misc']),
            'ledger_date' => date('Y-m-d', strtotime($active_date))
        ]);

        return $expense;
    }
}
