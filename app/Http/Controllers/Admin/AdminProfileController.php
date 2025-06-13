<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use App\Services\Admin\AdminProfileService;

class AdminProfileController extends Controller
{
    protected $service;

    public function __construct(AdminProfileService $service)
    {
        $this->service = $service;
    }

    public function edit()
    {
        $admin = auth()->user();
        return view('admin.profile.profile', compact('admin'));
    }

    public function update(UpdateAdminProfileRequest $request)
    {
        $this->service->updateProfile($request->validated());

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
