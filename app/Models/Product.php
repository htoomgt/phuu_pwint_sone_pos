<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // protected $table = 'products as pdt';


    protected $fillable = [
        'name',
        'myanmar_name',
        'category_id',
        'product_code',
        'measure_unit_id',
        'reorder_level',
        'unit_price',
        'ex_mill_price',
        'transport_fee',
        'unload_fee',
        'original_cost',
        'profit_per_unit',
        'breakdown_parent',
        'breadown_parent_full_multiplier',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];


    public function productBreakdownParent()
    {
        return $this->belongsTo('App\Models\Product', 'breakdown_parent', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function measure_unit()
    {
        return $this->belongsTo(ProductMeasureUnit::class, 'measure_unit_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
