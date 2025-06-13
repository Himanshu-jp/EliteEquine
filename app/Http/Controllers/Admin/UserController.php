<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Admin\UserService;
use DB;

class UserController extends Controller
{
    protected $userService;

    // Inject UserService
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $role = DB::table('roles')->select('id')->whereName('user')->first();
        // $users = User::where('role', $role->id)->orderBy('id', 'desc')->paginate(10);
        $query = User::where('role', $role->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('username', 'like', "%$search%")
                ->orWhere('phone_no', 'like', "%$search%")
                ->orWhere('country', 'like', "%$search%")
                ->orWhere('state', 'like', "%$search%")
                ->orWhere('city', 'like', "%$search%");
            });
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Use the service to get user details
        $user = $this->userService->getUserById($id);

        // Return the view with the user data
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $this->userService->delete($user);
        return redirect()->route('users.index')->with('success', 'User soft-deleted.');
    }

    // Restore a deleted category
    public function restore($id)
    {
        $this->userService->restore($id);
        return redirect()->route('users.index')->with('success', 'User restored successfully!');
    }
}
