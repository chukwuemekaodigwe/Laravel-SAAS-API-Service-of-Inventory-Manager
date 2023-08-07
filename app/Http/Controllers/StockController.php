<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class StockController extends Controller
{
    /**
     * For dipalying records based on the active company branch
     */

    protected $branch;

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

        $stocks = Auth::user()->company->stocks()
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->where('stocks.branch_id', $this->branch)
            ->where('stocks.status', 1)
            ->orderBy('stocks.updated_at', 'desc')

            ->select('products.name', 'products.sku', 'stocks.*')
            ->paginate($no);

        return response(['result' => $stocks]);
    }

    /**
     * Get result by date - Single date
     */

    public function getStockByDate(Request $request)
    {
        $type =  $request->type;

        $no = isset($request->per_page) ? $request->per_page : '30';

        $stocks = Stock::where('stocks.company_id', Auth::user()->company_id)
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('users', 'stocks.registered_by', '=', 'users.id')
            ->join('branches', 'stocks.branch_id', '=', 'branches.id')
            ->select('products.name', 'products.sku', 'stocks.*')
            ->where('stocks.branch_id', $this->branch)
            ->whereDate('stocks.updated_at', date('Y-m-d H:i:s', strtotime($request->start)))
            ->where(function ($query) use ($type, $request) {
                if (!empty($type) && ($type != 1)) {
                    $query->where('stocks.type', $type);
                }
                if ($type == 2) {
                    $query->where('status', '<', 3);
                        //->where('stocks.from', $this->branch);
                } else {
                    $query->where('status', 1);
                }

                if ($request->type == 4) {
                    $query->where('status', 2);
                }
            })
            ->orderby('stocks.updated_at', 'desc')
            ->paginate($no);

        return response(['result' => $stocks]);
    }

    /**
     * Stock by date ranges
     */

    public function getStockByRange(Request $request)
    {
        $type =  $request->type;
        $no = isset($request->per_page) ? $request->per_page : '30';
        $stocks = Stock::where('stocks.company_id', Auth::user()->company_id)
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('users', 'stocks.registered_by', '=', 'users.id')
            ->join('branches', 'stocks.branch_id', '=', 'branches.id')
            ->where('stocks.branch_id', $this->branch)

            ->whereBetween('stocks.updated_at', [date('Y-m-d', strtotime($request->start)), date('Y-m-d', (strtotime($request->end) + (60 * 24 * 60)))])
            ->where(function ($query) use ($type, $request) {
                if (!empty($type) && ($type != 1)) {
                    $query->where('stocks.type', $type);
                }
                if ($type == 2) {
                    $query->where('status', '<', 3);
                        //->where('stocks.from', $this->branch);
                } else {
                    $query->where('status', 1);
                }

                if ($request->type == 4) {
                    $query->where('status', 2);
                }
            });

        $stocks->orderBy('stocks.updated_at', 'desc');
        $stocks->select('products.name', 'products.sku', 'stocks.*');

        $result = $stocks->paginate($no);

        return response(['result' => $result]);
    }



    /** Search result */


    public function searchStock(Request $request)
    {
        $type =  ($request->type == 4) ? 2 : $request->type;

        $term = $request->searchKey;
        $no = isset($request->per_page) ? $request->per_page : '30';
        //return response(['term'=>$term]);
        $result = Auth::user()->company->stocks()
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('branches', 'branches.id', '=', 'stocks.branch_id')
            ->join('users', 'stocks.registered_by', '=', 'users.id')
            ->select('products.name', 'products.sku', 'stocks.*')
            ->where('stocks.branch_id', $this->branch)
            ->where(function ($query) use ($type, $request) {
                if (!empty($type) && ($type != 1)) {
                    $query->where('stocks.type', $type);
                }
                if ($type == 2) {
                    $query->where('status', '<', 3);
                        //->where('stocks.from', $this->branch);
                } else {
                    $query->where('status', 1);
                }

                if ($request->type == 4) {
                    $query->where('status', 2);
                }
            })

            ->where(function ($query) use ($term) {
                $query->where('products.name', 'Like', "%$term%")
                    ->orWhere('products.sku', 'Like', "%$term%")
                    ->orWhere('stocks.stockId', 'Like', "%$term%")
                    ->orWhere('stocks.qty', 'Like', "%$term%")
                    ->orWhere('users.name', 'Like', "%$term%")
                    ->orWhere('branches.title', 'Like', "%$term%");
            })
            ->orderby('stocks.updated_at', 'desc')
            ->paginate($no);

        return response(['result' => $result], 200);
    }


    public function store(Request $request)
    {
        $stocks = [];
        $stockId = '#' . Auth::user()->company->id . substr(time(), 5);
        // return response($stockId, 500);
        foreach ($request->selected as $item) {

            $payload = [
                'qty' => $item['qty'],
                'type' => 1,
                'reason' => $request->reason
            ];

            $stock = Stock::newStock($payload, $item['id'], $this->branch);

            $stocks[] = $stock;
        }

        return response(['result' => $stocks, 'count' => count($stocks)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */

    public function updateStock(Request $request)
    {
        $payload = $request->payload;

        //  return response(['payload'=>$payload]);
        $oldStock = Stock::find($payload['id']);

        $upd = $oldStock->update([
            'qty' => $payload['qty'],
            'product_id' => $payload['product']['id'],

            'branch_id' => $payload['branch'],
            'brief_note' => $payload['reason'],
            'registered_by' => Auth::user()->id
        ]);

        return response(['update' => $upd]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return response(['message' => 'successful deleted']);
    }

    /**
     * Remove some stock from inventory due to either damage or loss
     */

    public function removeStock(Request $request)
    {
        $stocks = [];
        $stockId = '#' . Auth::user()->company->id . substr(time(), 5);
        foreach ($request->selected as $item) {
            $product = Product::find($item['id']);

            $stock = $product->stocks()->create([
                'qty' => -$item['qty'],
                'company_id' => Auth::user()->company->id,
                'branch_id' => $this->branch,
                'type' => 3,
                'stockId' => $stockId,
                'brief_note' => $request->reason,
                'registered_by' => Auth::user()->id,
                'status' => 1
            ]);

            $stocks[] = $stock;
        }

        return response()->json(['count' => count($stocks), 'message' => 'successfully removed']);
    }


    public function transferStock(Request $request)
    {
        $stockId = '#' . Auth::user()->company->id . substr(time(), 5);
        $stocks = [];

        foreach ($request->selected as $item) {
            $product = Product::find($item['id']);
            //return response(['data'=> $product], 500);
            $stock = $product->stocks()->createMany([
                [
                    'qty' => (-$item['qty']),
                    'company_id' => Auth::user()->company->id,
                    'branch_id' => $request->from,
                    'type' => 1,
                    'stockId' => $stockId,
                    'brief_note' => $request->reason,
                    'registered_by' => Auth::user()->id,
                    'status' => 3,

                ],
                [
                    'qty' => $item['qty'],
                    'company_id' => Auth::user()->company->id,
                    'branch_id' => $request->to,
                    'type' => 2,
                    'stockId' => $stockId,
                    'brief_note' => $request->reason,
                    'registered_by' => Auth::user()->id,
                    'status' => 2,
                    'from' => $request->from
                ]
            ]);
            $stocks[] = $stock;
        }

        return response()->json(['count' => $stocks, 'message' => 'successfully']);
    }

    public function approveTransfer(Request $request)
    {
        foreach ($request->stocks as $stock) {
            $tock = Stock::find($stock);
            $tock->update([
                'status' => 1,
                'received_by' => Auth::user()->id
            ]);
        }

        return response(['message' => 'successful']);
    }

    public function getTransferStocks(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $stocks = Auth::user()->company->stocks()
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->where('stocks.type', '=', 2)
            ->where('stocks.branch_id', $this->branch)
            //->where('stocks.from', $this->branch)
            ->orderBy('stocks.id', 'desc')
            ->groupBy('stocks.stockId', 'stocks.id')
            ->select(
                'products.name',
                'products.sku',
                'stocks.*',

            ) //, 'b.name as receiver')
            ->paginate($no);
        //->toSql();
        return response(['result' => $stocks]);
    }

    public function getPendingTransfer(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $stocks = Auth::user()->company->stocks()
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->where('stocks.type', '=', 2)
            ->where('stocks.branch_id', $this->branch)

            ->where('stocks.status', 2)
            ->orderBy('stocks.id', 'desc')

            ->select(
                'products.name',
                'products.sku',
                'stocks.*',

            )
            ->paginate($no);

        return response(['result' => $stocks]);
    }


    public function getRemovedStocks(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $stocks = Auth::user()->company->stocks()
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('users as a', 'stocks.registered_by', '=', 'a.id')
            //->join('users as b', 'stocks.received_by', '=', 'b.id')
            ->join('branches as to', 'stocks.branch_id', '=', 'to.id')
            // ->join('branches as from', 'stocks.from', '=', 'from.id')
            ->where('stocks.branch_id', $this->branch)
            ->where('stocks.type', '=', '3')
            ->orderBy('stocks.id', 'desc')
            ->groupBy('stocks.stockId', 'stocks.id')
            ->select(
                'products.name',
                'products.sku',
                'stocks.*',
                'to.title as title',
                'a.name as employee'
            ) //, 'b.name as receiver')
            ->paginate($no);

        return response(['result' => $stocks]);
    }


    public function getStockQty(Request $request)
    {
        $no = isset($request->per_page) ? $request->per_page : '30';
        $stocks = Auth::user()->company->stocks()
            ->join('sales', 'sales.product_id', '=', 'stocks.product_id')
            ->join('products', 'products.id', 'stocks.product_id')
            ->where('stocks.branch_id', $this->branch)
            ->orderby('products.name', 'asc')
            ->groupBy('stocks.product_id')
            ->get([
                'stocks.product_id',
                'products.*',
                DB::raw('SUM(stocks.qty) as stockQty'),
                DB::raw('SUM(sales.qty) as salesQty')
            ]);
        $stocks = $stocks->paginate($no)->toArray();
        return response(['result' => $stocks]);
    }


    public function getProductQty(Request $request)
    {

        $stocks = Auth::user()->company->stocks()->join('products', 'products.id', 'stocks.product_id')->groupby('stocks.product_id')->selectRaw('stocks.product_id, sum(stocks.qty) as qty, products.costprice, products.sellingprice')->where('stocks.branch_id', $this->branch)->get();
        $sales = Auth::user()->company->sales()->groupby('sales.product_id')->selectRaw('sales.product_id, sum(sales.qty) as qty')->where('sales.branch_id', $this->branch)->get();

        return response(['stocks' => $stocks, 'sales' => $sales]);
    }
}
