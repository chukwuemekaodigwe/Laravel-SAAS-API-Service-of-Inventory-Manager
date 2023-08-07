<?php

namespace App\Http\Controllers;

use App\Models\Returns;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\Stock;
use App\Models\Registry;

class ReturnsController extends Controller
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
        $returns = Auth::user()->company->returns()
        ->join('customers', 'customers.id', 'returns.customer_id')
        ->select('customers.name', 'customers.phone', 'returns.*')
        ->where('returns.branch_id', $this->branch)
        ->paginate($no);
        
        return response(['result' => $returns]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getByDate(Request $request): Response
    {
        //return response($request->start, 500);
        $no = isset($request->per_page) ? $request->per_page : '30';
        $returns = Auth::user()->company->returns()
        ->join('customers', 'customers.id', 'returns.customer_id')
        ->select('customers.name', 'customers.phone', 'returns.*')
        ->where('returns.branch_id', $this->branch)
            ->whereDate('returns.ledger_date', 'like', date('Y-m-d', strtotime($request->start)))
            ->paginate($no);

        return response(['result' => $returns]);
    }


    public function getByRange(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $returns = Auth::user()->company->returns()
        ->join('customers', 'customers.id', 'returns.customer_id')
        ->select('customers.name', 'customers.phone', 'returns.*')
        ->where('returns.branch_id', $this->branch)
       
        ->whereBetween('returns.ledger_date', [
                date('Y-m-d', strtotime($request->start)),
                date('Y-m-d', strtotime($request->end))
            ])
            ->paginate($no);

        return response(['result' => $returns]);
    }


    public function search(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';

        $searchTerm = $request->searchTerm;
        $returns = Auth::user()->company->returns()
            ->join('customers', 'customers.id', 'returns.customer_id')
            ->select('customers.name', 'customers.phone', 'returns.*')
            ->where('returns.branch_id', $this->branch)
            ->where('returns.order_no', 'like', "%$searchTerm%")
            
            ->orWhere('returns.amount_repaid', 'like', "%$searchTerm%")
            ->orWhere('returns.details', 'like', "%$searchTerm%")
            ->orWhere('customers.phone', 'like', "%$searchTerm%")
            ->orWhere('customers.name', 'like', "%$searchTerm%")
            ->paginate($no);

        return response(['result' => $returns]);
    }

    /**
     * Display the specified resource.
     */

    public function approveReturn(Returns $returns): Response
    {
        if ($returns->update([
            'status' => 1
        ])) {
            return response(['message' => 'successful'], 204);
        }
    }


    public function getUnapprovedReturns()
    {
        $returns = Auth::user()->company->returns()->where('status', 0)->get();
        return response(['result' => $returns]);
    }


    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Returns $returns): Response
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request): Response
    {
        $req = $request->data;
        $details = [];
        $item = [];
        $st = [];

        foreach ($req['product'] as $key => $value) {
            $s = ['product' => $value['product_id'], 'qty' => $value['returned']];
            $details[] = $s;

            /**
             * for return of sales featuring return to stock: Products are returned to stock
             */

            if ($req['form']['behaviour'] == 'Yes') {
                $r = [
                    'qty' => $value['returned'],
                    'type' => 4,
                    'reason' => 'Sold product returned by the customer'
                ];

                $st[] = Stock::newStock($r, $value['product_id'], $this->branch);
            }
        }

        $active_date = Registry::find($details['registry_id'])->time_opened;

        $save = Auth::user()->company->returns()->create([
            'order_id' => $req['order']['id'],
            'order_no' => $req['order']['order_no'],
            'branch_id' => $this->branch,
            'employee' => Auth::user()->id,
            'customer_id' => $req['order']['customer_id'],
            'amount_repaid' => $req['form']['amount'],
            'details' => json_encode($details),
            'stockBehaviour' => $req['form']['behaviour'] == 'Yes' ? 1 : 0,
            'reason' => $req['form']['desc'],
            'ledger_date' => date('Y-m-d', strtotime($active_date)),
            'payement_method' => $req['form']['p_method']
        ]);

        $payload = [
            'title' => 'Return of Sales',
            'amount' => $req['form']['amount'],
            'registry' => $req['registry'],
            'type' => 'sales_return',
            'p_method' => $req['form']['p_method'],
            'desc' => 'Return of products by ' . $req['order']['name'] . '
            (' . $req['order']['phone'] . ' ) With reason : ' . $req['form']['desc'],
            'misc' => $details
        ];


        $expense = Expense::saveExpenses($payload, $this->branch);

        return response(['result' => $save, 'expenses' => $expense, 'stock' => $st]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Returns $returns): Response
    {
        $returns = $request->order;
        Returns::find($returns['id'])->update([
            'order_id' => $returns['order_id'],
            'order_no' => $returns['order_no'],
            'branch_id' => $returns['branch_id'],
            'employee' => Auth::user()->id,

            'customer_id' => $returns['customer'],
            'registry_id' => $returns['registry'],
            'details' => $returns['details']
        ]);

        return response(['message' => 'Update Successful', 'return' => $returns->refresh()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Returns $returns): RedirectResponse
    {
        //
    }
}
