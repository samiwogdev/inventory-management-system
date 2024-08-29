<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;

    protected $guard = 'admin';

    protected $table = 'orders';

    protected $fillable = [
        'customerId',
        'productId',
        'quantity',
        'total',
        'description',
        'status',
        'orderDate',
    ];

    // The customer() method defines a one-to-many relationship between the Order and Customer models, where one customer can have multiple orders.
    public function customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customerId');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
