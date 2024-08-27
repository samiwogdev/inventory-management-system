<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderModel;
use App\Models\Product;

class SalesController extends Controller
{
    public function viewSales()
    {
        // Retrieve all Sales from product table
        $sales = OrderModel::where('status', 'delivered')->get();
        return view('admin.sales.salesList', compact('sales'));
    }
}
