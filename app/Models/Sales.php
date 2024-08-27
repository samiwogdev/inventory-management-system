<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table = 'orders';

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customerId');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
