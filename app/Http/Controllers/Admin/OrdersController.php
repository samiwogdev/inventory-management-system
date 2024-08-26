<?php

namespace App\Http\Controllers\Admin;


use App\Models\CustomerModel;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{

    // Check Product Reorder Level
    protected function checkReorderLevel()
    {
        // Retrieve all products that need restocking
        $products = Product::where('quantity', '<=', 'reorderLevel')->get();
        
        // Loop through the products and create notifications
        foreach ($products as $product) {
            $notification = new Notification();
            $notification->data = "The product {$product->name} needs to be restocked.";
            $notification->read = false; // Mark the notification as unread
            $notification->save();
        }
    }


    //update order Status
    public function updateStatus(Request $request, $id)
    {
        // Check if the request is using the PUT method
        if ($request->isMethod('put')) {
            // Retrieve the authenticated admin user
            $admin = Auth::guard('admin')->user();
            // Check if the admin has the required status to perform this action
            if ($admin && $admin->status === 1) {
                // Find the order by ID
                $order = OrderModel::find($id);
                // Check if the order exists
                if ($order && $order->status !== "approved") {
                    // Update the order status
                    $order->update(['status' => 'approved']);
                    //Trigger check Product reUrder level
                    $this->checkReorderLevel();
                    // Redirect back with a success message
                    return redirect()->back()->with('message', 'Order updated successfully.');
                } else {
                    // Redirect back with an error message if the order was not found
                    return redirect()->back()->with('error', 'Order not found or Order has already been Approved.');
                }
            } elseif ($admin && $admin->status === 2) {
                // Find the order by ID
                $order = OrderModel::find($id);
                // Check if the order exists
                if ($order && $order->status !== "delivered") {
                    // Update the order status
                    $order->update(['status' => 'delivered']);

                    // Redirect back with a success message
                    return redirect()->back()->with('message', 'Order updated successfully.');
                } else {
                    // Redirect back with an error message if the order was not found
                    return redirect()->back()->with('error', 'Order not found or Order has already been Delivered.');
                }
            } else {

                // Redirect back with an error message if the admin does not have permission
                return redirect()->back()->with('error', 'Unauthorized action.');
            }
        } else {
            // Redirect back with an error message if the request method is not PUT
            return redirect()->back()->with('error', 'Invalid request method.');
        }
    }

    //create new Order
    public function createOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the incoming request data
            $orderData = $request->validate([
                'customerId' => 'required|exists:customers,id',
                'productId' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'description' => 'required|string',
                'orderDate' => 'required|date',
            ]);

            // Retrieve the product and check its available quantity
            $product = Product::find($orderData['productId']);

            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            if ($product->quantity < $orderData['quantity']) {
                // If the product quantity is less than the requested quantity, return an error message
                return redirect()->back()->with('error', 'Insufficient product quantity. Only ' . $product->quantity . ' units available.');
            }
            // If sufficient quantity is available, create the order
            OrderModel::create([
                'customerId' => $orderData['customerId'],
                'productId' => $orderData['productId'],
                'quantity' => $orderData['quantity'],
                'description' => $orderData['description'],
                'status' => 'pending',
                'orderDate' => $orderData['orderDate'],
            ]);
            //Trigger check Product reUrder level
            $this->checkReorderLevel();
            // Optionally, product quantity can be reduced here instead of using the observer
            // $product->quantity -= $orderData['quantity'];
            // $product->save();

            return redirect()->back()->with('message', 'Order created successfully.');
        }
    }

    // Display a listing of the resource.
    public function viewOrders()
    {
        // Retrieve orders where the status is not 'delivered'
        $orders = OrderModel::where('status', '!=', 'delivered')->get();

        // Return the view with the filtered orders
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
     * display the form to edit an order.
     */
    public function showEditOrder($id)
    {
        $order = OrderModel::find($id);
        $customers = CustomerModel::all();
        $products = Product::all();
        return view('admin.orders.editOrder', compact('order', 'customers', 'products'));
    }


    // edit an order
    public function updateOrder(Request $request, $id)
    {
        // find an order by id
        $order = OrderModel::findOrFail($id);
        if ($request->isMethod('put')) {
            $orders = $request->validate([
                'customerId' => 'required|exists:customers,id',
                'productId' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'description' => 'required|string',
                'orderDate' => 'required|date',
            ]);

            // update the order accordingly
            $order->update([
                'customerId' => $orders['customerId'],
                'productId' => $orders['productId'],
                'quantity' => $orders['quantity'],
                'description' => $orders['description'],
                'orderDate' => $orders['orderDate'],
            ]);

            //Trigger check Product reUrder level
            $this->checkReorderLevel();
            return redirect()->route('admin.editOrder', ['id' => $order->id])
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
