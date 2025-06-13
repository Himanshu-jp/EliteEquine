<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Services\Admin\ChangePasswordService;

class AdminPasswordController extends Controller
{
    protected $changePasswordService;

    public function __construct(ChangePasswordService $changePasswordService)
    {
        $this->changePasswordService = $changePasswordService;
    }

    // Show the change password form
    public function edit()
    {
        return view('admin.profile.update-password');
    }

    // Handle the password change
    public function update(ChangePasswordRequest $request)
    {
        $this->changePasswordService->changePassword($request);

        return redirect()->route('admin.dashboard')->with('success', 'Password changed successfully.');
    }
}
