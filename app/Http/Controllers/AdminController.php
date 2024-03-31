<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function getUsers() {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function updateRole(Request $request, $id) {
        $request->validate([
            'role' => 'required|in:user,admin', // Validate role
        ]);
    
        $user = User::find($id);
        if ($user) {
            $user->role = $request->role;
            $user->save();
        }
    
        return redirect()->route('admin.dashboard')->with('message', 'The role has been updated successfully!');
    }

}
