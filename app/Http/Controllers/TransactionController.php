<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Models\Registry;

class TransactionController extends Controller
{

    var $branch;
    var $active_registry;
    function __construct(Request $request)
    {
        $this->branch = $request->header('branch');
    }

    public function mySort($collection, $order)
    {

        if ($order == 'asc') {
            $collection = array_values(Arr::sort($collection, function ($value) {
                return $value['ledger_date'];
            }));
        } else {
            //DESC
            $collection = array_reverse(Arr::sort($collection, function ($value) {
                return $value['ledger_date'];
            }));
        }

        return $collection;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $inc = Collect(Auth::user()->company->incomes()
        ->where('incomes.branch_id', $this->branch)
        
        //->select('incomes.*', 'registries.time_opened as created_at')
            ->get());

        $exp = Collect(Auth::user()->company->expenses()
        ->where('expenses.branch_id', $this->branch)
        
            ->get());

        $data =  $inc->merge($exp);

        $result2 = $this->mySort($data, 'desc');
        $result = $data->paginate($no);

        return response(['result' => $result, 'data' => $result2]);
        
    }

    /**
     * Show the table result for a particular date
     */
    public function getTodayTransaction(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
       
        $inc = Auth::user()->company->incomes()
       // ->join('registries', 'registries.id', 'incomes.registry_id')
            ->where('incomes.branch_id', $this->branch)
            ->WhereDate('incomes.ledger_date', date('Y-m-d', strtotime('today')))
            ->get();

        $exp = Auth::user()->company->expenses()
        //->join('registries', 'registries.id', 'expenses.registry_id')
            ->where('expenses.branch_id', $this->branch)
            ->WhereDate('expenses.ledger_date', date('Y-m-d', strtotime('today')))
            ->get();

        $transactions = $inc->concat($exp);
        $tr = $this->mySort($transactions, 'desc');
        $a = $transactions->paginate($no);

        return response(['result' => $a, 'data' => $tr]);
    }

/**
     * Show an agent table result for a particular date
     */
    public function getTodayTransactionPerUser(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';

        $inc = Auth::user()->company->incomes()
        //->join('registries', 'registries.id', 'incomes.registry_id')
            ->where('incomes.branch_id', $this->branch)
            ->where('incomes.employee', Auth::user()->id)
            ->WhereDate('incomes.ledger_date', date('Y-m-d', strtotime('today')))
            ->get();

        $exp = Auth::user()->company->expenses()
//        ->join('registries', 'registries.id', 'expenses.registry_id')
            ->where('expenses.branch_id', $this->branch)
            ->where('expenses.employee', Auth::user()->id)
            ->WhereDate('expenses.ledger_date', date('Y-m-d', strtotime('today')))
            ->get();

        $transactions = $inc->concat($exp);
        $tr = $this->mySort($transactions, 'desc');
        $a = $transactions->paginate($no);

        return response(['result' => $a, 'data' => $tr]);
    }



    /**
     * Show the table result for a particular date
     */
    public function getByDate(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';

        if (empty($request->start)) {
            $request->start = Date('Y-m-d', strtotime('today'));
        }

       
        $inc = Auth::user()->company->incomes()
  //      ->join('registries', 'registries.id', 'incomes.registry_id')
            ->where('incomes.branch_id', $this->branch)
            ->WhereDate('incomes.ledger_date', date('Y-m-d', strtotime($request->start)))
            ->get();

        $exp = Auth::user()->company->expenses()
        ->join('registries', 'registries.id', 'expenses.registry_id')
            ->where('expenses.branch_id', $this->branch)
            ->WhereDate('expenses.ledger_date', date('Y-m-d', strtotime($request->start)))
            ->get();


        $transactions = $inc->concat($exp);
        $tr = $this->mySort($transactions, 'desc');
        $a = $transactions->paginate($no);

        return response(['result' => $a, 'data' => $tr]);
    }


    public function getByRange(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $inc = Auth::user()->company->incomes()
       // ->join('registries', 'registries.id', 'incomes.registry_id')
        ->where('incomes.branch_id', $this->branch)
        ->whereBetween('incomes.ledger_date',[date('Y-m-d', strtotime($request->start)), 
        date('Y-m-d', (strtotime($request->end) + (60 * 24 * 60)))])
        ->get();

        $exp = Auth::user()->company->expenses()
        ->join('registries', 'registries.id', 'incomes.registry_id')
        ->where('expenses.branch_id', $this->branch)
            ->whereBetween('expenses.ledger_date', [
                date('Y-m-d H:i:s', strtotime($request->start)),
                date('Y-m-d H:i:s', strtotime($request->end))
            ])

            ->get();
        $transactions = $inc->concat($exp);

        $tr = $this->mySort($transactions, 'desc');
        $a = $transactions->paginate($no);

        return response(['result' => $a, 'data' => $tr]);
    }

    /**
     * Search transactions 
     */

    public function searchTransactions(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';

        $search = $request->searchTerm;

        $income = Income::search($search, $this->branch);
        $expense = Expense::search($search, $this->branch);

        $result = $income->concat($expense);
        $a = $result->paginate($no);
        $tr = $this->mySort($result, 'desc');
        return response(['result' => $a, 'data' => $tr]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function searchByDate(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $search = $request->searchTerm;


        $income = Income::search($search, $this->branch, true);
        $expense = Expense::search($search, $this->branch, true);
        $result = $income->concat($expense);
        // $result = $result->where('created_at', 'LIKE', date('Y-m-d H:i:s', strtotime('today')));

        $a = $result->paginate($no);
        //$a = $result->paginate(25);
        return response(['result' => $result], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        //
    }
}
