<?php

namespace App\Http\Controllers\Admin;


use App\Models\CustomerModel;
use Illuminate\Http\Request;
use App\Models\OrderModel;

use App\Http\Controllers\Controller;
use App\Models\Product;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewOrders()
    {
        $orders = OrderModel::get();
        return view('admin.orders.viewOrders', compact('orders'));
    }

    /**
     * dispaly form to add a new order.
     */
    public function showAddOrder()
    {
        $customers = CustomerModel::all();
        $products = Product::all();
        return view('admin.orders.createOrder', compact('customers', 'products'));
    }

    /**
     * create a new order.
     */
    public function createOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            $orderData = $request->validate([
                'customerId' => 'required|exists:customers,id',
                'productId' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'description' => 'required|string',
                'orderDate' => 'required|date',
            ]);

            OrderModel::create([
                'customerId' => $orderData['customerId'],
                'productId' => $orderData['productId'],
                'quantity' => $orderData['quantity'],
                'description' => $orderData['description'],
                'status' => 'pending',
                'orderDate' => $orderData['orderDate'],
            ]);

            return redirect()->back()->with('message', 'Order created successfully.');
        }
    }

    /**
     * display the form to edit an order.
     */
    public function showEditOrder(Request $request, string $id)
    {
        $order = OrderModel::find($id);
        return view('admin.orders.editOrder', compact('orders'));
    }

    // edit an order
    public function updateOrder(Request $request, $id)
    {
        // find an order by id
        $order = OrderModel::findOrFail($id);
        if($request->isMethod('put')) {
            $orders = $request->validate([
                'customerId' => 'required|exists:customers,id',
                'productId' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'description' => 'required|string',
                'status' => 'required|in:pending,approved,delivered',
                'orderDate' => 'required|date',
            ]);

            // update the order accordingly
            $order->update([
                'customerId' => $orders['customerId'],
                'productId' => $orders['productId'],
                'quantity' => $orders['quantity'],
                'description' => $orders['description'],
                'status' => $orders['status'],
                'orderDate' => $orders['orderDate'],
            ]);

            return redirect()->route('admin.editOrder', ['id' => $order->$id])
                ->with('message', 'order updated successfully');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function deleteOrder($id)
    {
        // Validate that the supplier exists
        $order = OrderModel::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'order not found');
        }

        // Proceed with deletion if user exists
        $order->delete();

        return redirect()->back()->with('message', 'order deleted successfully');
    }
}
