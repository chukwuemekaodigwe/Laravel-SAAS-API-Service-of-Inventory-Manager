<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Registry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{

    var $branch;
    var $active_registry;
    function __construct(Request $request)
    {
        $this->branch = $request->header('branch');

        $this->middleware(function ($request, $next) {
            $r = Registry::getActiveRegistry($this->branch);
            if(!empty($r)){
                $this->active_registry = $r->id;
            }else{
                $this->active_registry = '';
            }

            return $next($request);
        });
    }

    public function recentSales($byMonth)
    {
        $result = Auth::user()->company->orders()
            ->where('orders.branch_id', $this->branch)
            ->join('customers', 'customers.id', 'orders.customer_id')
            ->select('customers.name', 'customers.phone', 'orders.amount_paid', 'orders.order_no');

        if (!empty($byMonth)) {
            $result->whereMonth('orders.ledger_date', date('m', strtotime('today')));
        } else {
            $result->whereDate('orders.ledger_date', date('Y-m-d', strtotime('today')));
        }
        $result->orderby('orders.id', 'desc');
        $result->limit(30);
        $a = $result->get();

        return $a;
    }

    public function getRevenue(Request $request)
    {
        $byMonth = $request->header('recordByMonth');
        $result = Auth::user()->company->incomes()
            ->where('branch_id', $this->branch);
        if (!empty($byMonth)) {
            $result->whereMonth('incomes.ledger_date', '=', date('m', strtotime('today')));
        } else {
            $result->whereDate('incomes.ledger_date', '=', date('Y-m-d', strtotime('today')));
        }

        $result->selectRaw('type as label, sum(amount) as value');
     $result->groupby('type');
        $a = $result->get();

        $result2 = Auth::user()->company->expenses()
            ->where('branch_id', $this->branch);

        if (!empty($byMonth)) {
            $result->whereMonth('expenses.ledger_date', '=', date('m', strtotime('today')));
        } else {
            $result->whereDate('expenses.ledger_date', '=', date('Y-m-d', strtotime('today')));
        }

        $result2->selectRaw('type as label, sum(amount) as value');
        $result2->groupby('type');
        $a2 = $result2->get();

        return (['result' => ['income' => $a, 'expenses' => $a2]]);
    }

    public function countPendingTransfer(){
        $count = Auth::user()->company->stocks()
        ->where('branch_id', $this->branch)
        ->where('status', 2)
        ->where('type', 2)
        ->count();

        return $count;
    }

    public function getDashInfo(Request $request)
    {
        $byMonth = $request->header('recordByMonth');
        $reg = $this->active_registry;

        $income = Income::sumIncome($this->branch, $reg, $byMonth);
        $sales = Income::sumSales($this->branch, $reg, $byMonth);
        $count = Income::countSales($this->branch, $reg, $byMonth);
        $active_registry = Registry::getActiveRegistry($this->branch);
        if(empty($active_registry)){
            $active_registry = 'None';
        }else{
            $active_registry = date('Y-m-d', strtotime($active_registry->time_opened));
        }
        $revenueChart = $this->getRevenue($request);
        
        $pendingTrans = $this->countPendingTransfer();
        
        $recent = $this->recentSales($byMonth);
        $pendingTransfer = $this->countPendingTransfer();
        return response([
            'reg' => $reg, 'recent' => $recent,
            'incomeSum' => $income, 'salesSum' => $sales, 'count' => $count, 'reg_date' => $active_registry, 
            'transferAlert' => $pendingTrans,
            'revenue' => $revenueChart, 'notification' => $pendingTransfer

        ]);
    }
}
