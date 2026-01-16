<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * List user (admin dulu, lalu nama ASC)
     */
    public function index()
    {
        $users = User::withTrashed()
            ->orderByRaw("role = 'admin' DESC")
            ->orderBy('name', 'asc')
            ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Soft delete user
     */
    public function destroy(User $user)
    {
        if ($user->id === auth::id()) {
            return back()->withErrors('Anda tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dinonaktifkan');
    }

    /**
     * Restore user
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return back()->with('success', 'User berhasil dipulihkan');
    }
}
