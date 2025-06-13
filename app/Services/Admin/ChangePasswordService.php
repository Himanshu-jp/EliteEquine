<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordService
{
    // Change the admin password
    public function changePassword($request)
    {
        $user = auth()->user();

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            throw new \Exception('Current password is incorrect');
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();
    }
}
