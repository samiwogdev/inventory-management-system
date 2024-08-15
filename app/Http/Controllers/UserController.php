<?php

namespace App\Http\Controllers;
use Illuminate\support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\userModel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UserModel::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:30',
            'email' => 'required',
            'userRole' => 'required',
            'password' => 'required',
        ]);
        UserModel::create($request->all());
        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = UserModel::find($id);

        return view('users.show', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|max:30',
            'email' => 'required',
            'userRole' => 'required',
            'password' => 'required',
        ]);

        $users = UserModel::find($id);
        $users->update($request->all());

        return redirect()->route('users.index')
            ->with('success', 'user updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = UserModel::find($id);
        $users->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
