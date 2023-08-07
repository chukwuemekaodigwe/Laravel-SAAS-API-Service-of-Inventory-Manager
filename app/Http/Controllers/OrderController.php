<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Registry;

class OrderController extends Controller
{

    protected $branch;
    var $active_registry;

    function __construct(Request $request)
    {
        $this->branch = $request->header('branch');
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function index(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        //return response(['branch' => $this->branch], 500);
        $orders = Auth::user()->company->orders()
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('sales', 'sales.order_id', '=', 'orders.id')
            //->join('registries', 'registries.id', 'orders.registry_id')
            ->where('orders.branch_id', $this->branch)
            ->selectRaw('customers.name, customers.phone, customers.address, orders.*, count(sales.order_id) as no_items')//, registries.time_opened as created_at')
            ->orderby('orders.id', 'desc')
            ->groupBy('orders.id')
            ->where('orders.branch_id', $this->branch)
            ->paginate($no);
        return response(['result' => $orders], 200);
    }

    public function getSalesSummary(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $orders = Auth::user()->company->sales()
            ->join('orders', 'orders.id', 'sales.order_id')
    //        ->where('orders.registry_id', $this->active_registry)
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->groupBy('products.id')
            ->orderBy('products.name', 'asc')
            ->whereDate('orders.ledger_date', date('Y-m-d', strtotime('today')))
            ->where('sales.branch_id', $this->branch)
            ->get([
                DB::RAW('SUM(sales.qty) as qty'),
                DB::RAW('SUM(sales.price) as gross'),
                DB::RAW('(SUM(sales.price) - SUM(sales.cost_price)) as profit'),
                'products.sku',
                'products.name',
                'products.id'
            ]);
        $result = $orders->paginate($no)->toArray();
        return response(['result' => $result]);
    }


    /**
     * Sales for a day
     *
     * @return \Illuminate\Http\Response
     */

    public function getSalesByDate(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        if (($request->summary)) {

            $orders = Auth::user()->company->sales()
                ->join('products', 'products.id', '=', 'sales.product_id')
                ->where('sales.branch_id', $this->branch)

                /**
                 * Add regisstrie refer
                 */

                ->whereDate('sales.ledger_date', '=', date('Y-m-d', strtotime($request->start)))
                ->groupBy('products.id')
                ->orderBy('products.name', 'asc')
                ->get([
                    DB::RAW('SUM(sales.qty) as qty'),
                    DB::RAW('SUM(sales.price) as gross'),
                    DB::RAW('(SUM(sales.price) - SUM(sales.cost_price)) as profit'),
                    'products.sku',
                    'products.name',
                    'products.id'
                ]);
            $result = $orders->paginate($no)->toArray();
        } else {
            $result = Auth::user()->company->orders()
                ->join('customers', 'customers.id', '=', 'orders.customer_id')
                ->join('sales', 'sales.order_id', '=', 'orders.id')
                ->where('orders.branch_id', $this->branch)
                ->selectRaw('customers.name, customers.phone, orders.*, count(sales.order_id) as no_items')
                ->whereDate('orders.ledger_date', date('Y-m-d', strtotime($request->start)))
                ->orderby('orders.id', 'desc')
                ->groupBy('sales.order_id') //->toSql();
                ->paginate($no);
        }

        return response(['result' => $result], 200);
    }

    /**
     * For Record by date Ranges
     */


    public function getSalesByRange(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        if ($request->summary) {
            $orders = Auth::user()->company->sales()
                ->join('products', 'products.id', '=', 'sales.product_id')
                ->whereBetween('sales.ledger_date', [date('Y-m-d', strtotime($request->start)), date('Y-m-d', (strtotime($request->end) + (60 * 24 * 60)))])
                ->where('sales.branch_id', $this->branch)
                ->orderBy('products.name', 'asc')
                ->groupBy('products.id')
                ->get([
                    DB::RAW('SUM(sales.qty) as qty'),
                    DB::RAW('SUM(sales.price) as gross'),
                    DB::RAW('(SUM(sales.price) - SUM(sales.cost_price)) as profit'),
                    'products.sku',
                    'products.name',
                    'products.id'
                ]);

            $result = $orders->paginate($no)->toArray();
        } else {
            $result = Auth::user()->company->orders()
                ->join('customers', 'customers.id', '=', 'orders.customer_id')
                ->join('sales', 'sales.order_id', '=', 'orders.id')
                ->where('orders.branch_id', $this->branch)

                ->whereBetween('orders.ledger_date', [
                    date('Y-m-d H:i:s', strtotime($request->start)),
                    date('Y-m-d H:i:s', strtotime($request->end))
                ])
                ->selectRaw('customers.name, orders.*, count(sales.order_id) as no_items')
                ->orderby('orders.id', 'desc')
                ->groupBy('sales.order_id') //->toSql();
                ->paginate($no);
        }

        return response(['result' => $result], 200);
    }


    public function searchSales(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $term = $request->searchTerm;
        //return response($term, 500);
        $result = Auth::user()->company->orders()
            ->join('sales', 'sales.order_id', '=', 'orders.id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->where('orders.branch_id', $this->branch)
            ->selectRaw('customers.name, orders.*, count(sales.order_id) as no_items')
            ->Where('orders.invoice_no', 'LIKE',  "%$term%")
            ->orWhere('customers.name', 'LIKE', "%$term%")
            ->orWhere('orders.total',  'LIKE', "%$term%")
            ->orWhere('orders.amount_paid', 'LIKE', "%$term%")
            ->orWhere('orders.status',  'LIKE', "%$term%")
            ->orWhere('orders.payments', 'LIKE', "%$term%")
            //->orWhereDate('orders.created_at',  'LIKE', "%$term%")
            //->orWhere('products.name', 'Like', "%$term%")
            // ->orWhere('products.sku', 'Like', "%$term%")
            ->orWhere('orders.order_no', 'LIKE', "%$term%")
            ->orderby('orders.id', 'desc')
            ->groupBy('sales.order_id')
            //->get();
            ->paginate($no);


        //if (count($result) > 0) {

        return response([/*'count' => count($result),*/'result' => $result], 200);
    }


    public function searchSummary(Request $request)
    {

        $no = isset($request->per_page) ? $request->per_page : '30';
        $term = $request->searchTerm;
        //return response($term, 500);
        $result = Auth::user()->company->orders()

            ->join('sales', 'sales.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'sales.product_id')

            ->where('orders.branch_id', $this->branch)
            ->whereDate('orders.ledger_date', date('Y-m-d', strtotime('today')))
            ->where('products.name', 'Like', "%$term%")
            ->orWhere('products.sku', 'Like', "%$term%")
            ->orderby('products.name', 'asc')
            ->groupBy('products.id')
            ->get([
                DB::RAW('SUM(sales.qty) as qty'),
                DB::RAW('SUM(sales.price) as gross'),
                DB::RAW('(SUM(sales.price) - SUM(sales.cost_price)) as profit'),
                'products.name',
                'products.id',
                'products.sku'

            ]);
        $result = $result->paginate($no)->toArray();
        return response([/*'count' => count($result),*/'result' => $result], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $order = $request->order;

        $active_date = Registry::find($order['registry_id'])->time_opened;
        //return response($active_date, 500);     
        if (!empty($order['customer']['name']) && !empty($order['customer']['phone'])) {
            $customer = Customer::new_customer($order['customer']);
        } else {
            return response(['message' => 'please provide the customers details: name and phone no'], 500);
        }
        // Create ORDER

        $new_order =  Auth::user()->company->orders()->create([
            'invoice_no' => $order['invoice_no'],
            'status' => ($order['amount_paid'] >= $order['total_payable']) ? 'paid' : 'pending',
            'order_no' => $order['order_id'],
            'total' => $order['total'],
            'branch_id' => $this->branch,
            'user_id' => Auth::user()->id,
            'amount_paid' => $order['amount_paid'],
            'remainder' => $order['remainder'] > 0 ? $order['remainder'] : 0,
            'discount' => ($order['discount'] * 0.01),
            'payments' => json_encode($order['payment_method']),
            'total_payable' => $order['total_payable'],
            'customer_id' => $customer->id,
            'registry_id' => $order['registry_id'],
            'tax' => ($order['tax'] * 0.01),
            'ledger_date' => date('Y-m-d', strtotime($active_date))
        ]);


        foreach ($order['sales'] as $sales) {
            if (!empty($sales['qty'])) {
                $new_order->sales()->create([
                    'price' => $sales['price'],
                    'cost_price' => $sales['cost_price'],
                    'qty' => $sales['qty'],
                    'invoice_no' => $order['invoice_no'],
                    'branch_id' => $this->branch,
                    'company_id' => Auth::user()->company->id,
                    'product_id' => $sales['product_id'],
                    'ledger_date' => date('Y-m-d', strtotime($active_date))
                ]);
            }
        }


        foreach ($order['payment_method'] as $key => $income) {
            // $r[] = $key .'/' . $income; 
            if (!empty($income)) {
                $i = Auth::user()->company->incomes()->create([
                    'title' => 'Revenue from sales ',
                    'description' => "Customer: $customer->name, order Id " . $order['order_id'],
                    'amount' => $income,
                    'employee' => Auth::user()->id,
                    'branch_id' => Auth::user()->branch->id,
                    'registry_id' => $order['registry_id'],
                    'type' => 'sales',
                    'payment_method' => $key,
                    'misc' => '',
                    'ledger_date' => date('Y-m-d', strtotime($active_date))
                ]);
            }
        }


        return response(['order' => $new_order]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $sales = $order->sales()->get();
        return response(['sales' => $sales], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */

     public function getSalesByOrderNo(Request $request)
    {
        $term = $request->term;
        $result = Auth::user()->company->orders()
            ->join('customers', 'customers.id', 'orders.customer_id')
            ->select('orders.*', 'customers.name', 'customers.phone')
            ->where('orders.branch_id', $this->branch)
            ->where('orders.order_no', '=', $term)
            ->orWhere('orders.invoice_no', '=', $term)
            ->first();

        if (empty($result)) {
            return response(
                ['result' => []]
            );
        }

        $sales = Auth::user()->company->sales()->where('order_id', $result['id'])->get();
        return response(['result' => ['order' => $result, 'sales' => $sales]]);
    }


    public function getDeptRepay(Request $request)
    {
        $term = $request->term;

        $result = Auth::user()->company->orders()
            ->join('customers', 'customers.id', 'orders.customer_id')
            ->select('orders.*', 'customers.name', 'customers.phone')
            ->where('orders.status', '=', 'pending')
            ->whereNotNull('orders.remainder')
            ->where('orders.remainder', '>', 0)
            ->where('orders.branch_id', $this->branch)
            ->where('customers.phone', '=', "$term")
            ->orWhere('orders.order_no', '=', $term)
            ->orWhere('orders.invoice_no', '=', $term)
            ->get();

        return response(['result' => $result]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function updatePayment(Request $request, Order $order)
    {
        $customer_orders = Order::where('customer_id', $request->customer)->where('status', 'pending')->get();
        $payment = $request->amount;

        foreach ($customer_orders as $order) {
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Order $order)
    {
        $sales = $order->sales()->delete();
        $order->delete();


        return response(['message' => 'Sales order deleted ']);
    }


    /**
     * Deptors
     */


    public function getDeptors()
    {
        $result = Order::where('status', 'pending')
            ->join('customers', 'orders.customer_id', 'customers.id')
            ->where('orders.branch_id', $this->branch)
            ->where('orders.remainder', '>', 0)
            ->take(50)->get();

        return response(['result' => $result]);
    }
}
