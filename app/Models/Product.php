<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // protected $table = 'products as pdt';


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
