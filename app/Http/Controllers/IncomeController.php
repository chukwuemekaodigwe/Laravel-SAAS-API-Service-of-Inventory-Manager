<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Income;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class IncomeController extends Controller
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
        $incomes = Auth::user()->company->incomes()
            // ->join('registries', 'registries.id', 'incomes.registry_id')
            ->where('incomes.branch_id', $this->branch)
            ->where('incomes.type', '!=', 'sales')
            //  ->select('incomes.*', 'registries.time_opened as created_at')
            ->orderBy('id', 'desc')->paginate($no);
        return response(['result' => $incomes], 200);
    }

    /**
     * Show the table result for a particular date
     */


    public function getByDate(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $income = Auth::user()->company->incomes()
            // ->join('registries', 'registries.id', 'incomes.registry_id')
            ->where('incomes.branch_id', $this->branch)

            ->where('incomes.type', '!=', 'sales')
            ->whereDate('incomes.legder_date', date('Y-m-d', strtotime($request->start)))
            ->orderBy('incomes.id', 'desc')
            ->paginate($no);

        return response(['result' => $income]);
    }


    public function getByRange(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $income = Auth::user()->company->incomes()
            //   ->join('registries', 'registries.id', 'incomes.registry_id')
            ->where('incomes.branch_id', $this->branch)
            ->where('incomes.type', '!=', 'sales')

            ->whereBetween('incomes.ledger_date', [date('Y-m-d', strtotime($request->start)), date('Y-m-d', (strtotime($request->end) + (60 * 24 * 60)))])
            ->orderBy('incomes.id', 'desc')->paginate($no);

        return response(['result' => $income]);
    }


    public function searchIncome(Request $request)
    {
        $search = $request->searchTerm;
        $no = isset($request->per_page) ? $request->per_page : '30';
        $result = Income::search($search, $this->branch);
        $result = $result->where('type', '!=', 'sales')->paginate($no);

        return response(['result' => $result]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $req = $request->data;

        if (empty($req['misc'])) {
            $req['misc'] = '';
        }

        $income = Income::saveIncome($req, $this->branch);

        return response(['income' => $income]);
    }

    /**
     * Save repayment of due transactions
     */



    public function saveRepayment(Request $request)
    {
        $req = $request->data;
        $details = [];

        foreach ($req['product'] as $value) {
            if (!empty($value['select'])) {

                $order = Order::find($value['id']);

                $details[] = [
                    'orderId' => $order->order_no,
                    'amount_paid' => $order->remainder
                ];

                $upd =   $order->update([
                    'status' => 'paid',
                    'amount_paid' => $order->amount_paid + $value['item']['remainder'],
                    'remainder' => 0
                ]);
            }
        }

        $payload = [
            'title' => 'Payment of Debt',
            'amount' => $req['form']['amount'],
            'registry' => $req['registry'],
            'type' => 'debt_repay',
            'p_method' => $req['form']['p_method'],
            'desc' => 'Payment of Debt by ' . $req['form']['customer_name'] . '
(' . $req['form']['customer_phone'] . ' );
Other Info : ' . $req['form']['desc'],

            'misc' => json_encode($details)
        ];

        $income = Income::saveIncome($payload, $this->branch);

        return response(['income' => $income, 'order' => $order]);
    }



    public function getAllDeptRepay(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $result = Auth::user()->company->incomes()
            ->where('type', 'LIKE', '%debt_repay%')
            ->where('branch_id', $this->branch)
            ->orderBy('id', 'desc')->paginate($no);

        return response(['result' => $result]);
    }

    public function getDeptRepayByDate(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $income = Auth::user()->company->incomes()
            ->where('branch_id', $this->branch)
            ->where('type', 'LIKE', '%debt_repay%')
            ->whereDate('ledger_date', '=', date(
                'Y-m-d',
                strtotime($request->start)
            ))

            ->orderBy('id', 'desc')

            ->paginate($no);

        return response(['result' => $income]);
    }


    public function getDeptRepayByRange(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $income = Auth::user()->company->incomes()
            ->where('branch_id', $this->branch)
            ->where('type', 'LIKE', '%debt_repay%')
            ->whereBetween('ledger_date', [date('Y-m-d', strtotime($request->start)), date('Y-m-d', (strtotime($request->end) + (60 * 24 * 60)))])

            ->orderBy('id', 'desc')->paginate($no);

        return response(['result' => $income]);
    }

    public function searchDeptRepay(Request $request)
    {

        $search = $request->searchTerm;
        $no = isset($request->per_page) ? $request->per_page : '30';
        $result = Auth::user()->company->incomes()
            ->join('users', 'users.id', '=', 'incomes.employee')
            ->select('incomes.*')
            ->where('incomes.branch_id', $this->branch)
            ->Where('incomes.type', "debt_repay");
        $result->where('incomes.title', 'LIKE', "%$search%");
        $result->orWhere('incomes.amount', 'LIKE', "%$search%");
        $result->orWhere('incomes.payment_method', 'LIKE', "%$search%");
        $result->orWhere('incomes.misc', 'LIKE', "%$search%");
        $result->orWhere('users.name', 'LIKE', "$search%");

        $result->orderBy('incomes.id', 'desc');
        $a =   $result->paginate($no);

        return response(['result' => $a]);
    }

    /**
     * Display the specified resource.
     */


    public function show(Income $income): Response
    {
        return response(['income' => $income]);
    }



    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Income $income)
    {
        $req = $request->data;
        //return response($req, 500);
        $income = Income::find($req['item']['id']);

        if (empty($req['misc'])) {
            $req['misc'] = '';
        }

        $upd = $income->update([
            'title' => $req['title'],
            'description' => $req['reason'],
            'amount' => $req['item']['amount'],
            'type' => $req['type'],
            'payment_method' => $req['p_method'],
            'misc' => json_encode($req['misc'])

        ]);

        return response(['message' => 'successful', 'income' => $income->refresh()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Income $income): Response
    {
        $res = $income->delete();
        return response(['message' => 'deleted successfully']);
    }
}
