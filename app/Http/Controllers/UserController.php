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
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,cashier',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users')->with('success', 'User created successfully.');
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
    public function edit(id $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, id $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(id $id)
    {
        //
    }
}
