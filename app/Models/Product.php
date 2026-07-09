<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use app\Models\Category;

#[Fillable([
    'category_id',
    'name',
    'sku',
    'description',
    'price',
    'quantity',
    'image',
    'status',
])]
class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
