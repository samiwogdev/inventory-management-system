<?php

namespace App\Observers;

use App\Models\OrderModel;
use App\Models\Product;

class OrderObserver
{
    /**
     * Handle the OrderModel "created" event.
     */
    public function created(OrderModel $orderModel): void
    {
        // Find the product associated with this order
        $product = Product::find($orderModel->productId);

        // Reduce the quantity of the product by the ordered quantity
        if ($product) {
            $product->quantity -= $orderModel->quantity;
            $product->save();
        }
    }

    /**
     * Handle the OrderModel "updated" event.
     */
    public function updated(OrderModel $orderModel): void
    {
        $product = Product::find($orderModel->productId);

        if ($product) {
            // Adjust the product quantity based on the updated order quantity
            $product->quantity += $orderModel->getOriginal('quantity') - $orderModel->quantity;
            $product->save();
        }
    }

    /**
     * Handle the OrderModel "deleted" event.
     */
    public function deleted(OrderModel $orderModel): void
    {
        $product = Product::find($orderModel->productId);

        if ($product) {
            // Restore the product quantity when the order is deleted
            $product->quantity += $orderModel->quantity;
            $product->save();
        }
    }

    /**
     * Handle the OrderModel "restored" event.
     */
    public function restored(OrderModel $orderModel): void
    {
        //
    }

    /**
     * Handle the OrderModel "force deleted" event.
     */
    public function forceDeleted(OrderModel $orderModel): void
    {
        //
    }
}
