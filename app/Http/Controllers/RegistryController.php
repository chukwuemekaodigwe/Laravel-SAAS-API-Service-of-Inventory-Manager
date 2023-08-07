<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Registry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class RegistryController extends Controller
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
        $registry = Auth::user()->company->registries()
        ->where('branch_id', $this->branch)
        ->orderby('id', 'desc')
        ->paginate($no);
        return Response(['result' => $registry]);
    }


    public function getByDate(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $registry = Auth::user()->company->registries()->where('branch_id', $this->branch)
        ->whereDate('time_opened', date('Y-m-d', strtotime($request->start)))
        ->orderby('id', 'desc')->paginate($no);
        return Response(['result' => $registry]);
    }


    public function getByRange(Request $request): Response
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $registry = Auth::user()->company->registries()
        ->where('branch_id', $this->branch)
        ->whereBetween('time_opened', [date('Y-m-d', strtotime($request->start)), date('Y-m-d', (strtotime($request->end) + (60 * 24 * 60)))])
        ->orderby('id', 'desc')->paginate($no);

        return Response(['result' => $registry]);
    }


    /**
     * Show the form for creating a new resource.
     */

    public function open_registry(Request $request): Response
    {
        $new_reg = $request->data;
        $reg_id = substr(time(), 3);

        $save = Auth::user()->company->registries()->create([
            
            'opened_by' => Auth::user()->id,
            'time_opened' => date('Y-m-d H:i:s', strtotime($new_reg['date'])),
            'opening_amt' => $new_reg['amount'],
            'reg_code' => '#'.$reg_id,
            'opening_note' => $new_reg['reason'],
            'branch_id' => $this->branch
        ]);

        return response(['message' => 'Successful', 'registry' => $save], 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function close_reg(Request $request)
    {
        $req = $request->data;
        if (!$req['approve']) {
            return response(['message' => 'Please confirm the accuracy of the records'], 500);
        }

        $reg = Registry::find($req["registry"]);
//return response(['result'=>$req], 500);

        $reg->update([
            'closed_by' => Auth::user()->id,
            'time_closed' => date('Y-m-d H:i:s', time()),
            'expenses' => $req['ledger']['expenses'],
            'incomes' => $req['ledger']['incomes'],
            'status' => 1,
            'total_exp' => $req['total_exp'],
            'total_income' => $req['total_income'],
            'cash_sales' => $req['ledger']['cash'],
            'bank_sales' => $req['ledger']['bank'],
            'cheque_sales' => $req['ledger']['cheque'],
            'debts' => $req['ledger']['debts'],
            'receive_payments' => $req['ledger']['receive_payments'],
            'returns' => $req['ledger']['returns'],
            'transfer' => $req['ledger']['transfer'],
            'closing_note' => $req['closing_note'],
            'closing_amt' => $req['close_ledger']

        ]);

        return response(['message'=>'Closed successfully']);

    }

    public function searchRegistry(Request $request){

        $no = isset($request->per_page) ? $request->per_page : '30';
        $search = $request->searchTerm;
        $result = Auth::user()->company->registries()
        ->join('users', 'users.id', 'registries.opened_by')
        ->select('registries.*')
        ->where('registries.branch_id', $this->branch)
        ->where('registries.reg_code', 'like', "%$search%")
        ->orWhere('registries.opening_amt', 'like', "%$search%")
        ->orWhere('registries.total_exp', 'like', "%$search%")
        ->orWhere('registries.total_income', 'like', "%$search%")
        ->orWhere('registries.cash_sales', 'like', "%$search%")
        ->orWhere('registries.bank_sales', 'like', "%$search%")
        ->orWhere('registries.cheque_sales', 'like', "%$search%")
        ->orWhere('registries.debts', 'like', "%$search%")
        ->orWhere('registries.receive_payments', 'like', "%$search%")
        ->orWhere('registries.transfer', 'like', "%$search%")
        ->orWhere('registries.closing_note', 'like', "%$search%")
        ->orWhere('registries.returns', 'like', "%$search%")
        ->orWhere('registries.opening_note', 'like', "%$search%")
        ->orWhere('users.name', 'like', "%$search%")
        ->orWhere('registries.time_opened', 'like', "%date('Y-m-d', strtotime($search))%")
        ->orWhere('registries.time_closed', 'like', "%date('Y-m-d', strtotime($search))%")
        
        ->orderby('id', 'desc')
        ->paginate($no);
     
        return response(['result'=>$result]);
    }


    public function getRegistryData(Request $request)
    {

        $registry = Registry::find($request->registry_id);
        //return response($registry, 500);
        $income = Income::where('registry_id', $registry['id'])->where('type', 'LIKE', 'other_income')->sum('amount');
        $cash = Income::where('registry_id', $registry['id'])->where('type', '=', 'sales')->where('payment_method', 'cash')->sum('amount');
        $bank = Income::where('registry_id', $registry['id'])->where('type', '=', 'sales')->where('payment_method', 'bank')->sum('amount');
        $cheque = Income::where('registry_id', $registry['id'])->where('type', '=', 'sales')->where('payment_method', 'cheque')->sum('amount');
        $payments = Income::where('registry_id', $registry['id'])->where('type', '=', 'payments')->sum('amount');

        $expense = Expense::where('registry_id', $registry['id'])->where('type', 'expenses')->sum('amount');
        $returns = Expense::where('registry_id', $registry['id'])->where('type', 'returns')->sum('amount');
        $transfers = Expense::where('registry_id', $registry['id'])->where('type', 'LIKE', '%transfer%')->sum('amount');
        $debts = Order::where('registry_id', $registry['id'])->where('remainder', '>', 0)->sum('remainder');

        return response([
            'debts' => $debts,
            'incomes' => $income,
            'cash' => $cash,
            'bank' => $bank,
            'cheque' => $cheque,
            'receive_payments' => $payments,
            'expenses' => $expense,
            'returns' => $returns,
            'transfer' => $transfers,
            'registry' => $registry
        ]);
    }

    /**
     * Get the store opening balanace
     */

    public function show(): Response
    {
        $status = Auth::user()->company->registry_by_user;
        // return response(['result' => $status]);
        if ($status == 1) {
            $registry = Auth::user()->company->registries()
                ->where('opened_by', Auth::user()->id)
                ->select('closing_amt')
                ->orderby('id', 'desc')
                ->first();

        } else {
            $registry = Auth::user()->branch->registries()            
            ->select('closing_amt')
            ->orderby('id', 'desc')
            ->first();
        }

        if(empty($registry)){
            $registry['closing_amt'] = 0;
        }

        return response(['result' => $registry['closing_amt']]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    
    public function checkActive(): Response
    {
        $status = Auth::user()->company->registry_by_user;
        // return response(['result' => $status]);
        if ($status == 1) {
            $registry = Auth::user()->company->registries()
                ->where('opened_by', Auth::user()->id)
                ->whereNull('closed_by')
                ->get();
        } else {
            $registry = Auth::user()->branch->registries()
                //->whereNull('closed_by')
                ->where('status', 0)
                ->get();
        }

        return response(['result' => $registry]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registry $registry)
    {
        $reg = Registry::find($request->registry);

        $reg->update([
            'opening_amt' => $request->open,
            'closing_amt' => $request->close,
        ]);

        return response(['message'=>'successful']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registry $registry): RedirectResponse
    {
        //
    }
}


/**
 * 
//  * 
//     /**
//      * For record for Year
//      */

//      public function getSalesByYear(Request $request)
//      {
//          $no = isset($request->per_page) ? $request->per_page : '30';
//          if (($request->summary)) {
             
//              $orders = Auth::user()->company->sales()
//                  ->join('products', 'products.id', '=', 'sales.product_id')
//                  ->whereYear('sales.created_at', '=', $request->year)
//                  ->where('sales.branch_id', $this->branch)
//                  ->groupBy('products.id')
//                  ->get([
//                      DB::RAW('SUM(sales.qty) as qty'),
//                      DB::RAW('SUM(sales.price) as gross'),
//                      DB::RAW('(SUM(sales.price) - SUM(sales.cost_price)) as profit'),
//                      'products.sku',
//                      'products.name',
//                      'products.id'
//                  ]);
//  //return response(['result'=>$orders], 200);
 
//          } else {
//              $orders = Auth::user()->company->orders()
//                  ->join('customers', 'customers.id', '=', 'orders.customer_id')
//                  ->join('sales', 'sales.order_id', '=', 'orders.id')
//                  ->selectRaw('customers.name, orders.*, count(sales.order_id) as no_items')
//                  ->where('orders.branch_id', $this->branch)
//                  ->whereYear('orders.created_at', '=', $request->year)
//                  ->orderby('orders.id', 'desc')
//                  ->groupBy('sales.order_id') //->toSql();
//                  ->paginate(30);
 
             
//          }
 
//          return response(['result' => $orders], 200);
//      }
 
//      /**
//       * For record for month with year
//       */
 
//      public function getSalesByMonth(Request $request)
//      {
//          if ($request->summary) {
//              $orders = Auth::user()->company->sales()
//                  ->join('products', 'products.id', '=', 'sales.product_id')
//                  ->whereMonth('sales.created_at', '=', $request->month)
//                  ->where('sales.branch_id', $this->branch)
//                  ->whereYear('sales.created_at', '=', $request->year)
//                  ->groupBy('products.id')
//                  ->get([
//                      DB::RAW('SUM(sales.qty) as qty'),
//                      DB::RAW('SUM(sales.price) as gross'),
//                      DB::RAW('(SUM(sales.price) - SUM(sales.cost_price)) as profit'),
//                      'products.sku',
//                      'products.name',
//                      'products.id'
//                  ]);
//          } else {
//              $orders = Auth::user()->company->orders()
//                  ->join('customers', 'customers.id', '=', 'orders.customer_id')
//                  ->join('sales', 'sales.order_id', '=', 'orders.id')
//                  ->where('orders.branch_id', $this->branch)
//                  ->selectRaw('customers.name, orders.*, count(sales.order_id) as no_items')
//                  ->whereMonth('orders.created_at', '=', $request->month)
//                  ->whereYear('orders.created_at', '=', $request->year)
//                  ->orderby('orders.id', 'desc')
//                  ->groupBy('sales.order_id') //->toSql();
//                  ->paginate(30);
//          }
 
//          return response()->json(['result' => $orders], 200);
//      }
 
 
 
 
//      public function getSalesThisWeek(Request $request)
//      {
//          if (isset($request->summary)) {
//              $orders = Auth::user()->company->sales()
//                  ->join('products', 'products.id', '=', 'sales.product_id')
//                  ->where('sales.branch_id', $this->branch)
//                  ->whereBetween('sales.created_at', [
//                      Carbon::now()->startOfWeek(Carbon::SUNDAY),
//                      Carbon::now()->endOfWeek(Carbon::SATURDAY)
//                  ])
 
//                  ->get([
//                      DB::RAW('SUM(sales.qty) as qty'),
//                      DB::RAW('SUM(sales.price) as gross'),
//                      DB::RAW('(SUM(sales.price) - SUM(sales.cost_price)) as profit'),
//                      'products.name',
//                      'products.id'
//                  ]);
//          } else {
//              $orders = Auth::user()->company->orders()
//                  ->join('customers', 'customers.id', '=', 'orders.customer_id')
//                  ->join('sales', 'sales.order_id', '=', 'orders.id')
//                  ->where('orders.branch_id', $this->branch)
//                  ->select('sales.*', 'orders.*', 'customers.*')
//                  ->whereBetween('orders.created_at', [
//                      Carbon::now()->startOfWeek(Carbon::SUNDAY),
//                      Carbon::now()->endOfWeek(Carbon::SATURDAY)
//                  ])
//                  ->orderby('id', 'desc')
//                  ->get();
//          }
 
//          return response()->json(['result' => $orders], 200);
//      }
 
//      public function getDates()
//      {
//          $present = Carbon::now();
//          $start = Carbon::now()->startOfWeek(Carbon::SUNDAY);
//          $end = Carbon::now()->endOfWeek(Carbon::SATURDAY);
//          return response()->json(['start' => $start, 'end' => $end, 'present' => $present]);
//      }
 
 
//      public function getSalesByDay(Request $request)
//      {
//          if (isset($request->summary)) {
//              $orders = Auth::user()->company->sales()
//                  ->join('sales.products', 'products.id', '=', 'sales.product_id')
//                  ->where('branch_id', $this->branch)
//                  ->whereDate('created_at', 'Like', $request->date)
//                  ->groupBy('products.id')
//                  ->get([
//                      DB::RAW('SUM(sales.qty) as qty'),
//                      DB::RAW('SUM(sales.price) as gross'),
//                      DB::RAW('(SUM(sales.price) - SUM(sales.cost_price)) as profit'),
//                      'products.name',
//                      'products.id'
//                  ]);
//          } else {
//              $orders = Auth::user()->company->orders()
//                  ->join('customers', 'customers.id', '=', 'orders.customer_id')
//                  ->join('sales', 'sales.order_id', '=', 'orders.id')
//                  ->where('orders.branch_id', $this->branch)
//                  ->select('sales.*', 'orders.*', 'customers.*')
//                  ->whereDate('created_at', 'Like', $request->date)
//                  ->orderby('id', 'desc')
//                  ->paginate(50);
//          }
 
//          return response()->json(['result' => $orders], 200);
//      }
 
 
//  */