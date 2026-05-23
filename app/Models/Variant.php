<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $primaryKey = 'variant_id';

    protected $fillable = [
        'product_id',
        'size',
        'colour',
        'stock_qty',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}