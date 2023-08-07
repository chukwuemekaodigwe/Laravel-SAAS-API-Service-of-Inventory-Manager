<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Income extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'amount', 'employee', 'ledger_date',
        'company_id', 'branch_id', 'registry_id', 'type',
        'payment_method', 'misc'
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

    public static function search($search, $branch, $date = '')
    {
        $result = Auth::user()->company->incomes()
            ->join('users', 'users.id', '=', 'incomes.employee')
            ->select('incomes.*')
            ->where('incomes.branch_id', $branch)
            ->where('incomes.title', 'LIKE', "%$search%")
            ->orWhere('incomes.amount', 'LIKE', "%$search%")
            ->orWhere('incomes.description', 'LIKE', "%$search%")
            ->orWhere('incomes.type', 'LIKE', "%$search%")
            ->orWhere('incomes.payment_method', 'LIKE', "%$search%")
            ->orWhere('incomes.misc', 'LIKE', "%$search%")
            ->orWhere('users.name', 'LIKE', "$search%")
            ->when(!empty($date), function ($query) {
                return $query->whereDate('incomes.ledger_date', date('Y-m-d', strtotime('today')));
            })
            ->orderBy('incomes.id', 'desc')
            ->get();



        return $result;
    }


    public static function sumIncome($branch, $reg_id, $byMonth = '')
    {
        $month = date('m', strtotime('today'));
        $date = date('Y-m-d', strtotime('today'));
        $result = Auth::user()->company->incomes()
            ->where('branch_id', $branch);

            if(!empty($byMonth)){
                $result->whereMonth('incomes.ledger_date', '=', date('m', strtotime('today')));
            }else{
                $result->whereDate('incomes.ledger_date', date('Y-m-d', strtotime('today')));
            }
            
            
            $a = $result->sum('amount');

        return $a;
    }


    public static function sumSales($branch, $reg_id, $byMonth = '')
    {
        $month = date('m', strtotime('today'));
        $result = Auth::user()->company->incomes()
            ->where('type', 'sales')
            ->where('branch_id', $branch);

            if(!empty($byMonth)){
                $result->whereMonth('incomes.ledger_date', '=', date('m', strtotime('today')));
            }else{
                $result->whereDate('incomes.ledger_date', date('Y-m-d', strtotime('today')));
            }
            
            
            $a = $result->sum('amount');

        return $a;
    }

    public static function countSales($branch, $reg_id, $byMonth = '')
    {
        //return $reg_id;
        $month = date('m', strtotime('today'));
        $result = Auth::user()->company->orders()
            ->where('branch_id', $branch);

            if(!empty($byMonth)){
                $result->whereMonth('orders.ledger_date', '=', date('m', strtotime('today')));
            }else{
                $result->whereDate('orders.ledger_date', date('Y-m-d', strtotime('today')));
            }
            
            $a = $result->count('id');
        return $a;
    }

    public static function saveIncome($details, $branch){
        $active_date = Registry::find($details['registry'])->time_opened;

        $income = Auth::user()->company->incomes()->create([
            'title' => $details['title'],
            'description' => $details['desc'],
            'amount' => $details['amount'],
            'employee' => Auth::user()->id,
            'branch_id' => $branch,
            'registry_id' => $details['registry'],
            'type' => $details['type'],
            'payment_method' => $details['p_method'],
            'misc' => $details['misc'],
            'ledger_date' => date('Y-m-d', strtotime($active_date))
        ]);


        return $income;
    }
}
