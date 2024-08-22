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
        'description',
        'status',
        'orderDate',
    ];

    // The customer() method defines a one-to-many relationship between the Order and Customer models, where one customer can have multiple orders.
    public function customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customerId');
    }

    // defining a one-to-many relationship between the Order and Product models, 
    // where one product can be associated with multiple orders.
    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'productId');
    // }
}
