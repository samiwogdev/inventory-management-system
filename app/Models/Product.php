<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guard = 'admin';

    protected $fillable = [
        'supplier_id',
        'category_id',
        'name',
        'sku',
        'unitPrice',
        'quantity',
        'reorderLevel',
        'description'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
