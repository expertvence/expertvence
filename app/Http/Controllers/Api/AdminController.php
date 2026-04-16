<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Get all users (Admin Panel)
     */
    public function getAllUsers(Request $request)
    {
        $users = User::paginate(15);
        
        return response()->json([
            'success' => true,
            'data' => $users,
            'message' => 'Users retrieved successfully'
        ]);
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboard()
    {
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $superAdminCount = User::where('role', 'super_admin')->count();
        $userCount = User::where('role', 'user')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_users' => $totalUsers,
                'admins' => $adminCount,
                'super_admins' => $superAdminCount,
                'regular_users' => $userCount
            ],
            'message' => 'Dashboard data retrieved successfully'
        ]);
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, $userId)
    {
        $request->validate([
            'role' => ['required', Rule::in('user', 'admin', 'super_admin')]
        ]);

        $user = User::findOrFail($userId);
        $user->update(['role' => $request->role]);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User role updated successfully'
        ]);
    }

    /**
     * Delete a user
     */
    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        // Prevent deletion of super admin by non-super-admin
        if ($user->role === 'super_admin' && auth('api')->user()->role !== 'super_admin') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete super admin users'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * Get user details
     */
    public function getUserDetails($userId)
    {
        $user = User::findOrFail($userId);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User retrieved successfully'
        ]);
    }
}
