<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;

class CustomersController extends Controller
{
    
    public function viewCustomers()
    {
        $Customers = CustomerModel::get();
        return view('admin.customer.viewCustomer', compact('Customers'));
    }

    public function addCustomers()
    {
        return view('admin.customer.addCustomer');
    }

    public function searchEditCustomer($id)
    {
        $customers = CustomerModel::find($id);
        return view('admin.customers.editCustomer', compact('customers'));
    }


    public function updateCustomer(Request $request, $id)
    {
        // ensure the customer exists
        $customers = CustomerModel::findOrFail($id);

        if ($request->isMethod('put')) {
            $customerData = $request->validate([
                'name' => 'required|string|max:100|unique:customers,name',
                'address' => 'required|string|max:100',
                'email' => 'required|email|max:50|unique:customers,email',
            ]);

            // Update customer data
            $customers->update([
                'name' => $customerData['name'],
                'address' => $customerData['address'],
                'email' => $customerData['email'],
            ]);

            // Redirect
            return redirect()->route('admin.customers.modifyCustomer', ['id' => $customers->id])
                ->with('message', 'customer updated successfully');
        }
    }


    public function storeCustomer(Request $request)
    {
        if ($request->isMethod('post')) {

            // Validate data
            $customerData = $request->validate([
                'name' => 'required|string|max:100|unique:customers,name',
                'address' => 'required|string|max:100',
                'email' => 'required|email|max:50|unique:customers,email',
            ]);

            // Create a new supplier using the validated data
            CustomerModel::create([
                'name' => $customerData['name'],
                'address' => $customerData['address'],
                'email' => $customerData['email'],
            ]);

            return redirect()->back()->with('message', 'customer added Succsessfully');
        }
    }

    public function deleteCustomer($id)
    {
        // Validate that the supplier exists
        $customer = CustomerModel::find($id);

        if (!$customer) {
            return redirect()->back()->with('error', 'customer not found');
        }

        // Proceed with deletion if supplier exists
        $customer->delete();

        return redirect()->back()->with('message', 'customer deleted successfully');
    }
}
