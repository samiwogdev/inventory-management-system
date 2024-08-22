<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SupplierController extends Controller
{
    public function showSupplierList()
    {
        $supplierList = Supplier::get();
        return view('admin.supplier.supplierList', compact('supplierList'));
    }

    public function showAddSupplier()
    {
        return view('admin.supplier.addSupplier');
    }

    public function showEditSupplier($id)
    {
        $supplier = Supplier::find($id);
        return view('admin.supplier.editSupplier', compact('supplier'));
    }


    public function updateSupplier(Request $request, $id)
    {
        // Find the supplier to be updated
        $supplier = Supplier::findOrFail($id);

        if ($request->isMethod('put')) {

            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:100|unique:suppliers,name',
                'phone' => [
                    'required',
                    'string',
                    'max:15',
                    'unique:suppliers,phone',
                    // 'regex:/^\+?[0-9]{10,15}$/'
                ],
                'email' => 'required|email|max:50|unique:suppliers,email',
                'address' => 'required|string|max:100',
            ]);

            // Update the supplier using the validated data
            $supplier->update([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
            ]);

            // Redirect to the edit page or another appropriate page
            return redirect()->route('admin.editSupplier', ['id' => $supplier->id])
                ->with('message', 'supplier updated successfully');
        }
    }


    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:100|unique:suppliers,name',
                'phone' => [
                    'required',
                    'string',
                    'max:15',
                    'unique:suppliers,phone',
                ],
                'email' => 'required|email|max:50|unique:suppliers,email',
                'address' => 'required|string|max:100',
            ]);

            // Create a new supplier using the validated data
            Supplier::create([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
            ]);

            return redirect()->back()->with('message', 'supplier added Succsessfully');
        }
    }

    public function deleteSupplier($id)
    {
        // Validate that the supplier exists
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect()->back()->with('error', 'supplier not found');
        }

        // Proceed with deletion if supplier exists
        $supplier->delete();

        return redirect()->back()->with('message', 'supplier deleted successfully');
    }
}
