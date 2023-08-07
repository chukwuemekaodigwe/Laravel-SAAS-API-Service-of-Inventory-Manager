<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{

    var $branch;
    function __construct(Request $request)
    {
        $this->branch = $request->header('branch');
    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $expenses = Auth::user()->company->expenses()
       // ->join('registries', 'registries.id', 'expenses.registry_id')
        ->where('expenses.branch_id', $this->branch)
        ->where('expenses.type', '!=', 'sales')
       
                    ->orderBy('expenses.id', 'desc')->paginate($no);
        return response(['result' => $expenses], 200);
    }


    public function getExpensesOnly(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $expense = Auth::user()->company->expenses()
            ->where('branch_id', $this->branch)
            ->where('type', '!=', 'fund_transfer')
            ->orderBy('id', 'desc')
            ->paginate($no);

        return response(['result' => $expense], 200);
    }


    /**
     * Show the table result for a particular date
     */
    public function getByDate(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $expense = Auth::user()->company->expenses()
           // ->where('expenses.type', 'expenses')
            //->join('registries', 'registries.id', 'expenses.registry_id')
            ->where('expenses.branch_id', $this->branch)

            ->whereDate('expenses.ledger_date', date('Y-m-d H:i:s', strtotime($request->start)))->orderBy('id', 'desc')
            ->paginate($no);

        return response(['result' => $expense]);
    }


    public function getByRange(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';

        $expense = Auth::user()->company->expenses()
            ->join('registries', 'registries.id', 'expenses.registry_id')
            ->where('expenses.branch_id', $this->branch)
            //->where('expenses.type', 'expenses')
            ->whereBetween('expenses.ledger_date', [date('Y-m-d', strtotime($request->start)), date('Y-m-d', (strtotime($request->end) + (60 * 24 * 60)))])

            ->orderBy('expenses.id', 'desc')->paginate($no);

        return response(['result' => $expense]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $req = $request->data;
        $expense = Expense::saveExpenses($req, $this->branch);
        return response(['expense' => $expense]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense): Response
    {
        return response(['expense' => $expense]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {

        $req = $request->data;
        //return response($req, 500);
        $expense = Expense::find($req['item']['id']);

        if (empty($req['misc'])) {
            $req['misc'] = '';
        }

        $upd = $expense->update([
            'title' => $req['title'],
            'description' => $req['reason'],
            'amount' => $req['item']['amount'],
            'type' => $req['type'],
            'payment_method' => $req['p_method'],
            'misc' => json_encode($req['misc'])

        ]);

        return response(['message' => 'successful', 'expense' => $expense->refresh()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Expense $expense): Response
    {
        $res = $expense->delete();
        return response(['message' => 'deleted successfully']);
    }


    public function searchExpense(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $search = $request->searchTerm;
        $result = Expense::search($search, $this->branch)->where('type', 'expenses')->paginate($no);

        return response(['result' => $result]);
    }


    /**
     * FOR FUNDS TRANSFER
     */

    public function getAllTransfer(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $result = Auth::user()->company->expenses()
            ->where('type', 'LIKE', '%transfer%')
            ->where('branch_id', $this->branch)
            ->orderBy('id', 'desc')->paginate($no);

        return response(['result' => $result]);
    }

    public function getTransferByDate(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $expense = Auth::user()->company->expenses()
            ->where('branch_id', $this->branch)
            ->where('type', 'LIKE', '%transfer%')
            ->whereDate('ledger_date', date('Y-m-d H:i:s', strtotime($request->start)))->orderBy('id', 'desc')
            ->orderBy('id', 'desc')->paginate($no);

        return response(['result' => $expense]);
    }


    public function getTransferByRange(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $expense = Auth::user()->company->expenses()
            ->where('branch_id', $this->branch)
            ->where('type', 'LIKE', '%transfer%')
            ->whereBetween('ledger_date', [date('Y-m-d', strtotime($request->start)), date('Y-m-d', (strtotime($request->end) + (60 * 24 * 60)))])

            ->orderBy('id', 'desc')->paginate($no);

        return response(['result' => $expense]);
    }

    public function searchTransfer(Request $request)
    {

        $search = $request->searchTerm;
        $no = isset($request->per_page) ? $request->per_page : '30';
        $result = Auth::user()->company->expenses()
            ->join('users', 'users.id', '=', 'expenses.employee')
            ->select('expenses.*')
            ->where('expenses.branch_id', $this->branch)
            ->Where('expenses.type', 'LIKE', "%transfer%")
            ->where('expenses.title', 'LIKE', "%$search%")
            ->orWhere('expenses.amount', 'LIKE', "%$search%")

            ->orWhere('expenses.payment_method', 'LIKE', "%$search%")
            ->orWhere('expenses.misc', 'LIKE', "%$search%")
            ->orWhere('users.name', 'LIKE', "$search%")

            ->orderBy('expenses.id', 'desc')
            ->paginate($no);

        return response(['result' => $result]);
    }
}
