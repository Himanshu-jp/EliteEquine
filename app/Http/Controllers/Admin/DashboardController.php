<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Product;
use App\Models\ContactUs;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionAddOnPlan;
use App\Models\User;
use App\Models\SubCategory;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.login');
    }

    /**
     * Show dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::withoutTrashed()->whereRole('2')->count();
        $totalBlogs = Blog::withoutTrashed()->count();
        $totalProducts = Product::withoutTrashed()->count();
        // $subscriptionUsers = User::has('subscriptions')->count();
        $totalEnquiries = ContactUs::withoutTrashed()->count();
        $soldProducts = Product::withoutTrashed()->where('product_status', 'sold')->count();
        $expiredProducts = Product::withoutTrashed()->where('product_status', 'expire')->count();
        $liveProducts = Product::withoutTrashed()->where('product_status', 'live')->count();
        $totalSubscriptions = SubscriptionPlan::withoutTrashed()->count();
        $totalAddons = SubscriptionAddOnPlan::withoutTrashed()->count();
        $totalCategories = Category::withoutTrashed()->count();
        $totalSubcategories = SubCategory::withoutTrashed()->count();

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalBlogs',
            'totalUsers',
            'totalSubscriptions',
            // 'subscriptionUsers',
            'totalEnquiries',
            'soldProducts',
            'expiredProducts',
            'liveProducts',
            'totalAddons',
            'totalSubcategories'
        ));
    }

    /**
     * Show login form
     */
    public function loginView()
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Handle login request
     */
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $role = \DB::table('roles')->select('id')->where('name', 'admin')->first();
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password) &&
            ($user->hasRole('admin') || $user->role == $role->id)) {

            if (Auth::attempt($credentials)) {
                return redirect()->route('admin.dashboard')->with('success', 'You are successfully logged in!');
            }

            return redirect()->route('home');
        }

        return back()->withErrors(['error' => 'The credentials are incorrect or you are not an admin.']);
    }

    /**
     * Logout the admin
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
