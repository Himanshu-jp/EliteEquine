<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function getUsersByRole(string $role = 'user')
    {
        return User::where('role', $role)->paginate(10);
    }

    /**
     * Get the details of a specific user by ID.
     *
     * @param  int  $userId
     * @return \App\Models\User
     */
    public function getUserById(int $userId)
    {
        return User::findOrFail($userId);
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function restore(int $id): void
    {
        User::withTrashed()->findOrFail($id)->restore();
    }
}
