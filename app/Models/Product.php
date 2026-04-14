<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;


class Product extends Model
{
    protected $fillable = [
        'model',
        'size',
        'gender',
        'color',
        'purchase_price',
        'sale_price',
        'stock'
    ];
}
