<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showDashboard()
    {
        $totalOrders = OrderModel::count();
        $totalSales = OrderModel::sum('total');
        $totalProducts = Product::count();
        $totalCustomers = CustomerModel::count();
        
        $salesTrend = OrderModel::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total_sales')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->take(7)  // Last 7 days for simplicity
            ->get();

            $topSellingProducts = OrderModel::select('productId', DB::raw('SUM(quantity) as total_sold'))
            ->with('product:id,name')
            ->groupBy('ProductId')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

            $recentOrders = OrderModel::with('customer:id,name')
            ->latest()
            ->take(10)
            ->get();

            $lowStockThreshold = 10; // You can adjust this value as needed
            $lowStockProducts = Product::where('quantity', '<=', $lowStockThreshold)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 
            'totalSales', 
            'totalProducts', 
            'salesTrend',
            'totalCustomers',
            'topSellingProducts',
            'recentOrders',
            'lowStockProducts'
        ));
    }

    //zcheck admin password
    public function checkAdminPassword(Request $request)
    {
        $data = $request->all();
        if (Hash::check($data['currentPassword'], Auth::guard('admin')->user()->password)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    //update Admin Password
    public function updateAdminPassword(Request $request)
    {
        if ($request->isMethod('put')) {
            $data = $request->all();

            // Validate the input fields
            $request->validate([
                'currentPassword' => 'required|string|min:8',
                'newPassword' => 'required|string|min:8',
                'confirmPassword' => 'required|string|min:8',
            ]);
            //check if current password enter by Admin is correct
            if (!Hash::check($data['currentPassword'], Auth::guard('admin')->user()->password)) {
                return redirect()->back()->with('error_message', 'Your current password is incorrect');
            } else {
                //check if newPassword equals to confirmPassword
                if ($data['newPassword'] === $data['confirmPassword']) {
                    //update password
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' =>
                    bcrypt($data['newPassword'])]);
                    return redirect()->back()->with("message", "Password has been updated successfully");
                } else {
                    return redirect()->back()->with("error_message", "confirm password and new password does not match");
                }
            }
        }
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
    
            $rules = [
                'email' => 'required|email|max:225',
                'password' => 'required'
            ];
    
            $customMessage = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'password.required' => 'Password is required'
            ];
    
            $this->validate($request, $rules, $customMessage);
    
            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with("error_message", "Invalid email or password");
            }
        }
        return view('admin.login');
    }
    

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/logout');
    }

    public function viewUsers()
    {
        $allusers = Admin::get();
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
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:50|unique:admins,email',
                'password' => 'required|string|max:100',
            ]);
            Admin::create([
                'name' => $userData['name'],
                'type' => 'admin',
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),  // Hash the password here
                'status' => '2',
            ]);

            return redirect()->back()->with('message', 'User created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function showEditUsers()
    {
        $users = Admin::find(Auth::guard('admin')->user()->id);

        return view('admin.users.editUser', compact('users'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function deleteUser($id)
    {
        // Validate that the supplier exists
        $user = Admin::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'user not found');
        }

        // Proceed with deletion if user exists
        $user->delete();

        return redirect()->back()->with('message', 'user deleted successfully');
    }
}
