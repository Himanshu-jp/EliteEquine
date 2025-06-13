<?php
namespace App\Services\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminProfileService
{
    public function updateProfile(array $data)
    {
        $admin = Auth::user();

        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->username = $data['username'];
        $admin->phone_no = $data['phone'];

        if (isset($data['profile_image']) && $data['profile_image']->isValid()) {
            // Delete old image if it exists
            if (!empty($admin->profile_photo_path) && Storage::disk('public')->exists($admin->profile_photo_path)) {
                Storage::disk('public')->delete($admin->profile_photo_path);
            }
        
            // Store new image and update path
            $admin->profile_photo_path = $data['profile_image']->store('profile_images', 'public');
        }

        $admin->save();

        return $admin;
    }
}

