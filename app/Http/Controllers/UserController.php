<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.user', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,cashier',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role,
            ]);

            return redirect()->route('users')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users')->with('error', 'Failed to create user.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(id $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:admin,cashier',
            'password' => 'nullable|string|min:8', // Password is optional
        ]);

        try {
            $user = User::findOrFail($id);
            $data = $request->only('name', 'email', 'role');

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return redirect()->route('users')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users')->with('error', 'Failed to update user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('users')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users')->with('error', 'Failed to delete user.');
        }
    }
}
