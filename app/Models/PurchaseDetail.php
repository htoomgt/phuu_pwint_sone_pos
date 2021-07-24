<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'purchase_id', 'product_code', 'measure_unit', 'quantity'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
