<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view("users.index", compact('users'));
    }

    public function detail($id)
    {
        $user = User::find($id);
        return view("users.detail", compact('user'));
    }

    public function updateRole($id, Request $request)
    {
        $user = User::find($id);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->route('users')->with('success', 'Success update user\'s role');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return redirect()->route('users')->with('success', 'Success remove user from system');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make('password123');
        $user->save();

        return redirect()->route('users')->with('success', 'Password reset to password123.');
    }
}
