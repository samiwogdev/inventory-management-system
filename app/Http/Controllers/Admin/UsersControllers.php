<?php

namespace App\Http\Controllers\Admin;

use App\Models\UsersModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewUsers()
    {
        $allusers = UsersModel::get();
        return view('admin.users.allUsers', compact('allusers'));
    }

    public function showAddUsers()
    {
        return view('admin.users.createUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $userData = $request->validate([
                'username' => 'required|string|max:30',
                'email' => 'required|email|max:50|unique:users,email',
                'userRole' => 'required',
                'password' => 'required|string|max:100',
            ]);
            UsersModel::create([
                'username' => $userData['username'],
                'email' => $userData['email'],
                'userRole' => $userData['userRole'],
                'password' => $userData['password'],
            ]);

            return redirect()->back()->with('message', 'User created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function showEditUsers($id)
    {
        $users = UsersModel::find($id);

        return view('admin.users.editUser', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request, $id)
    {
        // find user by id
        $users = UsersModel::findOrFail($id);
        if ($request->isMethod('put')) {
            $userData = $request->validate([
                'username' => 'required|string|max:30',
                'email' => 'required|email|max:50|unique:users,email',
                'userRole' => 'required|string',
                'password' => 'required',
            ]);

            // update the users data using validated input
            $users->update([
                'username' => $userData['username'],
                'email' => $userData['email'],
                'userRole' => $userData['userRole'],
                'password' => $userData['password'],
            ]);

            // redirect
            return redirect()->route('admin.editUser', ['id' => $users->id])
            // return redirect()->route('admin.users.editUser', ['id' => $users->$id])
                ->with('message', 'user updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteUser($id)
    {
        // Validate that the supplier exists
        $user = UsersModel::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'user not found');
        }

        // Proceed with deletion if user exists
        $user->delete();

        return redirect()->back()->with('message', 'user deleted successfully');
    }
}

