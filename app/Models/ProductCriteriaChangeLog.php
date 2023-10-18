<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCriteriaChangeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'criteria_name',
        'used_date',
        'value_from',
        'value_tovalue_to'
    ];
}
