<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showproductList()
    {
        $productList = Product::get();
        return view('admin.product.productList', compact('productList'));
    }

    public function showaddProduct()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.product.addProduct', compact('categories', 'suppliers'));
    }

    public function showeditProduct($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.product.editProduct', compact('categories', 'suppliers', 'product'));
    }


    public function updateProduct(Request $request, $id)
    {
        // Find the product to be updated
        $product = Product::findOrFail($id);

        if ($request->isMethod('put')) {

            // Validate the request data
            $validatedData = $request->validate([
                'supplier_id' => 'required|integer|exists:suppliers,id|not_in:-1',
                'category_id' => 'required|integer|exists:categories,id|not_in:-1',
                'name' => 'required|string|max:100',
                'sku' => 'required|string|max:50',
                'unitPrice' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'reorderLevel' => 'required|integer|min:0',
                'description' => 'nullable|string|max:500',
            ]);

            // Update the product using the validated data
            $product->update([
                'supplier_id' => $validatedData['supplier_id'],
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'sku' => $validatedData['sku'],
                'unitPrice' => $validatedData['unitPrice'],
                'quantity' => $validatedData['quantity'],
                'reorderLevel' => $validatedData['reorderLevel'],
                'description' => $validatedData['description'],
            ]);

            // Redirect to the edit page or another appropriate page
            return redirect()->route('admin.editProduct', ['id' => $product->id])
                ->with('message', 'product updated successfully');
        }
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            // Validate the request data
            $validatedData = $request->validate([
                'supplier_id' => 'required|integer|exists:suppliers,id',
                'category_id' => 'required|integer|exists:categories,id',
                'name' => 'required|string|max:100|unique:products,name',
               'sku' => 'required|string|min:6|max:6',
                'unitPrice' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'reorderLevel' => 'required|integer|min:0',
                'description' => 'nullable|string|max:500',
            ]);

            // dd($validatedData);

            // Create a new product using the validated data
            Product::create([
                'supplier_id' => $validatedData['supplier_id'],
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'sku' => $validatedData['sku'],
                'unitPrice' => $validatedData['unitPrice'],
                'quantity' => $validatedData['quantity'],
                'reorderLevel' => $validatedData['reorderLevel'],
                'description' => $validatedData['description'],
            ]);

            return redirect()->back()->with('message', 'product added Succsessfully');
        }
    }

    public function deleteproduct($id)
    {
        // Validate that the product exists
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'product not found');
        }

        // Proceed with deletion if product exists
        $product->delete();

        return redirect()->back()->with('message', 'product deleted successfully');
    }
}
