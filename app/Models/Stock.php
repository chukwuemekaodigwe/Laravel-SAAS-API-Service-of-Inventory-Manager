<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'qty', 'stockId', 'branch_id', 'from',
        'company_id', 'status', 'type', 'registered_by', 'received_by', 'brief_note'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public static function newStock($req, $product, $branch)
    {
        $stockId = '#' . Auth::user()->company->id . substr(time(), 5);
        $p = Product::find($product);

        $stock = $p->stocks()->create([
            'qty' => $req['qty'],
            'company_id' => Auth::user()->company->id,
            'branch_id' => $branch,
            'type' => $req['type'],
            'stockId' => $stockId,
            'brief_note' => $req['reason'],
            'registered_by' => Auth::user()->id,
            'status' => 1
        ]);

        return $stock;
    }

    public static function getQuantity($product)
    {
        return Stock::where('product_id', $product)->selectRaw('SUM(qty) as quantity')->get();
    }
}
