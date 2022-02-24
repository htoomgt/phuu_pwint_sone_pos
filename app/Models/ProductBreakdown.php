<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBreakdown extends Model
{
    use HasFactory;

    protected $table = "product_breakdown";

    protected $fillable = [
        'product_from',
        'product_to',
        'quantity_to_breakdown',
        'quantity_to_add',
    ];

    public function productFrom()
    {
        return $this->belongsTo(Product::class, 'product_from', 'id');
    }

    public function productTo(){
        return $this->belongsTo(Product::class, 'product_to', 'id');
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
