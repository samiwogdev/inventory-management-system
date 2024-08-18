<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showCategoryList()
    {
        $categoryList = Category::get();
        return view('admin.categoryList', compact('categoryList'));
    }

    public function showAddCategory()
    {
        return view('admin.addCategory');
    }

    public function showEditCategory($id)
    {
        $category = Category::find($id);
        return view('admin.editCategory', compact('category'));
    }


    public function updateCategory(Request $request, $id)
    {
        // Find the category to be updated
        $category = Category::findOrFail($id);

        if ($request->isMethod('put')) {

            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'required|string|max:500',
            ]);

            // Update the category using the validated data
            $category->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);

            // Redirect to the edit page or another appropriate page
            return redirect()->route('admin.editCategory', ['id' => $category->id])
                ->with('message', 'Category updated successfully');
        }
    }


    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'required|string|max:500',
            ]);

            // Create a new category using the validated data
            $category = Category::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);

            return redirect()->back()->with('message', 'Category added Succsessfully');
        }
    }

    public function deleteCategory($id)
    {
        // Validate that the category exists
        $category = Category::find($id);
    
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }
    
        // Proceed with deletion if category exists
        $category->delete();
    
        return redirect()->back()->with('message', 'Category deleted successfully');
    }
    

}
