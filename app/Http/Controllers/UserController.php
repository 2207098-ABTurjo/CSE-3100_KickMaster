<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

// Ei controller admin panel theke user manage korar jonno (role change, delete)
class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%');
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Admin user er role change korte pare (admin/user)
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,user',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User successfully updated!');
    }

    public function destroy(User $user)
    {
        // Nijer account delete korte dewa hobe na
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}